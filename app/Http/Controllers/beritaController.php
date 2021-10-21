<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\acara;
use App\Apirasi;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Exception;

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
        $total_data = acara::all()->count();

        return view('manajemen.editAcara', compact('total_data'));
    }

    // bug img
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'string|max:200',
            'deskripsi' => 'string|max:10000',
            'image' => 'required|image|max:10240',
        ], [
            'judul.string' => 'kolom :attribute harus berupa huruf.',
            'deskripsi.string' => 'kolom :attribute harus berupa huruf.',
            'max' => 'kolom :attribute melebihi batas karakter',
            'imageUpdate.max' => 'Foto melebihi batas ukuran 5MB',
            'required' => 'kolom :attribute wajib diisi',
            'image' => 'file harus berupa format jpg, jpeg, png'
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

    // bug img
    public function update(Request $request, $id)
    {
        $data = acara::find($id);
        try {
            if ($request->hasFile('imageUpdate')) {
                if ($request->imageUpdate->isValid()) {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'judul' => 'string|max:200',
                            'deskripsi' => 'string|max:10000',
                            'imageUpdate' => 'required|image|max:5500',
                        ],
                        [
                            'judul.string' => 'kolom :attribute harus berupa huruf.',
                            'deskripsi.string' => 'kolom :attribute harus berupa huruf.',
                            'max' => 'kolom :attribute melebihi batas karakter',
                            'imageUpdate.max' => 'Foto melebihi batas ukuran 5MB',
                            'required' => 'kolom :attribute wajib diisi',
                            'image' => 'file harus berupa format jpg, jpeg, png'
                        ]
                    );

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
                // return $user->penulis->username;
                return $user->penulis['username'];
            })
            ->editColumn('created_at', function ($user) {
                return date('m/d/Y', strtotime($user->created_at));
            })
            ->rawColumns(['status_edit', 'action'])
            ->make(true);
    }

    public function indexAspirasi()
    {
        return view('berita.aspirasi');
    }

    public function postAspirasi(Request $request)
    {
        if (Auth::check() && in_array(Auth::user()->role, ['1', '2', '3'])) {
            return Redirect::back()->with(['gagal' => 'Admin/User, tidak bisa mengirim aspirasi']);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'pengirim' => 'string|max:200',
                'deskripsi' => 'required|max:1000',
            ],
            [
                'string' => 'kolom :attribute harus berupa huruf.',
                'max' => 'kolom :attribute melebihi batas karakter',
                'required' => 'kolom :attribute wajib diisi'
            ]
        );

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->anonim == '1') {
            try {
                apirasi::create([
                    'aspirasi' => $request->deskripsi
                ]);

                return Redirect::back()->with(['sukses' => 'Berhasil Mengirim Aspirasi']);
            } catch (Exception $e) {
                return Redirect::back()->with(['gagal' => 'Gagal Mengirim Aspirasi']);
            }
        } else {
            try {
                apirasi::create([
                    'aspirasi' => $request->deskripsi,
                    'pengirim' => $request->pengirim
                ]);

                return Redirect::back()->with(['sukses' => 'Berhasil Mengirim Aspirasi']);
            } catch (Exception $e) {
                // dd($e);
                return Redirect::back()->with(['gagal' => 'Gagal Mengirim Aspirasi']);
            }
        }
    }

    public function indexAspirasiAdmin()
    {
        $count = Apirasi::where('status', 0)->get()->count();
        return view('manajemen.aspirasi', compact('count'));
    }

    public function getDataAspirasi()
    {
        $data = Apirasi::where('status', 0)->get();

        return DataTables::of($data)
            ->addColumn('action', function ($user) {
                return '<a href="' . route('accAspirasi', ['id' => $user->id]) . '" class="btn btn-sm btn-outline-success">Terima </a> <a href="' . route('rejectAspirasi', ['id' => $user->id]) . '" class="btn btn-sm btn-outline-danger">Tolak</a>';
            })
            ->editColumn('created_at', function ($user) {
                return date('m/d/Y', strtotime($user->created_at));
            })
            ->editColumn('pengirim', function ($user) {
                if ($user->pengirim != null) {
                    return $user->pengirim;
                } else {
                    return 'Anonim';
                }
                return date('m/d/Y', strtotime($user->created_at));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function accAspirasi($id)
    {
        try {
            Apirasi::where('id', $id)
                ->update(['status' => 1]);
            return redirect()->back()->with(['sukses' => 'Berhasil Menerima Aspirasi, Aspirasi akan ditampilkan di halama aspirasi']);
        } catch (\Throwable $th) {
            return Redirect::back()->with(['gagal' => 'Gagal Mengirim Aspirasi']);
        }
    }

    public function rejectAspirasi($id)
    {
        try {
            Apirasi::where('id', $id)
                ->update(['status' => 2]);
            return redirect()->back()->with(['sukses' => 'Berhasil Menolak Aspirasi, Aspirasi tidak akan ditampilkan di halama aspirasi']);
        } catch (\Throwable $th) {
            return Redirect::back()->with(['gagal' => 'Gagal Mengirim Aspirasi']);
        }
    }
}
