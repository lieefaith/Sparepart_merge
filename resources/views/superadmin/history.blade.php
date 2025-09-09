@extends('layouts.superadmin')

@section('title', 'Histori Barang - Superadmin')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-0"><i class="bi bi-clock-history me-2"></i>Histori Barang</h4>
                <p class="text-muted mb-0">Riwayat transaksi dan pergerakan barang</p>
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
    <div class="filter-card mb-4">
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
                <label for="statusFilter" class="form-label">Status</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="dikirim">Dikirim</option>
                    <option value="diterima">Diterima</option>
                    <option value="diproses">Diproses</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="jenisFilter" class="form-label">Jenis</label>
                <select class="form-select" id="jenisFilter">
                    <option value="">Semua Jenis</option>
                    <option value="masuk">Masuk</option>
                    <option value="keluar">Keluar</option>
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
    <div class="table-container mb-4">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Requester</th>
                        <th>Status</th>
                        <th>Tanggal Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="fw-bold">HIST001</span></td>
                        <td>RO BATAM</td>
                        <td><span class="badge bg-success status-badge">Dikirim</span></td>
                        <td>2025-08-25</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#detailModal1">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="fw-bold">HIST002</span></td>
                        <td>RO JAKARTA</td>
                        <td><span class="badge bg-warning status-badge">Diproses</span></td>
                        <td>2025-08-24</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#detailModal2">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="fw-bold">HIST003</span></td>
                        <td>RO SURABAYA</td>
                        <td><span class="badge bg-danger status-badge">Ditolak</span></td>
                        <td>2025-08-23</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#detailModal3">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="fw-bold">HIST004</span></td>
                        <td>RO BANDUNG</td>
                        <td><span class="badge bg-success status-badge">Dikirim</span></td>
                        <td>2025-08-22</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#detailModal4">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="fw-bold">HIST005</span></td>
                        <td>RO MEDAN</td>
                        <td><span class="badge bg-info status-badge">Diterima</span></td>
                        <td>2025-08-21</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#detailModal5">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal contoh (HIST001) -->
    <div class="modal fade" id="detailModal1" tabindex="-1" aria-labelledby="detailModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Transaksi HIST001</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#request1"
                                type="button">Form Request</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pengiriman1"
                                type="button">Form Pengiriman</button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <!-- Request -->
                        <div class="tab-pane fade show active" id="request1">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Barang</label>
                                    <input type="text" class="form-control" value="Filter Oli" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" value="50">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea class="form-control">Request untuk maintenance</textarea>
                                </div>
                            </form>
                        </div>

                        <!-- Pengiriman -->
                        <div class="tab-pane fade" id="pengiriman1">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Status Pengiriman</label>
                                    <select class="form-select">
                                        <option selected>Dikirim</option>
                                        <option>Dalam Perjalanan</option>
                                        <option>Sampai</option>
                                        <option>Ditolak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Kirim</label>
                                    <input type="date" class="form-control" value="2025-08-25">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Catatan</label>
                                    <textarea class="form-control">Pengiriman sesuai jadwal</textarea>
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
                <li class="page-item disabled">
                    <a class="page-link" href="#">Sebelumnya</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Selanjutnya</a>
                </li>
            </ul>
        </nav>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set tanggal default untuk filter
        const today = new Date();
        const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

        document.getElementById('dateFrom').valueAsDate = firstDayOfMonth;
        document.getElementById('dateTo').valueAsDate = today;
    });
</script>
@endpush
