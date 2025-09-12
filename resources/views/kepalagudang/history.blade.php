@extends('layouts.kepalagudang')
@section('title', 'Histori Barang - Kepala Gudang')

@push('styles')
@endpush

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-0"><i class="bi bi-clock-history me-2"></i>Histori Barang</h4>
                <p class="text-muted mb-0">Riwayat barang masuk & keluar gudang</p>
            </div>
            <a href="{{ route('kepalagudang.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card">
        <h5 class="mb-4"><i class="bi bi-funnel me-2"></i>Filter Data</h5>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="dateFrom" class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" id="dateFrom">
            </div>
            <div class="col-md-3 mb-3">
                <label for="dateTo" class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control" id="dateTo">
            </div>
            <div class="col-md-3 mb-3">
                <label for="jenisFilter" class="form-label">Jenis</label>
                <select class="form-select" id="jenisFilter">
                    <option value="">Semua Jenis</option>
                    <option value="masuk">Masuk</option>
                    <option value="keluar">Keluar</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="statusFilter" class="form-label">Status</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="dikirim">Dikirim</option>
                    <option value="diterima">Diterima</option>
                    <option value="diproses">Diproses</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button class="btn btn-light me-2">
                <i class="bi bi-arrow-clockwise me-1"></i> Reset
            </button>
            <button class="btn btn-primary">
                <i class="bi bi-search me-1"></i> Terapkan Filter
            </button>
        </div>
    </div>

    <!-- Export Button -->
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-export">
            <i class="bi bi-download me-1"></i> Export Data
        </button>
    </div>

    <!-- Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Barang</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- (sama persis seperti kode Anda) -->
                    <tr>
                        <td><span class="fw-bold">HIST001</span></td>
                        <td>Filter Oli</td>
                        <td><span class="badge bg-info">Masuk</span></td>
                        <td><span class="badge bg-success">Diterima</span></td>
                        <td>2025-08-25</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal1">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    <!-- ... baris lainnya seperti semula ... -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Detail Transaksi (salin semua modal yang Anda punya) -->
    <div class="modal fade" id="detailModal1" tabindex="-1" aria-labelledby="detailModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Transaksi HIST001</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- nav tabs & isi (sama persis) -->
                    <ul class="nav nav-tabs" id="transaksiTab1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="barang-tab1" data-bs-toggle="tab" data-bs-target="#barang1" type="button" role="tab">Detail Barang</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="status-tab1" data-bs-toggle="tab" data-bs-target="#status1" type="button" role="tab">Status</button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active" id="barang1" role="tabpanel">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" value="Filter Oli" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" value="50" readonly>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="status1" role="tabpanel">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Status Transaksi</label>
                                    <select class="form-select">
                                        <option selected>Diterima</option>
                                        <option>Dikirim</option>
                                        <option>Diproses</option>
                                        <option>Ditolak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" value="2025-08-25">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Catatan</label>
                                    <textarea class="form-control">Barang sudah diterima dengan baik</textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination-container d-flex justify-content-between align-items-center">
        <div class="text-muted">
            Menampilkan 1 hingga 5 dari 25 entri
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination mb-0">
                <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Sebelumnya</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Selanjutnya</a></li>
            </ul>
        </nav>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Highlight menu aktif
    const currentLocation = location.href;
    const menuItems = document.querySelectorAll('.list-group-item');
    const menuLength = menuItems.length;

    for (let i = 0; i < menuLength; i++) {
        if (menuItems[i].href === currentLocation) {
            menuItems[i].classList.add('active');
        }
    }

    // Set tanggal default untuk filter
    const today = new Date();
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    if (dateFrom) dateFrom.valueAsDate = firstDayOfMonth;
    if (dateTo) dateTo.valueAsDate = today;
    
    // Toggle sidebar on mobile (if needed)
    const navbarToggler = document.querySelector('.navbar-toggler');
    if (navbarToggler) {
        navbarToggler.addEventListener('click', function() {
            const sb = document.querySelector('.sidebar');
            if (sb) sb.classList.toggle('show');
        });
    }
});
</script>
@endpush