<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use Illuminate\Http\Request;

class KepalaGudangController extends Controller
{
    public function dashboard()
    {
        return view('kepalagudang.dashboard');
    }

    /**
     * Tampilkan daftar request yang sudah di-approve Kepala RO
     */
    public function requestIndex()
    {
        $requests = Permintaan::where('status_ro', 'approved')
            ->where('status_gudang', 'pending')
            ->with(['user', 'details']) // Load relasi jika diperlukan
            ->orderBy('tanggal_permintaan', 'desc')
            ->get();

        return view('kepalagudang.request', compact('requests'));
    }

    public function sparepartIndex()
    {
        return view('kepalagudang.sparepart');
    }

    public function sparepartStore(Request $request)
    {
        // Akan kita isi nanti jika diperlukan
    }

    public function historyIndex()
    {
        return view('kepalagudang.history');
    }

    public function historyDetail($id)
    {
        // Akan kita isi nanti jika diperlukan
    }
}