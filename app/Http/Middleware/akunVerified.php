<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class akunVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->verified_at != NULL) {
            return $next($request);
        } else {
            return redirect('profil')->with(['gagal' => 'Akun belum terverifikasi, Harap hubungi admin untuk melakukan verifikasi Manual']);
        }
    }
}
