<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\acara;
use App\beranda;
use App\staff;
use App\warga;
use Illuminate\Support\Facades\Http;

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
        $data = acara::all()->sortByDesc('created_at')->take(10);
        $jmlacara = acara::all()->count();
        $staff = staff::all()->sortBy('jabatan_id')->take(4);
        $jmlstaff = staff::all()->count();
        $jmlwarga = warga::all()->count();
        $beranda = beranda::all()->first();
        $jmlberanda = beranda::all()->count();
        $berita = $this->beritaApi();
        return view('welcome', compact('data', 'beranda', 'staff', 'jmlstaff', 'jmlwarga', 'jmlacara', 'jmlberanda', 'berita'));
    }

    public function beritaApi()
    {
        $data = Http::get("https://berita-indo-api.vercel.app/v1/cnn-news")->json();
        $data_berita = [];
        foreach ($data['data'] as $d) {
            $data_berita[] = [
                'judul' => $d['title'],
                'url' => $d['link'],
                'img' => $d['image']['small'],
                'date' => $d['isoDate'],
            ];
        }
        $data_berita = array_slice($data_berita, 0, 25);
        // dd($data_berita);
        return $data_berita;
    }
}
