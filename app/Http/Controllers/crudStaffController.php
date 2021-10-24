<?php

namespace App\Http\Controllers;

use App\Exports\StaffExport;
use Illuminate\Http\Request;
use App\staff;
use Auth;
use App\jabatan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use DataTables;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class crudStaffController extends Controller
{

    public function index()
    {
        $data = staff::where('status', '1')->orderBy('jabatan_id', 'asc')->paginate(30);
        return view('pencarian.staff', compact('data'));
    }

    public function adminIndex()
    {
        $total_data = staff::all()->count();

        $jabatan = jabatan::all();
        return view('manajemen.editStaff', compact('total_data', 'jabatan'));
    }

    public function tambah(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'no' => 'required|integer',
            'nama' => 'required|string|max:150',
            'no_hp' => 'required',
            'alamat' => 'required|string|max:200',
            'image' => 'image|max:5120|dimensions:min_width=100,min_height=100',
        ], [
            'required' => 'kolo, :attribute harus diisi.',
            'string' => 'kolom :attribute harus berupa huruf.',
            'integer' => 'kolom :attribute harus berupa angka.',
            'max' => 'kolom :attribute melebihi batas karakter.',
            'image.max' => 'Foto melebihi batas ukuran 5MB.',
            'image' => 'file harus berupa format jpg, jpeg, png',
            'dimensions' => 'image minimal memiliki ukuran 100x100 pixel.'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = new staff();
            $data->nama = $request->nama;
            $data->id_pegawai = $request->no;
            $data->no_hp = $request->no_hp;
            $data->alamat = $request->alamat;
            $data->jabatan_id = $request->jabatan;

            if ($request->hasFile('image')) {
                $file_path = 'public/images/staff_image';
                $image = $request->image;

                //upload file ke local storage
                $image_name = date("his") . $image->getClientOriginalName();
                $path = $image->storeAs($file_path, $image_name);

                $data->foto = $image_name;
                $data->url = $path;
            }

            $data->save();

            notify()->success("Data Berhasil disimpan!", "Sukses", "topRight");
            return Redirect::back()->with('sukses', 'Data berhasil ditambah!');
        } catch (Exception $e) {
            return Redirect::back()->with('gagal', 'Data gagal diproses!');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'no' => 'required|integer',
            'nama' => 'required|string|max:150',
            'no_hp' => 'required',
            'alamat' => 'required|string|max:200',
            'imageUpdate' => 'image|max:5120|dimensions:min_width=100,min_height=100',
        ], [
            'required' => 'kolo, :attribute harus diisi.',
            'string' => 'kolom :attribute harus berupa huruf.',
            'integer' => 'kolom :attribute harus berupa angka.',
            'max' => 'kolom :attribute melebihi batas karakter.',
            'imageUpdate.max' => 'Foto melebihi batas ukuran 5MB.',
            'image' => 'file harus berupa format jpg, jpeg, png',
            'dimensions' => 'image minimal memiliki ukuran 100x100 pixel.'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = staff::find($id);

            $data->nama = $request->nama;
            $data->id_pegawai = $request->no;
            $data->no_hp = $request->no_hp;
            $data->alamat = $request->alamat;
            $data->jabatan_id = $request->jabatan;

            if ($request->hasFile('imageUpdate')) {
                $file_path = 'public/images/staff_image';
                $image = $request->imageUpdate;

                Storage::delete($file_path . '/' . $data->foto);

                //upload file ke local storage
                $image_name = date("his") . $image->getClientOriginalName();
                $path = $image->storeAs($file_path, $image_name);

                $data->foto = $image_name;
                $data->url = $path;
            }

            $data->update();
            notify()->success("Data Berhasil diupdate!", "Sukses", "topRight");
            return Redirect::back()->with('sukses', 'Data berhasil diupdate!');
        } catch (\Throwable $th) {
            return Redirect::back()->with('gagal', 'Data gagal diupdate!');
        }
    }

    public function aktif(request $request, $id)
    {
        $data = staff::find($id);
        if ($data->status == '0') {
            $data->status = '1';
            $data->update();
            notify()->success("Data Berhasil diaktivasi!", "Sukses", "topRight");
            return Redirect::back()->with('sukses', 'Data berhasil diaktifasi dan bisa dilihat umum!');
        } else {
            $data->status = '0';
            $data->update();
            return Redirect::back()->with('sukses', 'Data berhasil dinon-aktifikan dan tidak bisa dilihat umum!');
        }
        return Redirect::back()->with('gagal', 'Permintaan gagal di proses!');
    }

    public function destroy(request $request, $id)
    {
        $data = staff::find($id);
        $filename = $data->url;
        try {
            Storage::delete($filename);
            $data->delete();
            return Redirect::back()->with('sukses', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return Redirect::back()->with('gagal', 'Data Gagal dihapus!');
        }
    }

    public function updateIndex($id)
    {
        $jabatan = jabatan::all();
        $a = staff::where('id', $id)->first();
        return view('manajemen.update.staff-update', compact('jabatan', 'a'));
    }

    public function getData()
    {
        $data = staff::all();

        return DataTables::of($data)
            ->addColumn('action', function ($user) {
                return '<a href="' . route('deleteStaff', ['id' => $user->id]) . '" class="btn btn-sm btn-outline-danger" onclick="return confirm(`Apakah anda yakin menghapus data ini?`)"><i class="fa fa-trash"></i></a>
                <a href="' . route('upStaff', ['id' => $user->id]) . '" class="btn btn-sm btn-outline-info"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('status_edit', function ($user) {
                if ($user->status != 0) {
                    return '<a href="' . route('aktifStaff', ['id' => $user->id]) . '"> <div class="badge badge-success" onclick="return confirm(`Apakah anda yakin menonaktifkan staff?`)">Aktif</div></a>';
                } else {
                    return '<a href="' . route('aktifStaff', ['id' => $user->id]) . '"> <div class="badge badge-danger">Non-Aktif</div></a>';
                }
            })
            ->editColumn('jabatan_id', function ($user) {
                return $user->jabatan->nama;
            })
            ->rawColumns(['status_edit', 'action'])
            ->make(true);
    }

    public function export()
    {
        $staff = staff::all();
        $data = [];
        foreach ($staff as $w) {
            $data[] = [
                'id' => $w->id_pegawai,
                'nama' => $w->nama,
                'jabatan' => $w->jabatan->nama,
                'no_hp' => $w->no_hp,
                'alamat' => $w->alamat,
                'dibuat' => $w->created_at,
                'akun' => $w->user['username'],
            ];
        }

        return Excel::download(new StaffExport($data), 'Data_staff_' . date('dMY') . '_.xlsx');
    }
}
