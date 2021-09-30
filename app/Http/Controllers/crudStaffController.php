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

class crudStaffController extends Controller
{

    public function index()
    {
        $data = staff::where('status', '1')->orderBy('jabatan_id', 'asc')->paginate(30);
        return view('pencarian.staff',compact('data'));
    }

    public function adminIndex(Request $request)
    {
        if(!empty(Auth::user()->verified_at)){
            $cari = $request->cari;
        
            if($cari){
                $data = staff::where('nama', 'like', '%'. $request->cari.'%')
                ->paginate(20);
                // ->get();
                $total_data = $data->count();
            }else{
                $data = staff::orderBy('nama', 'asc')
                ->paginate(20);
                $total_data = $data->count();
            }
            $jabatan = jabatan::all();
            return view('manajemen.editStaff',compact('data','jabatan'));
        }else{
            return redirect('profil')->with(['gagal' => 'Akun belum terverifikasi, Harap hubungi admin untuk verifikasi']);
        }
        
    }

    public function tambah(Request $request)
    {
        // return $request->jabatan;
        if ($request->hasFile('image')){
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
                $name = date("his_").$request->image->getClientOriginalName();
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
        return Redirect::back()->with('sukses','Data berhasil diupdate!');  
    }

    public function update(Request $request, $id)
    {
        $data = staff::find($id);
        try {
            if ($request->hasFile('imageUpdate')) {
                if ($request->imageUpdate->isValid()) {
                    $validator = Validator::make($request->all(), [
                        'imageUpdate' => 'required|mimes:jpeg,png|max:5120',
                    ]);
                
                if ($validator->fails()) {
                    return Redirect::back()
                                ->withErrors($validator)
                                ->withInput();
                }

                Storage::delete($data->url);

                //upload file ke local storage
                $name = date("his_").$request->imageUpdate->getClientOriginalName();
                $url = $request->imageUpdate->storeAs('public', $name);

                $data->nama = $request->input('nama');
                $data->no_pegawai = $request->input('no');
                $data->no_hp = $request->input('no_hp');
                $data->alamat = $request->input('alamat');
                $data->foto = $name;
                $data->url = $url;
                $data->update();
                return Redirect::back()->with(['sukses' => 'Data berhasil diupdate!']);

                }
            }

            $data->nama = $request->input('nama');
            $data->no_pegawai = $request->input('no');
            $data->no_hp = $request->input('no_hp');
            $data->alamat = $request->input('alamat');
            $data->jabatan_id = $request->jabatan;
            
            $data->update();
            return Redirect::back()->with('sukses','Data berhasil diupdate!');  
            
        } catch (\Throwable $th) {
            return Redirect::back()->with('gagal','Data gagal diupdate!');
        }
    }

    public function aktif(request $request, $id)
    {
        $data = staff::find($id);
        if($data->status == '0'){
            $data->status = '1';
            $data->update();
            return Redirect::back()->with('sukses','Data berhasil diupdate!');  
        }else{
            $data->status = '0';
            $data->update();
            return Redirect::back()->with('sukses','Data berhasil diupdate!');  
        }

        return Redirect::back()->with('gagal','Data gagal diupdate!');
    }

    public function destroy(request $request, $id)
    {
        $data = staff::find($id);
        $filename = $data->url;
        try {
            Storage::delete($filename);
            $data->delete();
            return Redirect::back()->with('sukses','Data berhasil dihapus!');
        } catch (\Exception $e) {
            return Redirect::back()->with('gagal','Data berhasil dihapus!');
        }
    }


}
