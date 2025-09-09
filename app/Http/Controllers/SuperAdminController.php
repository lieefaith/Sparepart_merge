<?php

namespace App\Http\Controllers;

use App\Models\ListBarang;
use App\Models\Region;
use App\Models\JenisBarang;
use App\Models\TipeBarang;
use App\Models\DetailBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

    public function sparepartIndex(Request $request)
    {
        $jenisSparepart = JenisBarang::all();

        $query = ListBarang::with(['details', 'jenisBarang', 'tipeBarang']);

        if ($request->filled('jenis')) {
            $query->whereHas('jenisBarang', function ($q) use ($request) {
                $q->where('jenis', $request->jenis);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tiket_sparepart', 'like', "%$search%")
                    ->orWhereHas('tipeBarang', function ($q2) use ($search) {
                        $q2->where('tipe', 'like', "%$search%");
                    });
            });
        }

        $listBarang = $query->orderBy('tiket_sparepart', 'desc')->paginate(5);

        $totalPerStatus = DB::table('detail_barang as d')
            ->join('list_barang as l', 'd.tiket_sparepart', '=', 'l.tiket_sparepart')
            ->select('l.status', DB::raw('SUM(d.quantity) as total_quantity'))
            ->groupBy('l.status')
            ->pluck('total_quantity', 'status');

        $totalTersedia = $totalPerStatus->get('tersedia', 0);
        $totalDipesan  = $totalPerStatus->get('dipesan', 0);
        $totalHabis    = $totalPerStatus->get('habis', 0);

        $regions = Region::all();
        $jenis = JenisBarang::all();
        $tipe = TipeBarang::all();
        $totalQty = DetailBarang::sum('quantity');

        return view('superadmin.sparepart', [
            'listBarang'    => $listBarang,
            'regions'       => $regions,
            'jenis'         => $jenis,
            'tipe'          => $tipe,
            'jenisSparepart' => $jenisSparepart,
            'totalQty'      => $totalQty,
            'totalTersedia' => $totalTersedia,
            'totalDipesan'  => $totalDipesan,
            'totalHabis'    => $totalHabis,
            'filterJenis'   => $request->jenis,
            'filterStatus'  => $request->status,
            'search'        => $request->search,
        ]);

    }

     public function showDetailAdmin($tiket_sparepart)
    {
        $list = ListBarang::with(['details', 'jenisBarang', 'tipeBarang'])
            ->where('tiket_sparepart', $tiket_sparepart)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'id'      => $list->tiket_sparepart,
            'tanggal' => \Carbon\Carbon::parse($list->tanggal)->format('d F Y'),
            'type'       => $list->tipeBarang->tipe ?? '-',
            'jenis'      => $list->jenisBarang->jenis ?? '-',
            'items'   => $list->details->map(function ($d) {
                return [
                    'serial'     => $d->serial_number,
                    'harga'      => $d->harga,
                    'vendor'     => $d->vendor ?? '-',
                    'spk'        => $d->spk,
                    'keterangan' => $d->keterangan,
                ];
            }),
        ]);
    }

    public function historyIndex()
    {
        return view('superadmin.history');
    }
}

