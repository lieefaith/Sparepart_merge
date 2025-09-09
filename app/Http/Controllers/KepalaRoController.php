<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KepalaRoController extends Controller
{
    public function dashboard()
    {
        return view('kepalaro.dashboard');
    }
    
    // Tambahkan metode lain yang diperlukan di sini
}