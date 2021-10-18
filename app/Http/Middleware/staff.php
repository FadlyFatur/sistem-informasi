<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class staff
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
        if (in_array(Auth::user()->role, ['1', '2', '3'])) {
            // dd('staff');
            return $next($request);
        } else {
            abort(403, 'Akses Dilarang');
        }
    }
}
