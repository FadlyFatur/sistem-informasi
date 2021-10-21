<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\staff;
use Auth;
use App\jabatan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use DataTables;

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
            'no' => 'required|integer|max:20',
            'nama' => 'required|string|max:150',
            'no_hp' => 'required|integer|max:13',
            'alamat' => 'required|string|max:200',
            'image' => 'image|max:5120',
        ], [
            'required' => 'kolo, :attribute harus diisi.',
            'string' => 'kolom :attribute harus berupa huruf.',
            'integer' => 'kolom :attribute harus berupa angka.',
            'max' => 'kolom :attribute melebihi batas karakter',
            'image.max' => 'Foto melebihi batas ukuran 5MB',
            'image' => 'file harus berupa format jpg, jpeg, png'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        //bug img
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $validator = Validator::make($request->all(), [
                    'image' => 'required|mimes:jpg,jpeg,png|max:5120',
                ]);

                if ($validator->fails()) {
                    return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
                }

                //upload file ke local storage
                $name = date("his_") . $request->image->getClientOriginalName();
                $url = $request->image->storeAs('public', $name);

                // upload db
                $store = staff::create([
                    'nama' => $request->input('nama'),
                    'no_pegawai' => $request->input('no'),
                    'no_hp' => $request->input('no_hp'),
                    'alamat' => $request->input('alamat'),
                    'jabatan_id' => $request->jabatan,
                    'foto' => $name,
                    'url' => $url
                ]);
                return Redirect::back()->with(['sukses' => 'Berhasil menambah data!']);
            }
            return Redirect::back()->with(['gagal' => 'Berhasil menambah data!']);
        }
        $data = new staff();
        $data->nama = $request->input('nama');
        $data->no_pegawai = $request->input('no');
        $data->no_hp = $request->input('no_hp');
        $data->alamat = $request->input('alamat');
        $data->jabatan_id = $request->jabatan;

        $data->save();
        return Redirect::back()->with('sukses', 'Data berhasil diupdate!');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'no' => 'required|integer|max:20',
            'nama' => 'required|string|max:150',
            'no_hp' => 'required|integer|max:13',
            'alamat' => 'required|string|max:200',
            'imageUpdate' => 'image|max:5120',
        ], [
            'required' => 'kolom, :attribute harus diisi.',
            'string' => 'kolom :attribute harus berupa huruf.',
            'integer' => 'kolom :attribute harus berupa angka.',
            'max' => 'kolom :attribute melebihi batas karakter',
            'imageUpdate.max' => 'Foto melebihi batas ukuran 5MB',
            'image' => 'file harus berupa format jpg, jpeg, png'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = staff::find($id);
        try {

            $data->nama = $request->input('nama');
            $data->id_pegawai = $request->input('no');
            $data->no_hp = $request->input('no_hp');
            $data->alamat = $request->input('alamat');
            $data->jabatan_id = $request->jabatan;

            // bug img 
            if ($request->hasFile('imageUpdate')) {
                Storage::delete($data->url);

                //upload file ke local storage
                $name = date("his") . $request->imageUpdate->getClientOriginalName();
                $url = $request->imageUpdate->storeAs('public', $name);

                $data->foto = $name;
                $data->url = $url;
            }

            $data->update();
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
                return '<a href="' . route('deleteStaff', ['id' => $user->id]) . '" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>
                <a href="' . route('upStaff', ['id' => $user->id]) . '" class="btn btn-sm btn-outline-info"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('status_edit', function ($user) {
                if ($user->status != 0) {
                    return '<a href="' . route('aktifStaff', ['id' => $user->id]) . '"> <div class="badge badge-success">Aktif</div></a>';
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
}
