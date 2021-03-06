<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\warga;
use App\kerjas;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Exports\WargaExport;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use Illuminate\Support\Facades\Validator;

class crudWargaController extends Controller
{
    public function tambah(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|max:16|unique:App\warga',
            'nama_lengkap' => 'required|string|max:150',
            'kelurahan' => 'required|string|max:150',
            'kecamatan' => 'required|string|max:150',
            'kota' => 'required|string|max:150',
            'tempat_lahir' => 'required|string|max:150',
            'rt' => 'required',
            'rw' => 'required',
            'alamat' => 'required|string|max:200',
        ], [
            'required' => 'kolom, :attribute harus diisi.',
            'string' => 'kolom :attribute harus berupa huruf.',
            'integer' => 'kolom :attribute harus berupa angka.',
            'max' => 'kolom :attribute melebihi batas karakter',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        $warga = new warga;
        $warga->nik = $request->nik;
        $warga->nama = $request->nama_lengkap;
        $warga->jk = $request->jenis_kelamin;
        $warga->tempat_lahir = $request->tempat_lahir;
        $warga->tanggal_lahir = $request->tanggal_lahir;
        $warga->alamat = $request->alamat;
        $warga->kel = $request->kelurahan;
        $warga->kec = $request->kecamatan;
        $warga->kota = $request->kota;
        $warga->rt = $request->rt;
        $warga->rw = $request->rw;
        $warga->agama = $request->agama;
        $warga->kerja_id = $request->kerja;
        $warga->kawin = $request->kawin;
        $warga->save();

        notify()->success("Data Berhasil disimpan!", "Sukses", "topRight");
        return Redirect::back()->with(['sukses' => 'Data berhasil ditambah']);
    }

    public function Index(Request $request)
    {
        $kerja = kerjas::all();
        return view('manajemen.crudWarga', compact('kerja'));
    }

    public function delete($id)
    {
        $warga = warga::find($id);
        $warga->delete();
        return Redirect::back()->with(['sukses' => 'Data berhasil dihapus']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|integer|max:16',
            'nama_lengkap' => 'required|string|max:150',
            'kelurahan' => 'required|string|max:150',
            'kecamatan' => 'required|string|max:150',
            'kota' => 'required|string|max:150',
            'tempat_lahir' => 'required|string|max:150',
            'rt' => 'required',
            'rw' => 'required',
            'alamat' => 'required|string|max:200',
        ], [
            'required' => 'kolom, :attribute harus diisi.',
            'string' => 'kolom :attribute harus berupa huruf.',
            'integer' => 'kolom :attribute harus berupa angka.',
            'max' => 'kolom :attribute melebihi batas karakter',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $nikHash = Crypt::encryptString($request->nik);
        warga::where('id', $id)
            ->update([
                'nik' => $nikHash,
                'nama' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jk' => $request->jenis_kelamin,
                'kel' => $request->kecamatan,
                'kec' => $request->kelurahan,
                'kota' => $request->kota,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'agama' => $request->agama,
                'kerja_id' => $request->kerja,
                'kawin' => $request->kawin,
            ]);

        return Redirect::back()->with(['sukses' => 'Data warga berhasil diupdate']);
    }

    public function aktif(request $request, $id)
    {
        $data = warga::find($id);
        if ($data->status == '0') {
            $data->status = '1';
            $data->update();
            return Redirect::back()->with('sukses-update', 'Data berhasil diupdate!');
        } else {
            $data->status = '0';
            $data->update();
            return Redirect::back()->with('sukses-update', 'Data berhasil diupdate!');
        }
    }

    public function export()
    {
        $warga = warga::all();
        $data = [];
        foreach ($warga as $w) {
            $data[] = [
                'nik' => $w->nik,
                'nama' => $w->nama,
                'jk' => $w->jk,
                'tempat_lahir' => $w->tempat_lahir,
                'tanggal_lahir' => $w->tanggal_lahir,
                'alamat' => $w->alamat,
                'kel' => $w->kel,
                'kec' => $w->kec,
                'kota' => $w->kota,
                'rw' => $w->rw,
                'rt' => $w->rt,
                'agama' => $w->agama,
                'kawin' => $w->kawin,
                'kerja' => $w->kerja->nama,
            ];
        }

        return Excel::download(new WargaExport($data), 'Data_warga_' . date('dMY') . '_.xlsx');
    }

    public function updateIndex($id)
    {
        $data = warga::where('id', $id)->first();
        $kerja = kerjas::all();
        // dd($kerja);
        return view('manajemen.update.warga-update', compact('data', 'kerja'));
    }

    public function getData()
    {
        $warga = warga::all();

        return DataTables::of($warga)
            ->addColumn('action', function ($user) {
                return '<a href="' . route('upWarga', ['id' => $user->id]) . '" class="btn btn-sm btn-outline-info fa fa-edit"> </a> <a class="btn btn-sm btn-outline-danger fa fa-trash"  onclick="return confirm(`Apakah anda yakin menghapus data?`)" href="' . route('deleteWarga', ['id' => $user->id]) . '"></a>';
            })
            ->addColumn('TTL', function ($user) {
                return $user->tempat_lahir . ' ' . $user->tanggal_lahir;
            })
            ->addColumn('alamat_lengkap', function ($user) {
                return $user->alamat . ', ' . $user->kel . ', ' . $user->kec . ', ' . $user->kota;
            })
            ->addColumn('rt/rw', function ($user) {
                return $user->rt . '/' . $user->rw;
            })
            ->editColumn('kerja_id', function ($user) {
                return $user->kerja->nama;
            })
            ->addColumn('status_edit', function ($user) {
                if ($user->status != 0) {
                    return '<a href="' . route('aktifWarga', ['id' => $user->id]) . '"> <div class="badge badge-success" onclick="return confirm(`Apakah anda yakin menonaktifkan warga?`)">Aktif</div></a>';
                } else {
                    return '<a href="' . route('aktifWarga', ['id' => $user->id]) . '"> <div class="badge badge-danger">Non-Aktif</div></a>';
                }
            })->rawColumns(['status_edit', 'action'])
            ->make(true);
    }
}
