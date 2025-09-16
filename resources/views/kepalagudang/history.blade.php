@extends('layouts.kepalagudang')

@section('title', 'History Sparepart - Kepalagudang')

@push('styles')
@endpush

    @section('content')

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

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-export">
                <i class="bi bi-download me-1"></i> Export Data
            </button>
        </div>

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
                        <tr>
                            <td><span class="fw-bold">HIST001</span></td>
                            <td>Filter Oli</td>
                            <td><span class="badge bg-info">Masuk</span></td>
                            <td><span class="badge bg-success">Diterima</span></td>
                            <td>2025-08-25</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistory">
                                    <i class="bi bi-clock-history"></i> History
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="fw-bold">HIST002</span></td>
                            <td>Kampas Rem</td>
                            <td><span class="badge bg-danger">Keluar</span></td>
                            <td><span class="badge bg-success">Dikirim</span></td>
                            <td>2025-08-26</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistory">
                                    <i class="bi bi-clock-history"></i> History
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="fw-bold">HIST003</span></td>
                            <td>Busi</td>
                            <td><span class="badge bg-info">Masuk</span></td>
                            <td><span class="badge bg-warning">Diproses</span></td>
                            <td>2025-08-27</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistory">
                                    <i class="bi bi-clock-history"></i> History
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="fw-bold">HIST004</span></td>
                            <td>Oli Mesin</td>
                            <td><span class="badge bg-danger">Keluar</span></td>
                            <td><span class="badge bg-danger">Ditolak</span></td>
                            <td>2025-08-28</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistory">
                                    <i class="bi bi-clock-history"></i> History
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="fw-bold">HIST005</span></td>
                            <td>Radiator</td>
                            <td><span class="badge bg-info">Masuk</span></td>
                            <td><span class="badge bg-success">Diterima</span></td>
                            <td>2025-08-29</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistory">
                                    <i class="bi bi-clock-history"></i> History
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-container d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Menampilkan 1 hingga 5 dari 25 entri
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Sebelumnya</a>
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
    </div>

    <div class="modal fade" id="modalHistory" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Detail History Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h6 class="fw-bold text-primary mb-3"><i class="bi bi-cart-check"></i> Data Request</h6>

                    <div class="mb-3">
                        <p><strong>No Tiket:</strong> REQ-2025-002</p>
                        <p><strong>Requester:</strong> Kepala RO</p>
                        <p><strong>Tanggal Request:</strong> 10 September 2025</p>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Item</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah Diminta</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Kampas Rem</td>
                                    <td>Kampas rem mobil tipe A</td>
                                    <td>25</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <hr>

                    <h6 class="fw-bold text-success mb-3"><i class="bi bi-truck"></i> Data Pengiriman</h6>

                    <div class="mb-3">
                        <p><strong>Tanggal Pengiriman:</strong> 12 September 2025</p>
                        <p><strong>Driver:</strong> Budi Santoso</p>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-success">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Item</th>
                                    <th>Merk</th>
                                    <th>SN</th>
                                    <th>Tipe</th>
                                    <th>Jumlah Dikirim</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Kampas Rem</td>
                                    <td>OEM</td>
                                    <td>SN-112233</td>
                                    <td>Tipe-A</td>
                                    <td>25</td>
                                    <td>Terkirim lengkap</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    @endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            document.getElementById('dateFrom').valueAsDate = firstDayOfMonth;
            document.getElementById('dateTo').valueAsDate = today;

            // Toggle sidebar on mobile (if needed)
            document.querySelector('.navbar-toggler').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('show');
            });
        });
    </script>
@endpush