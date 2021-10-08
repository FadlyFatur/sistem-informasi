<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\acara;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use DataTables;

class beritaController extends Controller
{
    // menampilkan berita di halaman berita
    public function index()
    {
        $data = acara::where('status', '1')->orderBy('created_at', 'desc')->paginate(30);
        return view('berita.listBerita', compact('data'));
    }

    public function show($slug)
    {
        $data = acara::where('slug', $slug)->first();
        // dd($data['judul']);
        return view('berita.berita', compact('data'));
    }

    // menampilkan list berita di halaman admin 
    public function adminIndex(Request $request)
    {
        // if(!empty(Auth::user()->verified_at)){
        $cari = $request->cari;

        if ($cari) {
            $data = acara::where('judul', 'like', '%' . $request->cari . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(50);
            $total_data = $data->count();
        } else {
            $data = acara::orderBy('created_at', 'desc')->paginate(20);
            $total_data = acara::all()->count();
        }
        return view('manajemen.editAcara', compact('data', 'total_data'));
        // }else{
        //     return redirect('profil')->with(['gagal' => 'Akun belum terverifikasi, Harap hubungi admin untuk verifikasi']);
        // }
    }

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'string|max:200',
            'deskripsi' => 'string|max:10000',
            'image' => 'required|image|max:10240',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                //upload file ke local storage
                $name = date("his_") . $request->image->getClientOriginalName();
                $url = $request->image->storeAs('acara', $name);

                // upload db
                $store = acara::create([
                    'slug' => Str::slug($request->input('judul')),
                    'judul' => $request->input('judul'),
                    'deskripsi' => $request->input('deskripsi'),
                    'foto' => $name,
                    'url' => $url,
                    'penulis' => Auth::user()->id,
                    'status' => 1
                ]);
                return Redirect::back()->with(['sukses' => 'Berhasil menyimpan data']);
            }
        }
        abort(500, 'Gagal upload!');
    }

    public function destroy($id)
    {
        $data = acara::find($id);
        $filename = $data->url;
        try {
            Storage::delete($filename);
            $data->delete();
            return Redirect::back()->with('sukses', 'Berhasil menghapus data!');
        } catch (\Exception $e) {
            return Redirect::back()->with('gagal', 'Berhasil menghapus data!');
        }
    }

    public function update(Request $request, $id)
    {
        $data = acara::find($id);
        try {
            if ($request->hasFile('imageUpdate')) {
                if ($request->imageUpdate->isValid()) {
                    $validator = Validator::make($request->all(), [
                        'judul' => 'string|max:200',
                        'deskripsi' => 'string|max:10000',
                        'imageUpdate' => 'required|mimes:jpg,jpeg,png|max:5500',
                    ]);

                    if ($validator->fails()) {
                        return Redirect::back()
                            ->withErrors($validator)
                            ->withInput();
                    }

                    Storage::delete($data->url);

                    //upload file ke local storage
                    $name = date("his_") . $request->imageUpdate->getClientOriginalName();
                    $url = $request->imageUpdate->storeAs('acara', $name);

                    $data->slug = Str::slug($request->judul);
                    $data->judul = $request->judul;
                    $data->deskripsi = $request->deskripsi;
                    $data->foto = $name;
                    $data->url = $url;

                    $data->update();
                    return Redirect::back()->with(['sukses' => 'Data berhasil diupdate!']);
                }
            }

            $slug = Str::slug($request->judul);
            $data->slug = $slug;
            $data->judul = $request->judul;
            $data->deskripsi = $request->deskripsi;

            $data->update();
            return Redirect::back()->with('sukses', 'Data berhasil diupdate!');
        } catch (\Throwable $th) {
            return Redirect::back()->with('gagal', 'Data gagal diupdate!');
        }
    }

    public function aktif(request $request, $id)
    {
        $data = acara::find($id);
        if ($data->status == '0') {
            $data->status = '1';
            $data->update();
            return Redirect::back()->with('sukses', 'Data berhasil diupdate!');
        } else {
            $data->status = '0';
            $data->update();
            return Redirect::back()->with('sukses', 'Data berhasil diupdate!');
        }

        return Redirect::back()->with('gagal', 'Data gagal diupdate!');
    }

    public function galeri()
    {
        return view('pencarian.galeri');
    }

    public function updateIndex($id)
    {
        $data = acara::where('id', $id)->first();
        // dd($data);
        return view('manajemen.update.acara-update', compact('data'));
    }

    public function getData()
    {
        $data = acara::select(['id', 'slug', 'judul', 'penulis_id', 'status', 'created_at']);

        return DataTables::of($data)
            ->addColumn('action', function ($user) {
                return '<a href="' . route('show-kegiatan', ['slug' => $user->slug]) . '" target="_blank" class="btn btn-sm btn-outline-success"><i class="fas fa-eye"></i></a> <a href="' . route('upAcara', ['id' => $user->id]) . '" class="btn btn-sm btn-outline-info fa fa-edit"> </a> <a href="' . route('deleteAcara', ['id' => $user->id]) . '" class="btn btn-sm btn-outline-danger fa fa-trash"></a>';
            })
            ->addColumn('status_edit', function ($user) {
                if ($user->status != 0) {
                    return '<a href="' . route('aktifAcara', ['id' => $user->id]) . '"> <div class="badge badge-success">Aktif</div></a>';
                } else {
                    return '<a href="' . route('aktifAcara', ['id' => $user->id]) . '"> <div class="badge badge-danger">Non-Aktif</div></a>';
                }
            })
            ->editColumn('penulis_id', function ($user) {
                return $user->penulis->username;
            })
            ->editColumn('created_at', function ($user) {
                return date('m/d/Y', strtotime($user->created_at));
            })
            ->rawColumns(['status_edit', 'action'])
            ->make(true);
    }
}
