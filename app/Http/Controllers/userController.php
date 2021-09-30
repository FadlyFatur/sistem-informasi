<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\user;
use Auth;
use App\staff;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function profil()
    {
        $staff = staff::all();
        $data = staff::where('user_id', Auth::id())
                        ->first();
        // $taut = $data->user_id;
        
        return view('profil.editProfil',compact('staff', 'data'));
    }
    public function index()
    {
        $data = user::all();
        $total_data = $data->count();
        return view('manajemen.editUser',compact('data','total_data'));
    }

    public function level($id)
    {
        if(Auth::id() != $id){
            $data = user::find($id);
            if($data->status == '1'){
                $data->status = '2';
                $data->update();
                return Redirect::back()->with('sukses','Data berhasil diupdate!');  
            }else{
                $data->status = '1';
                $data->update();
                return Redirect::back()->with('sukses','Data berhasil diupdate!');  
            }
        }else{
            return Redirect::back()->with('gagal','Tidak bisa merubah data pribadi!');
        }

    }

    public function delete($id)
    {
        if(Auth::id() != $id){
            try {
                $data = user::find($id);
                $data->delete();
                return Redirect::back()->with('sukses','Berhasil menghapus data!');
            } catch (\Exception $e) {
                return Redirect::back()->with('gagal','Gagal menghapus data!');
            }
        }else{
            return Redirect::back()->with('gagal','Tidak bisa menghapus data pribadi!');
        }
        
    }

    public function verified($id)
    {
        if(Auth::id() != $id){
            $data = user::find($id);
            $data->verified_at = date('Y-m-d H:i:s', time());
            $data->update();
            return Redirect::back()->with('sukses','User berhasil diverifikasi!');  
        }else{
            return Redirect::back()->with('gagal','Tidak bisa merubah data pribadi!');
        }
    }

    public function passUpdate(Request $request, $id)
    {
        if (Auth::id() == $id) {
            $data = Auth::user();
            $hashedPassword = $data->password;

            if (Hash::check($request['old-password'], $hashedPassword)) {
                if ($request->password == $request->password_confirmation)
                {
                    $data->password = Hash::make($request->password);
                    $data->update();
                    return Redirect::back()->with('sukses','Password Berhasil diganti!');  
                }
                return Redirect::back()->with('gagal','Password tidak sesuai!');
            }
            return Redirect::back()->with('gagal','Password tidak sesuai!');
        }
        abort(404);
    }

    public function tautkan(Request $request)
    {   
        $id = $request->staff; 
        $data = staff::find($id);
        
        if (empty($data->no_pegawai)){
            return Redirect::back()->with('gagal','Staff belum memiliki nomer pegawai, Harap diisi!');
        }else{
            if($data['user_id'] === NULL){
                $data->user_id = Auth::id();
                $data->update();
                return Redirect::back()->with('sukses','Akun ditautkan!');  
            }else {
                return Redirect::back()->with('gagal','Data staff sudah terpakai!');  
            }
        }

    }

    public function reset($id)
    {
        if(Auth::id() != $id){
            try {
                $defaultPass = '12345';
                $data = user::find($id);
                $data->password = Hash::make($defaultPass);
                $data->update();
                return Redirect::back()->with('sukses','Berhasil mereset Password!');
            } catch (\Exception $e) {
                return Redirect::back()->with('gagal','Gagal mereset Password!');
            }
        }else{
            return Redirect::back()->with('gagal','Tidak bisa mereset data pribadi!');
        }
        
    }
}
