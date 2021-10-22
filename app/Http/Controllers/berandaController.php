<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\beranda;
use App\kerjas;
use App\jabatan;
use App\staff;
use App\warga;
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
        $validator = Validator::make($request->all(), [
            'misi' => 'string|max:2000',
            'visi' => 'string|max:1000',
            'kontak' => 'integer|max:13',
            'email' => 'email',
            'alamat' => 'string|max:500',
        ], [
            'string' => 'kolom :attribute harus berupa huruf.',
            'integer' => 'kolom :attribute harus berupa angka.',
            'email' => 'kolom :attribute harus berformat email.',
            'max' => 'kolom :attribute melebihi batas karakter',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = beranda::first();
        if ($data->count() > 0) {
            try {
                if ($request->has('intansi')) {
                    $data->nama_intansi = $request->intansi;
                } elseif ($request->has('vismis')) {
                    $data->misi = $request->misi;
                    $data->visi = $request->visi;
                } else {
                    $data->kontak = $request->kontak;
                    $data->email = $request->email;
                    $data->alamat = $request->alamat;
                }

                $data->update();
                notify()->success("Berhasil merubah data", "Sukses", "bottomRight");
                return Redirect::back()->with(['sukses' => 'Berhasil merubah data kontak']);
            } catch (Exception $e) {
                notify()->error("Percobaan merubah data gagal!", "Gagal", "bottomLeft");
                return Redirect::back()->with(['gagal' => 'Gagal menambah data kontak']);
            }
        } else {
            try {
                $data = new beranda();
                if ($request->has('intansi')) {
                    $data->nama_intansi = $request->intansi;
                } elseif ($request->has('vismis')) {
                    $data->misi = $request->misi;
                    $data->visi = $request->visi;
                } else {
                    $data->kontak = $request->kontak;
                    $data->email = $request->email;
                    $data->alamat = $request->alamat;
                }

                $data->status = 1;
                $data->save();
                notify()->success("Berhasil merubah data", "Sukses", "bottomRight");
                return Redirect::back()->with(['sukses' => 'Berhasil merubah data']);
            } catch (\Throwable $th) {
                notify()->error("eksekusi menambah data gagal!", "Gagal", "bottomLeft");
                return Redirect::back()->with(['gagal' => 'Gagal menambah acara']);
            }
        }
    }

    public function storeGambar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thumb' => 'required|image|max:15360|dimensions:min_width=900,min_height=300',
        ], [
            'required' => 'Anda belum memasukan image yang akan diupload!',
            'image' => 'format file harus berupa jpg, jpeg, png.',
            'max' => 'ukuran image melebihi batas maksimal(15MB)',
            'dimensions' => 'image minimal memiliki ukuran 900x300 pixel.'
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = beranda::first();
        if ($data) {
            if ($request->hasFile('thumb')) {

                $file_path = 'public/images/thumbnail';
                $image = $request->thumb;
                $image_name = date("his") . $image->getClientOriginalName();
                $path = $image->storeAs($file_path, $image_name);

                $data->foto_thumb = $image_name;
                $data->update();
                notify()->success("Berhasil menyimpan data", "Sukses", "bottomRight");
                return Redirect::back()->with(['sukses' => 'Data berhasil diupdate!']);
            }
        }
        notify()->error("Percobaan merubah data gagal!", "Gagal", "bottomLeft");
        return Redirect::back()->with(['gagal' => 'Data gagal diupdate!']);
    }

    public function deleteKerja($id)
    {
        $warga = warga::where('kerja_id', $id)->get();
        if ($warga->count() > 0) {
            notify()->error("Percobaan menghapus data gagal!", "Gagal", "bottomLeft");
            return Redirect::back()->with('gagal', 'Gagal menghapus data');
        }

        try {
            $data = kerjas::find($id);
            $data->delete();
            notify()->warning("Berhasil menghapus data", "Sukses", "bottomRight");
            return Redirect::back()->with('sukses', 'Berhasil menghapus data!');
        } catch (\Exception $e) {
            notify()->error("Percobaan menghapus data gagal!", "Gagal", "bottomLeft");
            return Redirect::back()->with('gagal', $e);
        }
    }

    public function addKerja(Request $request)
    {
        if ($request->nama != "") {
            $data = new kerjas();
            $data->nama = $request->nama;
            $data->save();
            notify()->success("Berhasil menambah data", "Sukses", "bottomRight");
            return Redirect::back()->with('sukses', 'Berhasil menambah data!');;
        } else {
            notify()->error("Percobaan menambah data gagal!", "Gagal", "bottomLeft");
            return Redirect::back()->with('gagal', 'gagal menambah data!');
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
        $staff = staff::where('jabatan_id', $id)->get();
        // dd($staff->count());
        if ($staff->count() > 0) {
            notify()->error("Percobaan menghapus data gagal!", "Gagal", "bottomLeft");
            return Redirect::back()->with('gagal', 'Gagal menghapus data');
        }

        try {
            jabatan::find($id)->delete();
            notify()->warning("Berhasil menghapus data", "Sukses", "bottomRight");
            return Redirect::back()->with('sukses', 'Berhasil menghapus data!');
        } catch (\Exception $e) {
            notify()->error("Percobaan menghapus data gagal!", "Gagal", "bottomLeft");
            return Redirect::back()->with('gagal', $e);
        }
    }

    public function addJabatan(Request $request)
    {
        if ($request->nama != "") {
            $data = new jabatan();
            $data->nama = $request->nama;
            $data->save();
            notify()->success("Berhasil menambah data", "Sukses", "bottomRight");
            return Redirect::back()->with('sukses', 'Berhasil menambah data!');;
        } else {
            notify()->error("Percobaan menambah data gagal!", "Gagal", "bottomLeft");
            return Redirect::back()->with('gagal', 'Berhasil menambah data!');
        }
    }
}
