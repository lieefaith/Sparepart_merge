<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KepalaGudangController extends Controller
{
    public function dashboard()
    {
        return view('kepalagudang.dashboard');
    }

    public function requestIndex()
    {
        return view('kepalagudang.request');
    }

    public function sparepartIndex()
    {
        return view('kepalagudang.sparepart');
    }

    public function sparepartStore(Request $request)
    {
        // Fungsi ini akan gagal jika tidak ada model RequestBarang
        // dan tabel di database. Anda bisa hapus fungsi ini jika tidak digunakan.
    }

    public function historyIndex()
    {
        return view('kepalagudang.history');
    }

    public function historyDetail($id)
    {
        // Fungsi ini juga akan gagal jika tidak ada model HistoriPermintaan
        // dan tabel di database. Anda bisa hapus fungsi ini jika tidak digunakan.
    }
}