<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use App\Models\Pengiriman;
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
        $requests = Permintaan::with(['user', 'details'])
            ->where('status_gudang', '!=', 'pending') // ✅ Hanya yang sudah di-approve/ditolak
            ->orderBy('tanggal_permintaan', 'desc')
            ->get();

        return view('kepalagudang.history', compact('requests'));
    }

    public function historyDetailApi($tiket)
    {
        $permintaan = Permintaan::with(['user', 'details'])
            ->where('tiket', $tiket)
            ->firstOrFail();

        $pengiriman = Pengiriman::with('details')
            ->where('tiket_permintaan', $tiket)
            ->first();

        return response()->json([
            'permintaan' => $permintaan,
            'pengiriman' => $pengiriman,
        ]);
    }

    public function approveGudang($tiket)
    {
        $permintaan = Permintaan::where('tiket', $tiket)->firstOrFail();
        $permintaan->update([
            'status_gudang' => 'approved',
            'status' => 'diterima', // opsional — untuk konsistensi global
        ]);

        return response()->json(['success' => true]);
    }

    public function rejectGudang($tiket)
    {
        $permintaan = Permintaan::where('tiket', $tiket)->firstOrFail();
        $permintaan->update([
            'status_gudang' => 'rejected',
            'status' => 'ditolak', // opsional — untuk konsistensi global
        ]);

        return response()->json(['success' => true]);
    }


}