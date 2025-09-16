<?php

namespace App\Http\Controllers;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('superadmin.dashboard');
    }

    public function requestIndex()
    {
        return view('superadmin.request');
    }

    public function historyIndex()
    {
        return view('superadmin.history');
    }
}
