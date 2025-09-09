<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermintaanController extends Controller
{
    /**
     * Tampilkan list permintaan
     */
    public function index()
    {
        $permintaans = Permintaan::with(['user', 'details'])->orderBy('id', 'desc')->get();
        return view('user.requestbarang', compact('permintaans'));
    }

    /**
     * Simpan permintaan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'items.*.nama' => 'required|string|max:50',
            'items.*.deskripsi' => 'required|string|max:255',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.keterangan' => 'nullable|string|max:255',
        ]);

        $permintaan = Permintaan::create([
            'user_id' => Auth::id(),
            'tanggal_permintaan' => now(),
            
        ]);
        foreach ($request->items as $item) {
            $permintaan->details()->create([
                'tiket' => $permintaan->tiket,
                'nama_item' => $item['nama'],
                'deskripsi' => $item['deskripsi'],
                'jumlah' => $item['jumlah'],
                'keterangan' => $item['keterangan'] ?? null,
            ]);
        }

        return redirect()->route('request.store')->with('success', 'Permintaan berhasil dikirim!');
    }



    public function getDetail($tiket)
    {
        $permintaan = Permintaan::with(['details', 'user'])
            ->where('tiket', $tiket)
            ->firstOrFail();

        return response()->json([
            'tiket' => $permintaan->tiket,
            'tanggal_permintaan' => $permintaan->tanggal_permintaan,
            'name' => $permintaan->user->name,
            'details' => $permintaan->details->map(function ($detail) {
                return [
                    'nama' => $detail->nama_item,
                    'deskripsi' => $detail->deskripsi ?? '-',
                    'jumlah' => $detail->jumlah,
                    'keterangan' => $detail->keterangan ?? '-',
                ];
            }),
        ]);
    }
}
