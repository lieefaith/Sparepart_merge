<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('superadmin.dashboard');
    }

    public function requestIndex()
    {
        $requests = Permintaan::with(['user'])
            ->where('status_gudang', 'approved') // ✅ Hanya yang sudah di-approve Kepala Gudang
            ->where('status_super_admin', 'pending') // ✅ Masih menunggu approval Superadmin
            ->orderBy('tanggal_permintaan', 'desc')
            ->get();

        return view('superadmin.request', compact('requests'));
    }

    public function approveRequest($tiket)
    {
        $permintaan = Permintaan::where('tiket', $tiket)->firstOrFail();
        $permintaan->update([
            'status_super_admin' => 'approved',
            'status' => 'diterima', // atau sesuai logika bisnis kamu
            'approved_by_super_admin' => auth()->id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Request disetujui']);
    }

    public function rejectRequest($tiket, Request $request)
    {
        $permintaan = Permintaan::where('tiket', $tiket)->firstOrFail();
        $permintaan->update([
            'status_super_admin' => 'rejected',
            'status' => 'ditolak',
            'catatan_super_admin' => $request->catatan,
            'approved_by_super_admin' => auth()->id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Request ditolak']);
    }

    public function historyIndex()
    {
        $requests = Permintaan::with(['user', 'details'])
            ->where('status_super_admin', '!=', 'pending') // ✅ Hanya yang sudah di-approve/ditolak
            ->orderBy('tanggal_permintaan', 'desc')
            ->get();

        return view('superadmin.history', compact('requests'));
    }

    public function historyDetailApi($tiket)
    {
        $permintaan = Permintaan::with(['user', 'details'])
            ->where('tiket', $tiket)
            ->first();

        if (!$permintaan) {
            return response()->json([
                'error' => 'Data permintaan tidak ditemukan'
            ], 404);
        }

        $pengiriman = \App\Models\Pengiriman::with('details')
            ->where('tiket_permintaan', $tiket)
            ->first();

        return response()->json([
            'permintaan' => $permintaan,
            'pengiriman' => $pengiriman,
        ]);
    }
}