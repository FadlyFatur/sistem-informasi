<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\warga;
use App\kerjas;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Exports\WargaExport;
use Maatwebsite\Excel\Facades\Excel;

class crudWargaController extends Controller
{
    public function tambah(Request $request)
    {
        $warga = new warga();
        $warga->nik = $request->nik;
        $warga->nama_lengkap = $request->nama_lengkap;
        $warga->jenis_kelamin = $request->jenis_kelamin;
        $warga->tempat_lahir = $request->tempat_lahir;
        $warga->tanggal_lahir = $request->tanggal_lahir;
        $warga->alamat = $request->alamat;
        $warga->kelurahan = $request->kelurahan;
        $warga->kecamatan = $request->kecamatan;
        $warga->kota = $request->kota;
        $warga->rt = $request->rt;
        $warga->agama_id = $request->agama;
        $warga->kerja = $request->kerja;
        $warga->perkawinan = $request->perkawinan;
        $warga->save();

        return Redirect::back()->with(['sukses' => 'Data berhasil ditambah']);
    }

    public function Index(Request $request)
    {
        $kerja = kerjas::all();
        $cari = $request->cari;
        if ($cari) {
            $wargas = warga::where('nama', 'like', '%' . $request->cari . '%')
                ->paginate(50);
            // $total_data = $wargas->count();
        } else {
            $wargas = warga::orderBy('rw', 'asc')->paginate(50);
            // dd($wargas[0]->kerja['nama']);
            $total_data = $wargas->count();
        }
        return view('manajemen.crudWarga', compact('wargas', 'total_data', 'kerja'));
    }

    public function delete($id)
    {
        $warga = warga::find($id);
        $warga->delete();
        return Redirect::back()->with(['sukses' => 'Data berhasil dihapus']);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        warga::where('id', $id)
            ->update([
                'nik' => $request->nik,
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

        // $warga = Warga::find($id);

        // if ($request->status == "Aktif") {
        //     $status = 1;
        // } else {
        //     $status = 0;
        // }

        // $warga->nik = $request->nik;
        // $warga->nama_lengkap = $request->nama_lengkap;
        // $warga->jenis_kelamin = $request->jenis_kelamin;
        // $warga->tempat_lahir = $request->tempat_lahir;
        // $warga->tanggal_lahir = $request->tanggal_lahir;
        // $warga->alamat = $request->alamat;
        // $warga->kelurahan = $request->kelurahan;
        // $warga->kecamatan = $request->kecamatan;
        // $warga->kota = $request->kota;
        // $warga->status = $status;
        // $warga->rt = $request->rt;
        // $warga->agama_id = $request->agama;
        // $warga->kerja = $request->kerja;
        // $warga->perkawinan = $request->kawin;

        // $warga->update();

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
        return Excel::download(new WargaExport, 'Data-warga-RW2.xlsx');
    }

    public function updateIndex($id)
    {
        $data = warga::where('id', $id)->first();
        $kerja = kerjas::all();
        // dd($kerja);
        return view('manajemen.update.warga-update', compact('data', 'kerja'));
    }
}
