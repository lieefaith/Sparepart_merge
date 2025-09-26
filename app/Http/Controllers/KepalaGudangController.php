<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use App\Models\PengirimanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\DetailBarang;
use App\Models\ListBarang;

class KepalaGudangController extends Controller
{
    public function dashboard(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        $groups = DB::table('detail_barang')
            ->select('jenis_id', 'tipe_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('MAX(id) as latest_id'))
            ->whereDate('tanggal', $date)
            ->groupBy('jenis_id', 'tipe_id')
            ->get();

        if ($groups->isEmpty()) {
            $detail = collect();
            $totalPerDay = 0;
            return view('kepalagudang.dashboard', compact('detail', 'date', 'totalPerDay'));
        }

        $latestIds = $groups->pluck('latest_id')->filter()->all();

        $latestRecords = DetailBarang::with(['jenis', 'tipe'])
            ->whereIn('id', $latestIds)
            ->get()
            ->keyBy('id');

        $rows = $groups->map(function ($g) use ($latestRecords, $date) {
            $r = $latestRecords->get($g->latest_id);


            $jenis_nama = $r && $r->jenis ? $r->jenis->nama : null;
            $tipe_nama = $r && $r->tipe ? $r->tipe->nama : null;

            return (object) [
                'id' => $g->latest_id,
                'tiket_sparepart' => $r ? $r->tiket_sparepart : null,
                'nama_barang' => $r ? $r->nama_barang : null,
                'qty_record' => $r ? $r->quantity : 0,
                'jenis' => $r ? $r->jenis : (object) ['id' => $g->jenis_id, 'nama' => $jenis_nama],
                'tipe' => $r ? $r->tipe : (object) ['id' => $g->tipe_id, 'nama' => $tipe_nama],
                'jenis_nama' => $jenis_nama,
                'tipe_nama' => $tipe_nama,
                'total_qty' => (int) $g->total_qty,
                'tanggal' => $r ? $r->tanggal : $date,
            ];
        })->sortByDesc('tiket_sparepart')->values();

        $detail = $rows;
        $totalPerDay = $groups->sum('total_qty');
        $totalMasuk = DetailBarang::whereDate('tanggal', $date)->sum('quantity');
        $totalPending = Permintaan::whereDate('tanggal_permintaan', $date)
            ->where('status_gudang', 'pending')
            ->count();


        return view('kepalagudang.dashboard', compact('detail', 'date', 'totalPerDay', 'totalMasuk', 'totalPending'));
    }

    /**
     * Tampilkan daftar request yang sudah di-approve Kepala RO
     */
    public function requestIndex()
    {
        $requests = Permintaan::where('status_ro', 'approved')
            ->whereIn('status_gudang', ['pending', 'on progres'])
            ->with(['user', 'details']) // Load relasi jika diperlukan
            ->orderBy('tanggal_permintaan', 'desc')
            ->get();

        return view('kepalagudang.request', compact('requests'));
    }

    public function sparepartIndex()
    {
        return view('kepalagudang.sparepart');
    }

    public function kirim($id)
    {
        $permintaan = Permintaan::findOrFail($id);
        $permintaan->status_barang = 'on_delivery';
        $permintaan->save();

        return redirect()->back()->with('success', 'Barang berhasil dikirim.');
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

    public function approveGudang($tiket, Request $request)
    {
        \Log::info("🔥 approve() dipanggil", $request->all());

        $user = Auth::user();
        \Log::info("👤 User saat approve:", [
            'id' => $user?->id,
            'name' => $user?->name,
            'email' => $user?->email,
            'role' => $user?->role,
            'logged_in' => Auth::check(),
        ]);

        // ✅ Validasi: User harus login
        if (!$user) {
            \Log::error("❌ Tidak ada user login");
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login untuk melakukan aksi ini.'
            ], 401);
        }

        // ✅ Validasi: Hanya Kepala Gudang (role 3)
        if ((int) $user->role !== 3) {
            \Log::warning("❌ Role tidak diizinkan", ['role' => $user->role]);
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Hanya Kepala Gudang yang dapat menyetujui pengiriman.'
            ], 403);
        }

        try {
            // ✅ Validasi input
            $request->validate([
                'tiket' => 'required|string|exists:permintaan,tiket',
                'tanggal_pengiriman' => 'required|date',
                'items' => 'required|array|min:1',
                'items.*.kategori' => 'required|string',
                'items.*.nama_item' => 'required|string',
                'items.*.jumlah' => 'required|integer|min:1',
            ]);

            $tiket = $request->tiket;
            $permintaan = Permintaan::where('tiket', $tiket)->firstOrFail();
            if ($permintaan->status_gudang !== 'on progres') {
                return response()->json([
                    'success' => false,
                    'message' => 'Permintaan ini sudah diproses sebelumnya. Tidak dapat diproses ulang.',
                ], 400);
            }

            // ✅ Validasi: Hanya proses jika status_gudang masih 'pending'
            if ($permintaan->status_gudang !== 'on progres') {
                return response()->json([
                    'success' => false,
                    'message' => 'Permintaan ini sudah diproses sebelumnya. Tidak dapat diproses ulang.'
                ], 400);
            }

            // ✅ Buat tiket pengiriman unik
            $tiketKirim = 'TKT-KRM-' . now()->format('YmdHis');

            // ✅ Simpan data pengiriman
            \Log::info("🔧 Tiket Kirim:", [
                'tiket_kirim' => $tiketKirim,
                'tiket_permintaan' => $tiket,
                'user_id' => $user->id,
                'tanggal_pengiriman' => $request->tanggal_pengiriman,
            ]);
            $pengiriman = Pengiriman::create([
                'tiket_pengiriman' => $tiketKirim,
                'user_id' => $user->id,
                'tiket_permintaan' => $tiket,
                'tanggal_transaksi' => $request->tanggal_pengiriman,
                'status' => 'dikirim',
                'tanggal_perubahan' => now(),
            ]);

            // ✅ Simpan detail pengiriman — ambil data dari form
            foreach ($request->items as $item) {
                PengirimanDetail::create([
                    'tiket_pengiriman' => $tiketKirim,
                    'nama' => $item['nama_item'],
                    'kategori' => $item['kategori'], // ← langsung dari input form
                    'merk' => $item['merk'] ?? null,
                    'sn' => $item['sn'] ?? null,
                    'tipe' => $item['tipe'] ?? null,
                    'deskripsi' => $item['deskripsi'] ?? null,
                    'jumlah' => $item['jumlah'],
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
            }

            // ✅ Update status permintaan
            $permintaan->update([
                'status_gudang' => 'approved',
                'status_admin' => 'on progres',
                'approved_by_admin' => 13,
                'catatan_admin' => null,
                'status' => 'diterima',
            ]);

            \Log::info("✅ Status gudang dan admin berhasil diupdate");
            \Log::info("📦 Data pengiriman disimpan dengan tiket: " . $tiketKirim);

            // ✅ Response sukses — selalu sertakan message
            return response()->json([
                'success' => true,
                'message' => 'Permintaan berhasil dikirim ke Admin untuk proses selanjutnya.',
                'tiket_pengiriman' => $tiketKirim
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error("❌ Validasi gagal: " . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Data yang dikirim tidak valid. Periksa kembali form Anda.'
            ], 422);

        } catch (\Exception $e) {
            \Log::error("💥 ERROR DI APPROVE(): " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.'
            ], 500);
        }
    }

    public function rejectGudang(Request $request, $tiket)
{
    try {
        $permintaan = Permintaan::where('tiket', $tiket)->firstOrFail();

        // Ambil catatan dari request (opsional)
        $catatan = $request->input('catatan', 'Ditolak oleh Kepala Gudang');

        // Update semua status jadi rejected
        $permintaan->update([
            'status_gudang' => 'rejected',
            'status_ro' => 'rejected',
            'status_admin' => 'rejected',
            'status_super_admin' => 'rejected',
            'status_barang' => 'rejected', // ✅ 'closed', bukan 'rejected' (sesuai enum)
            'status' => 'ditolak',
            'catatan_gudang' => $catatan,
        ]);

        // ✅ Kembalikan JSON sukses
        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil ditolak.'
        ]);

    } catch (\Exception $e) {
        // ✅ Tangani error & kembalikan JSON error
        return response()->json([
            'success' => false,
            'message' => 'Gagal menolak permintaan: ' . $e->getMessage()
        ], 500);
    }
}

    public function approve(Request $request)
    {
        \Log::info("🔥 approve() dipanggil", $request->all());

        $user = Auth::user();
        \Log::info("👤 User saat approve:", [
            'id' => $user?->id,
            'name' => $user?->name,
            'email' => $user?->email,
            'role' => $user?->role,
            'logged_in' => Auth::check(),
        ]);

        // ✅ Validasi: User harus login
        if (!$user) {
            \Log::error("❌ Tidak ada user login");
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login untuk melakukan aksi ini.'
            ], 401);
        }

        // ✅ Validasi: Hanya Kepala Gudang (role 3)
        if ((int) $user->role !== 3) {
            \Log::warning("❌ Role tidak diizinkan", ['role' => $user->role]);
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Hanya Kepala Gudang yang dapat menyetujui pengiriman.'
            ], 403);
        }

        try {
            // ✅ Validasi input
            $request->validate([
                'tiket' => 'required|string|exists:permintaan,tiket',
                'tanggal_pengiriman' => 'required|date',
                'items' => 'required|array|min:1',
                'items.*.kategori' => 'required|string',
                'items.*.nama_item' => 'required|string',
                'items.*.jumlah' => 'required|integer|min:1',
            ]);

            $tiket = $request->tiket;
            $permintaan = Permintaan::where('tiket', $tiket)->firstOrFail();

            // ✅ Validasi: Hanya proses jika status_gudang masih 'pending'
            if ($permintaan->status_gudang !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Permintaan ini sudah diproses sebelumnya. Tidak dapat diproses ulang.'
                ], 400);
            }

            // ✅ Buat tiket pengiriman unik
            $tiketKirim = 'TKT-KRM-' . now()->format('YmdHis');

            // ✅ Simpan data pengiriman
            \Log::info("🔧 Tiket Kirim:", [
                'tiket_kirim' => $tiketKirim,
                'tiket_permintaan' => $tiket,
                'user_id' => $user->id,
                'tanggal_pengiriman' => $request->tanggal_pengiriman,
            ]);
            $pengiriman = Pengiriman::create([
                'tiket_pengiriman' => $tiketKirim,
                'user_id' => $user->id,
                'tiket_permintaan' => $tiket,
                'tanggal_transaksi' => $request->tanggal_pengiriman,
                'status' => 'dikirim',
                'tanggal_perubahan' => now(),
            ]);

            // ✅ Simpan detail pengiriman — ambil data dari form
            foreach ($request->items as $item) {
                PengirimanDetail::create([
                    'tiket_pengiriman' => $tiketKirim,
                    'nama' => $item['nama_item'],
                    'kategori' => $item['kategori'], // ← langsung dari input form
                    'merk' => $item['merk'] ?? null,
                    'sn' => $item['sn'] ?? null,
                    'tipe' => $item['tipe'] ?? null,
                    'deskripsi' => $item['deskripsi'] ?? null,
                    'jumlah' => $item['jumlah'],
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
            }

            // ✅ Update status permintaan
            $permintaan->update([
                'status_gudang' => 'approved',
                'status_admin' => 'on_progres',
                'approved_by_admin' => 15,
                'catatan_admin' => null,
            ]);

            \Log::info("✅ Status gudang dan admin berhasil diupdate");
            \Log::info("📦 Data pengiriman disimpan dengan tiket: " . $tiketKirim);

            // ✅ Response sukses — selalu sertakan message
            return response()->json([
                'success' => true,
                'message' => 'Permintaan berhasil dikirim ke Admin untuk proses selanjutnya.',
                'tiket_pengiriman' => $tiketKirim
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error("❌ Validasi gagal: " . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Data yang dikirim tidak valid. Periksa kembali form Anda.'
            ], 422);

        } catch (\Exception $e) {
            \Log::error("💥 ERROR DI APPROVE(): " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.'
            ], 500);
        }
    }
    /**
     * Tolak permintaan
     */
    public function reject(Request $request)
    {
        try {
            $request->validate(['tiket' => 'required|string|exists:permintaan,tiket']);

            $user = Auth::user();
            if (!$user || $user->role !== 3) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
            }

            $permintaan = Permintaan::where('tiket', $request->tiket)->firstOrFail();

            if ($permintaan->status_gudang !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Permintaan sudah diproses.'
                ], 400);
            }

            $permintaan->update([
                'status_gudang' => 'rejected',
                'status_ro' => 'rejected',
                'status_admin' => 'rejected',
                'status_super_admin' => 'rejected',
                'status_barang' => 'rejected', // 🔥 Wajib!
                'catatan_gudang' => $request->catatan ?? 'Ditolak oleh Kepala Gudang',
                'status' => 'ditolak',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Permintaan berhasil ditolak.'
            ]);
        } catch (\Exception $e) {
            \Log::error("💥 ERROR DI REJECT(): " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak permintaan.'
            ], 500);
        }
    }

    public function snInfo(Request $request)
    {
        $sn = $request->query('sn');

        if (empty($sn)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter SN kosong.',
                'item' => null,
            ], 200);
        }

        // Cari detail_barang yang punya serial_number tersebut
        $detail = DetailBarang::with(['listBarang', 'vendor']) // load relasi terkait
            ->where('serial_number', $sn)
            ->first();

        if (!$detail || !$detail->listBarang) {
            return response()->json([
                'success' => false,
                'message' => 'SN tidak ditemukan.',
                'item' => null,
            ], 200);
        }

        $item = $detail->listBarang;

        return response()->json([
            'success' => true,
            'item' => [
                'id' => $item->id,
                'tipe_id' => $detail->tipe_id ?? null,
                'vendor_id' => $detail->vendor_id ?? null,
                'keterangan' => $detail->keterangan ?? null,
                'jenis_id' => $detail->jenis_id ?? null,
                'serial_number' => $detail->serial_number ?? null,
            ],
        ], 200);
    }


    public function closedFormIndex()
    {
        // 🔸 Dummy data sementara (nanti diganti dengan query ke database)
        $permintaans = collect([
            (object) [
                'tiket' => 'REQ-JKT-04-2025-001',
                'user_name' => 'Ahmad Fauzi',
                'tanggal_penerimaan' => '2025-04-05 14:30',
                'foto_bukti_penerimaan' => 'validasi/bukti_001.jpg',
                'status_barang' => 'diterima',
            ],
            (object) [
                'tiket' => 'REQ-SBY-04-2025-003',
                'user_name' => 'Siti Rahayu',
                'tanggal_penerimaan' => '2025-04-06 09:15',
                'foto_bukti_penerimaan' => 'validasi/bukti_003.pdf',
                'status_barang' => 'diterima',
            ],
        ]);

        return view('kepalagudang.closed-form', compact('permintaans'));
    }

    public function verifyClosedForm(Request $request, $tiket)
{
    // Nanti isi logika verifikasi
    return redirect()->back()->with('success', 'Berhasil diverifikasi!');
}

}