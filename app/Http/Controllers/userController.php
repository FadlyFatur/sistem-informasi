<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use app\user;
use Auth;
use App\staff;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel as Excel;

class userController extends Controller
{
    public function AuthRouteAPI(Request $request)
    {
        return $request->user();
    }

    public function profil()
    {
        $staff = staff::all();
        $data = staff::where('user_id', Auth::id())
            ->first();

        return view('profil.editProfil', compact('staff', 'data'));
    }

    public function index()
    {
        $data = user::all();
        $total_data = $data->count();
        return view('manajemen.editUser', compact('data', 'total_data'));
    }

    public function level($id)
    {
        if (Auth::id() != $id) {
            $data = user::find($id);
            if ($data->role != '3') {
                if ($data->role == '1') {
                    $data->role = '2';
                    $data->update();
                    return Redirect::back()->with('sukses', 'Data hak akses berhasil diupdate!');
                } else {
                    $data->role = '1';
                    $data->update();
                    return Redirect::back()->with('sukses', 'Data hak akses berhasil diupdate!');
                }
            }
            return Redirect::back()->with('gagal', 'Tidak bisa merubah data Superadmin!');
        } else {
            return Redirect::back()->with('gagal', 'Tidak bisa merubah data pribadi!');
        }
    }

    public function delete($id)
    {
        if (Auth::id() != $id) {
            try {
                $data = user::find($id);
                $data->status = '0';
                $data->update();
                $data->delete();
                return Redirect::back()->with('sukses', 'Berhasil menghapus data!');
            } catch (\Exception $e) {
                return Redirect::back()->with('gagal', 'Gagal menghapus data!');
            }
        } else {
            return Redirect::back()->with('gagal', 'Tidak bisa menghapus data pribadi!');
        }
    }

    public function verified($id)
    {
        if (Auth::id() != $id) {
            $data = user::find($id);
            $data->verified_at = date('Y-m-d H:i:s', time());
            $data->update();
            return Redirect::back()->with('sukses', 'User berhasil diverifikasi!');
        } else {
            return Redirect::back()->with('gagal', 'Tidak bisa merubah data pribadi!');
        }
    }

    public function passUpdate(Request $request, $id)
    {
        if (Auth::id() == $id) {
            $data = Auth::user();
            $hashedPassword = $data->password;

            if (Hash::check($request['old-password'], $hashedPassword)) {
                if ($request->password == $request->password_confirmation) {
                    $data->password = Hash::make($request->password);
                    $data->update();
                    return Redirect::back()->with('sukses', 'Password Berhasil diganti!');
                }
                return Redirect::back()->with('gagal', 'Password tidak sesuai!');
            }
            return Redirect::back()->with('gagal', 'Password tidak sesuai!');
        }
        abort(404);
    }

    public function tautkan(Request $request)
    {
        $id = $request->staff;
        $data = staff::find($id);

        if (empty($data->id_pegawai)) {
            return Redirect::back()->with('gagal', 'Staff belum memiliki nomer pegawai, Harap diisi!');
        } else {
            if ($data['user_id'] === NULL) {
                $data->user_id = Auth::id();
                $data->update();
                return Redirect::back()->with('sukses', 'Akun ditautkan!');
            } else {
                return Redirect::back()->with('gagal', 'Data staff sudah terpakai!');
            }
        }
    }

    public function reset($id)
    {
        if (Auth::id() != $id) {
            try {
                $data = user::find($id);
                if ($data->role == 3) {
                    if (Auth::user()->role == 3) {
                        $defaultPass = '12345';
                        $data->password = Hash::make($defaultPass);
                        $data->update();
                        return Redirect::back()->with('sukses', 'Berhasil mereset Password!');
                    } else {
                        return Redirect::back()->with('gagal', 'Tidak bisa mereset password super admin!');
                    }
                }
                $defaultPass = '12345';
                $data->password = Hash::make($defaultPass);
                $data->update();
                return Redirect::back()->with('sukses', 'Berhasil mereset Password!');
            } catch (\Exception $e) {
                return Redirect::back()->with('gagal', 'Gagal mereset Password!');
            }
        } else {
            return Redirect::back()->with('gagal', 'Tidak bisa mereset data pribadi!');
        }
    }

    public function reIntegrasi($id)
    {
        try {
            $user = user::find($id);
            // dd($user->role);
            if (Auth::user()->role != 3) {
                if ($user->role == 3) {
                    return Redirect::back()->with('gagal', 'Tidak bisa mereset data superadmin!');
                }

                if (Auth::id() == $id) {
                    return Redirect::back()->with('gagal', 'Tidak bisa mereset data pribadi!');
                }
            }

            staff::where('user_id', $id)
                ->update(['user_id' => Null]);

            return Redirect::back()->with('sukses', 'Berhasil melakukan re-integrasi akun!');
        } catch (\Throwable $th) {
            return Redirect::back()->with('gagal', 'Gagal melakukan re-integrasi akun!');
        }
    }

    public function deleteAkun($id, Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        user::where('id', $id)->delete();

        return view('auth.login')->with('sukses', 'Akun berhasil ditutup, anda tidak bisa lagi mengunakanya!');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'data_users_' . date('dMY') . '.xlsx');
    }
}
