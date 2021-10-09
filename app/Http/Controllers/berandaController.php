<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\beranda;
use App\kerjas;
use App\jabatan;
use Exception;
use Illuminate\Support\Facades\Redirect;
use DataTables;
use Illuminate\Support\Facades\Validator;

class berandaController extends Controller
{
    public function index()
    {
        $data = beranda::first();
        return view('manajemen.editBeranda', compact('data'));
    }

    public function update(Request $request)
    {
        $data = beranda::all();
        if ($data->count() > 0) {
            try {
                $data = beranda::first();
                $data->kontak = $request->kontak;
                $data->email = $request->email;
                $data->alamat = $request->alamat;
                $data->update();
                return Redirect::back()->with(['sukses' => 'Berhasil merubah data']);
            } catch (Exception $e) {
                return Redirect::back()->with(['gagal' => 'Gagal menambah acara']);
            }
        } else {
            try {
                $data = new beranda();
                $data->kontak = $request->kontak;
                $data->email = $request->email;
                $data->alamat = $request->alamat;
                $data->status = 1;
                $data->save();
                return Redirect::back()->with(['sukses' => 'Berhasil merubah data']);
            } catch (\Throwable $th) {
                return Redirect::back()->with(['gagal' => 'Gagal menambah acara']);
            }
        }
    }

    function updateMs(Request $request)
    {
        $data = beranda::all();
        if ($data->count() > 0) {
            try {
                $data = beranda::first();
                $data->misi = $request->misi;
                $data->visi = $request->visi;
                $data->update();
                return Redirect::back()->with(['sukses' => 'Berhasil merubah data']);
            } catch (Exception $e) {
                return Redirect::back()->with(['gagal' => 'Gagal menambah acara']);
            }
        } else {
            try {
                $data = new beranda();
                $data->misi = $request->misi;
                $data->visi = $request->visi;
                $data->save();
                return Redirect::back()->with(['sukses' => 'Berhasil merubah data']);
            } catch (\Throwable $th) {
                return Redirect::back()->with(['gagal' => 'Gagal menambah acara']);
            }
        }
    }

    public function storeGambar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thumb' => 'required|image|max:15360|dimensions:min_width=900,min_height=300',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        // dd($request->all());
        $data = beranda::first();
        if ($data) {
            if ($request->hasFile('thumb')) {
                $name = date("his_") . $request->thumb->getClientOriginalName();
                $url = $request->thumb->storeAs('acara', $name);

                // $name = date("Ymd") . $request->thumb->getClientOriginalName();
                // $url = $request->thumb->storeAs('public', $name);

                // $data->foto = $name;
                $data->foto_thumb = $url;
                $data->update();
                return Redirect::back()->with(['sukses' => 'Data berhasil diupdate!']);
            }
        }
        return Redirect::back()->with(['gagal' => 'Data gagal diupdate!']);
    }

    public function deleteKerja($id)
    {
        $data = kerjas::find($id);
        try {
            $data->delete();
            return Redirect::back()->with('sukses', 'Berhasil menghapus data!');
        } catch (\Exception $e) {
            return Redirect::back()->with('gagal', $e);
        }
    }

    public function addKerja(Request $request)
    {
        if ($request->nama != "") {
            $data = new kerjas();
            $data->nama = $request->nama;
            $data->save();
            return Redirect::back()->with('sukses', 'Berhasil menghapus data!');;
        } else {
            return Redirect::back()->with('gagal', 'Berhasil menghapus data!');
        }
    }

    public function indexPilihan()
    {
        return view('manajemen.pilihan');
    }

    public function getData()
    {
        $data = kerjas::all();

        return DataTables::of($data)
            ->addColumn('action', function ($d) {
                return '<a href="' . route('deleteKerja', ['id' => $d->id]) . '" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getDataJabatan()
    {
        $data = jabatan::all();

        return DataTables::of($data)
            ->addColumn('action', function ($d) {
                return '<a href="' . route('deleteJabatan', ['id' => $d->id]) . '" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function deleteJabatan($id)
    {
        $data = jabatan::find($id);
        try {
            $data->delete();
            return Redirect::back()->with('sukses', 'Berhasil menghapus data!');
        } catch (\Exception $e) {
            return Redirect::back()->with('gagal', $e);
        }
    }

    public function addJabatan(Request $request)
    {
        if ($request->nama != "") {
            $data = new jabatan();
            $data->nama = $request->nama;
            $data->save();
            return Redirect::back()->with('sukses', 'Berhasil menghapus data!');;
        } else {
            return Redirect::back()->with('gagal', 'Berhasil menghapus data!');
        }
    }
}
