<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KepalaROController extends Controller
{
    // Dashboard: Daftar permintaan menunggu approval
    public function index()
    {
        $user = Auth::user(); // Kepala RO login

        $requests = Permintaan::with(['user', 'details'])
            ->where('status', 'pending')
            ->whereHas('user', function($q) use ($user) {
                $q->where('region', $user->region); // filter berdasarkan region
            })
            ->get();

        return view('kepalaro.dashboard', compact('requests'));
    }

    // History: Semua permintaan (disetujui/ditolak)
  public function history(Request $request)
{
    $user = Auth::user();

    $query = Permintaan::with(['user', 'details'])
        ->whereHas('user', function($q) use ($user) {
            $q->where('region', $user->region);
        });

    // Filter status
    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }

    // Filter tanggal (created_at atau tanggal_permintaan)
    if ($request->filled('date_from') && $request->filled('date_to')) {
        $query->whereBetween('tanggal_permintaan', [
            $request->date_from,
            $request->date_to
        ]);
    }

   $requests = $query->orderByDesc('tanggal_permintaan')->get();


    return view('kepalaro.history', compact('requests'))
        ->with('filters', $request->only(['status', 'date_from', 'date_to']));
}

    // Approve permintaan
    public function approve($id)
    {
        $user = Auth::user();

        $request = Permintaan::where('id', $id)
            ->whereHas('user', function($q) use ($user) {
                $q->where('region', $user->region);
            })
            ->firstOrFail();

        $request->update(['status' => 'diterima']);

        return redirect()->back()->with('success', 'Permintaan disetujui!');
    }

    // Reject permintaan
    public function reject($id)
    {
        $user = Auth::user();

        $request = Permintaan::where('id', $id)
            ->whereHas('user', function($q) use ($user) {
                $q->where('region', $user->region);
            })
            ->firstOrFail();

        $request->update(['status' => 'ditolak']);

        return redirect()->back()->with('success', 'Permintaan ditolak!');
    }
}
