@extends('layouts.superadmin')

@section('title', 'Dashboard Superadmin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Dashboard Overview</h3>
        <span class="badge bg-light text-dark">
            <i class="bi bi-calendar me-1"></i> {{ date('d F Y') }}
        </span>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card p-4">
                <div class="card-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-cart-check"></i>
                </div>
                <h4 class="stats-number">12</h4>
                <p class="stats-title">Request Barang Baru</p>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card p-4">
                <div class="card-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-tools"></i>
                </div>
                <h4 class="stats-number">156</h4>
                <p class="stats-title">Total Sparepart</p>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card p-4">
                <div class="card-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h4 class="stats-number">42</h4>
                <p class="stats-title">Transaksi Hari Ini</p>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card p-4">
                <div class="card-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-person-check"></i>
                </div>
                <h4 class="stats-number">5</h4>
                <p class="stats-title">User Aktif</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-7">
            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Request Terbaru</h5>
                    <a href="{{ route('superadmin.request.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Request</th>
                                <th>Requester</th>
                                <th>Barang Diminta</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>REQ001</td>
                                <td>RO Batam</td>
                                <td>Oli Mesin</td>
                                <td><span class="badge bg-warning status-badge">Menunggu</span></td>
                            </tr>
                            <tr>
                                <td>REQ002</td>
                                <td>RO Bekasi</td>
                                <td>Kampas Rem</td>
                                <td><span class="badge bg-info status-badge">Diproses</span></td>
                            </tr>
                            <tr>
                                <td>REQ003</td>
                                <td>RO Jambi</td>
                                <td>Filter Udara</td>
                                <td><span class="badge bg-success status-badge">Disetujui</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Stok Sparepart</h5>
                    <a href="{{ route('superadmin.sparepart.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sparepart</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Kampas Rem</td>
                                <td>120</td>
                                <td><span class="badge bg-success status-badge">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>Oli Mesin</td>
                                <td>85</td>
                                <td><span class="badge bg-success status-badge">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>Filter Oli</td>
                                <td>12</td>
                                <td><span class="badge bg-warning status-badge">Hampir Habis</span></td>
                            </tr>
                            <tr>
                                <td>Busi</td>
                                <td>5</td>
                                <td><span class="badge bg-danger status-badge">Habis</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
