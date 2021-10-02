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
            $data['cariwarga'] = warga::where('status', 1)
                ->orWhere('nama_lengkap', 'like', '%' . $request->input('query') . '%')
                ->orderBy('created_at', 'desc')->get();
        } else {
            $data['cariwarga'] = warga::all()->where('status', 1)->sortByDesc('created_at');
        }
        return view('pencarian/fetchWarga', $data);
    }
}
