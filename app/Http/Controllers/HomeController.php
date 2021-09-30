<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\acara;
use App\beranda;
use App\staff;
use App\warga;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = acara::all()->sortByDesc('created_at')->take(3);
        $jmlacara = acara::all()->count();
        $staff = staff::all()->sortBy('jabatan_id')->take(4);
        $jmlstaff = staff::all()->count();
        $jmlwarga = warga::all()->count();
        $beranda = beranda::all()->first();
        $jmlberanda = beranda::all()->count();
        return view('welcome',compact('data', 'beranda', 'staff','jmlstaff', 'jmlwarga', 'jmlacara','jmlberanda'));
    }


}
