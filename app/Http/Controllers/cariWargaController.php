<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\warga;

class wargaController extends Controller
{
    public function Index()
    {
        return view('pencarian/cariWarga');
    }

    public function fetch(Request $request)
    {
        if ($request->input('query')) {
            $data['cariwarga'] = warga::where('nama', 'like', '%' . $request->input('query') . '%')
                ->orWhere('alamat', 'like', '%' . $request->input('query') . '%')
                ->orderBy('created_at', 'desc')->get();
        } else {
            $data['cariwarga'] = warga::all()->sortByDesc('nama');
        }
        return view('pencarian/fetchWarga', $data);
    }
}
