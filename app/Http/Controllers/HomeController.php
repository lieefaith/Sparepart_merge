<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisBarang;

class HomeController extends Controller
{
    public function index()
    {
        return view('user.home');
    }

  public function jenisBarang()
{
    $jenisBarang = JenisBarang::with('listBarang')->get();
    return view('user.jenisbarang', compact('jenisBarang'));
}
}