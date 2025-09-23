<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\PengirimanDetail;
use App\Models\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tiket' => 'required|string|exists:permintaan,tiket',
            'tanggal_pengiriman' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.nama_item' => 'required|string|max:255',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        // Cek role Kepala Gudang
        if (Auth::user()->role !== 3) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $tiket = $request->tiket;
        $permintaan = Permintaan::where('tiket', $tiket)->firstOrFail();

        // Cek status form
        if ($permintaan->status !== 'diterima') {
            return response()->json([
                'success' => false,
                'message' => 'Form belum disetujui oleh Super Admin.'
            ], 400);
        }

        // Cek apakah sudah dikirim
        if ($permintaan->status_barang !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Barang sudah pernah dikirim.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Simpan pengiriman
            $pengiriman = Pengiriman::create([
                'tiket_pengiriman' => $tiket,
                'tiket_permintaan' => $tiket,
                'user_id' => Auth::id(),
                'tanggal_transaksi' => $request->tanggal_pengiriman,
                'status' => 'dikirim',
                'tanggal_perubahan' => now(),
            ]);

            // Simpan detail
            foreach ($request->items as $item) {
                PengirimanDetail::create([
                    'tiket_pengiriman' => $tiket,
                    'nama' => $item['nama_item'], // ✅ pakai kolom yang bener
                    'kategori' => $item['kategori'] ?? null,
                    'merk' => $item['merk'] ?? null,
                    'sn' => $item['sn'] ?? null,
                    'tipe' => $item['tipe'] ?? null,
                    'deskripsi' => $item['deskripsi'] ?? null,
                    'jumlah' => $item['jumlah'],
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
            }

            // Update status barang
            $permintaan->update([
                'status_barang' => 'on_delivery'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data pengiriman berhasil disimpan.',
                'redirect' => route('kepalagudang.request.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data pengiriman.'
            ], 500);
        }
    }
}