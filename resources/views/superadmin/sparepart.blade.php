@extends('layouts.superadmin')

@section('title', 'Daftar Sparepart - Superadmin')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-0"><i class="bi bi-tools me-2"></i>Daftar Sparepart</h4>
                <p class="text-muted mb-0">Kelola inventaris sparepart dan stok barang</p>
            </div>
            <div>
                <span class="badge bg-light text-dark me-2">
                    <i class="bi bi-calendar me-1"></i> {{ date('d F Y') }}
                </span>
                <a href="{{ route('superadmin.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <form method="GET" action="{{ route('superadmin.sparepart.index') }}">
        <div class="filter-card mb-4">
            <h5 class="mb-4"><i class="bi bi-funnel me-2"></i>Filter Sparepart</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="statusFilter" class="form-label">Status Sparepart</label>
                    <select class="form-select" name="status" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                        <option value="dipesan" {{ request('status') == 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="jenisFilter" class="form-label">Jenis Sparepart</label>
                    <select class="form-select" name="jenis" id="jenisFilter">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenis as $j)
                            <option value="{{ $j->id }}" {{ (string) request('jenis') === (string) $j->id ? 'selected' : '' }}>
                                {{ $j->jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="searchFilter" class="form-label">Cari Sparepart</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari ID atau nama sparepart..."
                            name="search" value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('superadmin.sparepart.index') }}" class="btn btn-light me-2">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-filter me-1"></i> Terapkan Filter
                </button>
            </div>
        </div>
    </form>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-box-seam text-primary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Total Sparepart</h6>
                        <h4 class="mb-0 fw-bold text-primary">{{ $totalQty }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-check-circle text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Tersedia</h6>
                        <h4 class="mb-0 fw-bold text-success">{{ $totalTersedia }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-cart text-warning fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Dipesan</h6>
                        <h4 class="mb-0 fw-bold text-warning">{{ $totalDipesan }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-x-circle text-danger fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Habis</h6>
                        <h4 class="mb-0 fw-bold text-danger">{{ $totalHabis }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID Sparepart</th>
                        <th>Jenis & Type</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>PIC</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listBarang as $barang)
                        <tr>
                            <td><span class="fw-bold">{{ $barang->tiket_sparepart }}</span></td>
                            <td>{{ $barang->jenisBarang->jenis }} {{ $barang->tipeBarang->tipe }}</td>
                            <td>
                                <span class="badge
                                    @if ($barang->status == 'tersedia') bg-success
                                    @elseif($barang->status == 'habis') bg-danger
                                    @elseif($barang->status == 'dipesan') bg-warning
                                    @else bg-secondary @endif">
                                    {{ ucfirst($barang->status) }}
                                </span>
                            </td>
                            <td>{{ $barang->quantity }}</td>
                            <td>{{ $barang->pic }}</td>
                            <td>{{ \Carbon\Carbon::parse($barang->tanggal)->format('d-m-Y') }}</td>
                            <td>
                                <button class="btn btn-primary btn-action" data-bs-toggle="tooltip" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-action" data-bs-toggle="tooltip" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <button class="btn btn-info btn-action" 
                                    onclick="showDetail('{{ $barang->tiket_sparepart }}')"
                                    data-bs-toggle="tooltip" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                Tidak ada data sparepart
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination-container d-flex justify-content-between align-items-center">
        <div class="text-muted">
            Menampilkan {{ $listBarang->firstItem() }} hingga {{ $listBarang->lastItem() }} dari
            {{ $listBarang->total() }} entri
        </div>
        <nav aria-label="Page navigation">
            {{ $listBarang->links('pagination::bootstrap-5') }}
        </nav>
    </div>

    <!-- Modal Detail Sparepart -->
    <div class="modal fade" id="transaksiDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-receipt me-2"></i>Detail Sparepart</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-primary" id="transaksi-spinner" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div id="transaksi-content" style="display:none;">
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>ID Transaksi:</strong> <span id="trx-id"></span></div>
                            <div class="col-md-6"><strong>Tanggal:</strong> <span id="trx-date"></span></div>
                        </div>
                        <h6 class="mt-3 mb-2">Daftar Sparepart:</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Serial Number</th>
                                        <th>Type</th>
                                        <th>Jenis</th>
                                        <th>Harga</th>
                                        <th>Vendor (Supplier)</th>
                                        <th>SPK</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="trx-items-list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let transaksiDetailModal;

    document.addEventListener("DOMContentLoaded", function() {
        transaksiDetailModal = new bootstrap.Modal(document.getElementById('transaksiDetailModal'));

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Memeriksa jika ada error validasi saat halaman dimuat
        @if ($errors->any())
            const modal = new bootstrap.Modal(document.getElementById('tambahSparepartModal'));
            modal.show();
        @endif
    });

    function formatRupiah(val) {
        const num = Number(String(val).replace(/\D/g, '')) || 0;
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
    }

    function showTransaksiDetail(data) {
        document.getElementById('transaksi-spinner').style.display = 'block';
        document.getElementById('transaksi-content').style.display = 'none';

        document.getElementById('trx-id').textContent = data.id || '-';
        document.getElementById('trx-date').textContent = data.tanggal || '-';

        const tbody = document.getElementById('trx-items-list');
        tbody.innerHTML = "";

        data.items.forEach((item, i) => {
            const row = `
                <tr>
                    <td>${i + 1}</td>
                    <td>${item.serial || '-'}</td>
                    <td>${data.type || '-'}</td>
                    <td>${data.jenis || '-'}</td>
                    <td>${item.harga ? formatRupiah(item.harga) : '-'}</td>
                    <td>${item.vendor || '-'}</td>
                    <td>${item.spk || '-'}</td>
                    <td>${item.keterangan || '-'}</td>
                </tr>
            `;
            tbody.insertAdjacentHTML("beforeend", row);
        });

        document.getElementById('transaksi-spinner').style.display = 'none';
        document.getElementById('transaksi-content').style.display = 'block';
        transaksiDetailModal.show();
    }

    function showDetail(tiket_sparepart) {
        fetch(`/superadmin/sparepart/${tiket_sparepart}/detail`)
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                showTransaksiDetail(data);
            })
            .catch(err => {
                console.error('Fetch error:', err);
                alert('Gagal mengambil detail!');
            });
    }
</script>
@endpush
