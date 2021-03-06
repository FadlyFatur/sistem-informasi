<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
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
        // dd('admin');
        if (in_array(Auth::user()->role, ['2', '3'])) {
            return $next($request);
        } else {
            abort(403, 'Akses Dilarang');
        }
    }
}
