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

class crudWargaController extends Controller
{
    public function tambah(Request $request)
    {

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

    public function getData()
    {
        $warga = warga::all();

        return DataTables::of($warga)
            ->addColumn('action', function ($user) {
                return '<a href="' . route('upWarga', ['id' => $user->id]) . '" class="btn btn-sm btn-outline-info fa fa-edit"> </a> <a href="' . route('deleteWarga', ['id' => $user->id]) . '" class="btn btn-sm btn-outline-danger fa fa-trash"></a>';
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
                    return '<a href="' . route('aktifWarga', ['id' => $user->id]) . '"> <div class="badge badge-success">Aktif</div></a>';
                } else {
                    return '<a href="' . route('aktifWarga', ['id' => $user->id]) . '"> <div class="badge badge-danger">Non-Aktif</div></a>';
                }
            })->rawColumns(['status_edit', 'action'])
            ->make(true);
    }
}
