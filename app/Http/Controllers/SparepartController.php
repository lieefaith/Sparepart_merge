<?php

namespace App\Http\Controllers;

use App\Models\ListBarang;
use App\Models\Region;
use App\Models\JenisBarang;
use App\Models\TipeBarang;
use App\Models\DetailBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SparepartController extends Controller
{

    public function index(Request $request)
    {
        $jenisSparepart = JenisBarang::all();

        $query = ListBarang::with(['details', 'jenisBarang', 'tipeBarang']);

        if ($request->filled('jenis')) {
            $query->whereHas('jenisBarang', function ($q) use ($request) {
                $q->where('id', $request->jenis);
            });
        }

        if ($request->filled('status')) {
            $query->whereHas('details', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }


if ($request->filled('search')) {
    $search = $request->search;
    $query->where(function ($q) use ($search) {
        $keywords = explode(' ', $search); 

        $q->where('tiket_sparepart', 'like', "%$search%")
            ->orWhere(function ($q2) use ($keywords) {
                if (count($keywords) > 1) {
                    $q2->whereHas('jenisBarang', function ($q3) use ($keywords) {
                        $q3->where('jenis', 'like', "%{$keywords[0]}%");
                    })
                    ->whereHas('tipeBarang', function ($q3) use ($keywords) {
                        $q3->where('tipe', 'like', "%{$keywords[1]}%"); 
                    });
                }
            });
    });
}

        $listBarang = $query->orderBy('tiket_sparepart', 'desc')->paginate(5);

        $totalPerStatus = DB::table('detail_barang as d')
            ->select('d.status', DB::raw('SUM(d.quantity) as total_quantity'))
            ->groupBy('d.status')
            ->pluck('total_quantity', 'status');

        $totalTersedia = $totalPerStatus->get('tersedia', 0);
        $totalDipesan  = $totalPerStatus->get('dipesan', 0);
        $totalHabis    = $totalPerStatus->get('habis', 0);

        $totalsPerTiket = [];

foreach ($listBarang as $barang) {
    $tiket = $barang->tiket_sparepart;

    $totalPerStatus = collect($barang->details)
        ->groupBy('status')
        ->map(fn($items) => $items->sum('quantity'));

    $totalsPerTiket[$tiket] = [
        'tersedia' => $totalPerStatus->get('tersedia', 0),
        'dipesan'  => $totalPerStatus->get('dipesan', 0),
        'habis'    => $totalPerStatus->get('habis', 0),
    ];
}

        $regions = Region::all();
        $jenis = JenisBarang::all();
        $tipe = TipeBarang::all();
        $totalQty = DetailBarang::sum('quantity');

        return view('kepalagudang.sparepart', [
            'listBarang'    => $listBarang,
            'regions'       => $regions,
            'jenis'         => $jenis,
            'tipe'          => $tipe,
            'jenisSparepart' => $jenisSparepart,
            'totalQty'      => $totalQty,
            'totalTersedia' => $totalTersedia,
            'totalDipesan'  => $totalDipesan,
            'totalHabis'    => $totalHabis,
            'totalsPerTiket' => $totalsPerTiket,
            'filterJenis'   => $request->jenis,
            'filterStatus'  => $request->status,
            'search'        => $request->search,
        ]);
    }

    public function indexAdmin(Request $request)
    {
        $jenisSparepart = JenisBarang::all();

        $query = ListBarang::with(['details', 'jenisBarang', 'tipeBarang']);

        if ($request->filled('jenis')) {
            $query->whereHas('jenisBarang', function ($q) use ($request) {
                $q->where('id', $request->jenis);
            });
        }

        if ($request->filled('status')) {
            $query->whereHas('details', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }


if ($request->filled('search')) {
    $search = $request->search;
    $query->where(function ($q) use ($search) {
        $keywords = explode(' ', $search); 

        $q->where('tiket_sparepart', 'like', "%$search%")
            ->orWhere(function ($q2) use ($keywords) {
                if (count($keywords) > 1) {
                    $q2->whereHas('jenisBarang', function ($q3) use ($keywords) {
                        $q3->where('jenis', 'like', "%{$keywords[0]}%");
                    })
                    ->whereHas('tipeBarang', function ($q3) use ($keywords) {
                        $q3->where('tipe', 'like', "%{$keywords[1]}%"); 
                    });
                }
            });
    });
}

        $listBarang = $query->orderBy('tiket_sparepart', 'desc')->paginate(5);

        $totalPerStatus = DB::table('detail_barang as d')
            ->select('d.status', DB::raw('SUM(d.quantity) as total_quantity'))
            ->groupBy('d.status')
            ->pluck('total_quantity', 'status');

        $totalTersedia = $totalPerStatus->get('tersedia', 0);
        $totalDipesan  = $totalPerStatus->get('dipesan', 0);
        $totalHabis    = $totalPerStatus->get('habis', 0);

        $totalsPerTiket = [];

foreach ($listBarang as $barang) {
    $tiket = $barang->tiket_sparepart;

    $totalPerStatus = collect($barang->details)
        ->groupBy('status')
        ->map(fn($items) => $items->sum('quantity'));

    $totalsPerTiket[$tiket] = [
        'tersedia' => $totalPerStatus->get('tersedia', 0),
        'dipesan'  => $totalPerStatus->get('dipesan', 0),
        'habis'    => $totalPerStatus->get('habis', 0),
    ];
}

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
            'totalsPerTiket' => $totalsPerTiket,
            'filterJenis'   => $request->jenis,
            'filterStatus'  => $request->status,
            'search'        => $request->search,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'tanggal'        => 'required|date',
            'serial_number'  => 'nullable|string',
            'spk'            => 'nullable|string',
            'harga'          => 'nullable|numeric',
            'quantity'       => 'required|integer|min:1',
            'jenisSparepart' => 'required|exists:jenis_barang,id',
            'typeSparepart'  => 'required|exists:tipe_barang,id',
            'keterangan'     => 'nullable|string',
            'pic'            => 'required|string',
            'vendor'         => 'nullable|string',
            'department'     => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            $list = ListBarang::create([
                'tanggal'    => $request->tanggal,
                'jenis_id'   => $request->jenisSparepart,
                'tipe_id'    => $request->typeSparepart,
            ]);

            DetailBarang::create([
                'tiket_sparepart' => $list->tiket_sparepart,
                'serial_number'   => $request->serial_number,
                'spk'             => $request->spk,
                'tanggal'         => $request->tanggal,
                'harga'           => $request->harga,
                'quantity'        => $request->quantity,
                'jenis_id'        => $request->jenisSparepart,
                'tipe_id'         => $request->typeSparepart,
                'keterangan'      => $request->keterangan,
                'vendor'          => $request->vendor,
                'pic'             => $request->pic,
                'department'      => $request->department,
            ]);
        });

        return redirect()->back()->with('success', 'List & Detail Barang berhasil ditambahkan!');
    }


    // Update the specified sparepart
public function updateDetail(Request $request, $serial_number)
{
    // validasi input detail (sesuaikan dengan fieldmu)
    $request->validate([
        'serial_number' => 'required|string',
        'harga'         => 'required|numeric',
        'vendor'        => 'nullable|string',
        'spk'           => 'nullable|string',
        'pic'           => 'required|string',
        'department'    => 'nullable|string',
        'keterangan'    => 'nullable|string',
        'tanggal'       => 'required|date',
    ]);

    $detail = DetailBarang::where('serial_number', $serial_number)->firstOrFail();

    $detail->update([
        'serial_number' => $request->serial_number,
        'harga'         => $request->harga,
        'vendor'        => $request->vendor,
        'spk'           => $request->spk,
        'pic'           => $request->pic,
        'department'    => $request->department,
        'keterangan'    => $request->keterangan,
        'tanggal'       => $request->tanggal,
    ]);

    return redirect()->route('kepalagudang.sparepart.index')->with('success', 'Detail sparepart berhasil diperbarui.');

}


    public function showDetail($tiket_sparepart)
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
                    'status'     => $d->status,
                    'harga'      => $d->harga,
                    'vendor'     => $d->vendor ?? '-',
                    'spk'        => $d->spk,
                    'pic'        => $d->pic,
                    'department' => $d->department,
                    'keterangan' => $d->keterangan,
                    'tanggal'    => $d->tanggal
                ];
            }),
        ]);
    }
}