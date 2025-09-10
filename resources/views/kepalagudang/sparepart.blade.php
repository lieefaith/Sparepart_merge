<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sparepart - Kepala Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --danger: #e63946;
            --light: #f8f9fa;
            --dark: #212529;
            --sidebar-width: 250px;
            --header-height: 70px;
            --card-border-radius: 12px;
            --sidebar-bg: #2c3e50;
            --sidebar-color: #ecf0f1;
            --sidebar-active: #3498db;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            color: #333;
            overflow-x: hidden;
            padding-top: var(--header-height);
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            height: var(--header-height);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .navbar-brand i {
            font-size: 1.8rem;
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: var(--sidebar-bg);
            color: var(--sidebar-color);
            min-height: calc(100vh - var(--header-height));
            width: var(--sidebar-width);
            position: fixed;
            left: 0;
            top: var(--header-height);
            transition: all 0.3s ease;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 900;
        }

        .sidebar .list-group-item {
            background: transparent;
            color: var(--sidebar-color);
            border: none;
            border-left: 4px solid transparent;
            border-radius: 0;
            padding: 1rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .sidebar .list-group-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: var(--sidebar-active);
        }

        .sidebar .list-group-item.active {
            background: linear-gradient(90deg, rgba(52, 152, 219, 0.2), transparent);
            border-left-color: var(--sidebar-active);
            color: white;
        }

        .sidebar .list-group-item i {
            width: 24px;
            margin-right: 12px;
            transition: all 0.3s;
        }

        .sidebar .list-group-item.active i {
            transform: scale(1.2);
        }

        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            width: calc(100% - var(--sidebar-width));
            transition: all 0.3s;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: white;
            border-radius: var(--card-border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            position: relative;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .stats-title {
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 0;
        }

        /* Table Styling */
        .table-container {
            background: white;
            border-radius: var(--card-border-radius);
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .table-container h5 {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1.2rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .table th {
            font-weight: 600;
            color: #495057;
            border-top: none;
            border-bottom: 2px solid #f0f0f0;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem 0.75rem;
        }

        /* Page Header */
        .page-header {
            background: white;
            border-radius: var(--card-border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Filter Card */
        .filter-card {
            background: white;
            border-radius: var(--card-border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Pagination */
        .pagination-container {
            background: white;
            border-radius: var(--card-border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 1rem 1.5rem;
            margin-top: 1.5rem;
        }

        /* Status Badge */
        .status-badge {
            padding: 0.5em 0.8em;
            font-size: 0.75em;
            font-weight: 600;
            border-radius: 0.5rem;
        }

        /* Button Action */
        .btn-action {
            padding: 0.3rem 0.5rem;
            font-size: 0.875rem;
            margin: 0 2px;
        }

        /* Date Badge */
        .badge-date {
            background: linear-gradient(45deg, var(--primary), var(--info));
            padding: 0.6rem 1.2rem;
            border-radius: 30px;
            font-weight: 500;
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.2);
            color: white;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                text-align: center;
            }

            .sidebar .list-group-item span {
                display: none;
            }

            .sidebar .list-group-item i {
                margin-right: 0;
                font-size: 1.3rem;
            }

            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }

            .sidebar.show {
                width: var(--sidebar-width);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }

        /* Animation for cards */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-card {
            animation: fadeIn 0.5s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }

        /* Additional improvements */
        .card-icon.bg-primary {
            background-color: rgba(67, 97, 238, 0.1) !important;
        }

        .card-icon.bg-danger {
            background-color: rgba(230, 57, 70, 0.1) !important;
        }

        .card-icon.bg-success {
            background-color: rgba(76, 201, 240, 0.1) !important;
        }

        .card-icon.bg-warning {
            background-color: rgba(247, 37, 133, 0.1) !important;
        }

        .bg-primary {
            background-color: var(--primary) !important;
        }

        .bg-danger {
            background-color: var(--danger) !important;
        }

        .bg-success {
            background-color: var(--success) !important;
        }

        .bg-warning {
            background-color: var(--warning) !important;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .text-danger {
            color: var(--danger) !important;
        }

        .text-success {
            color: var(--success) !important;
        }

        .text-warning {
            color: var(--warning) !important;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="navbar-toggler me-2 d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ route('kepalagudang.dashboard') }}">
                <i class="bi bi-archive-fill me-2"></i>
                <span>Kepala Gudang</span>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> Kepala Gudang
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i
                                        class="bi bi-person me-2"></i>Profil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"><i
                                        class="bi bi-box-arrow-right me-2"></i>Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="list-group list-group-flush">
            <a href="{{ route('kepalagudang.dashboard') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('kepalagudang.request.index') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-send"></i> <span>Request / Send</span>
            </a>
            <a href="{{ route('kepalagudang.sparepart.index') }}"
                class="list-group-item list-group-item-action py-3 active">
                <i class="bi bi-tools"></i> <span>Daftar Sparepart</span>
            </a>
            <a href="{{ route('kepalagudang.history.index') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-clock-history"></i> <span>Histori Barang</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-0"><i class="bi bi-tools me-2"></i>Daftar Sparepart</h4>
                    <p class="text-muted mb-0">Kelola data sparepart di gudang</p>
                </div>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahSparepartModal">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Sparepart
                    </button>
                    <a href="{{ route('kepalagudang.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card p-4">
                    <div class="card-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-tools"></i>
                    </div>
                    <h4 class="stats-number">{{ $totalQty }}</h4>
                    <p class="stats-title">Total Sparepart</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card p-4">
                    <div class="card-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h4 class="stats-number">{{ $totalTersedia }}</h4>
                    <p class="stats-title">Tersedia</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card p-4">
                    <div class="card-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4 class="stats-number">{{ $totalDipesan }}</h4>
                    <p class="stats-title">Dikirim</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card p-4">
                    <div class="card-icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <h4 class="stats-number">{{ $totalHabis }}</h4>
                    <p class="stats-title">Habis</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-card">
            <h5 class="mb-3"><i class="bi bi-funnel me-2"></i>Filter Data</h5>
            <form method="GET" action="{{ route('kepalagudang.sparepart.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="jenisFilter" class="form-label">Jenis Sparepart</label>
                        <select class="form-select" name="jenis" id="jenisFilter" onchange="this.form.submit()">
                            <option value="">Semua Jenis</option>
                            @foreach ($jenis as $j)
                                <option value="{{ $j->id }}"
                                    {{ (string) request('jenis') === (string) $j->id ? 'selected' : '' }}>
                                    {{ $j->jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="statusFilter" class="form-label">Status Sparepart</label>
                        <select class="form-select" name="status" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>
                                Tersedia</option>
                            <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis
                            </option>
                            <option value="dipesan" {{ request('status') == 'dipesan' ? 'selected' : '' }}>
                                Dipesan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="searchFilter" class="form-label">Cari Sparepart</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari ID atau nama sparepart..."
                                name="search" value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <a href="{{ route('kepalagudang.sparepart.index') }}" class="btn btn-light me-2">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-filter me-1"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID Sparepart</th>
                            <th>Jenis & Type</th>
                            <th>Quantity</th>
                            @if ($filterStatus === 'habis')
                                <th>Habis</th>
                            @elseif ($filterStatus === 'dipesan')
                                <th>Dipesan</th>
                            @else
                                <th>Tersedia</th>
                            @endif
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listBarang as $barang)
                            <tr>
                                <td><span class="fw-bold">{{ $barang->tiket_sparepart }}</span></td>
                                <td>{{ $barang->jenisBarang->jenis }} {{ $barang->tipeBarang->tipe }}</td>
                                <td>{{ $barang->quantity }}</td>
                                @if ($filterStatus === 'habis')
                                    <td>{{ $totalsPerTiket[$barang->tiket_sparepart]['habis'] ?? 0 }}</td>
                                @elseif ($filterStatus === 'dipesan')
                                    <td>{{ $totalsPerTiket[$barang->tiket_sparepart]['dipesan'] ?? 0 }}</td>
                                @else
                                    <td>{{ $totalsPerTiket[$barang->tiket_sparepart]['tersedia'] ?? 0 }}</td>
                                @endif
                                <td>
                                    <button class="btn btn-info btn-sm btn-detail"
                                        onclick="showDetail('{{ $barang->tiket_sparepart }}')" title="Detail">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Menampilkan {{ $listBarang->firstItem() }} hingga {{ $listBarang->lastItem() }} dari
                {{ $listBarang->total() }} entri
            </div>
            <nav aria-label="Page navigation">
                {{ $listBarang->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    </div>

    <!-- Modal Tambah Sparepart -->
    <div class="modal fade" id="tambahSparepartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahSparepartModalLabel"><i
                            class="bi bi-plus-circle me-2"></i>Tambah
                        Sparepart Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('kepalagudang.sparepart.store') }}" id="sparepartForm">
                        <div class="row g-3">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <label for="jenisSparepart" class="form-label">Jenis Sparepart</label>
                                <select class="form-select @error('jenisSparepart') is-invalid @enderror"
                                    id="jenisSparepart" name="jenisSparepart" required>
                                    <option value="" selected>Pilih jenis sparepart</option>
                                    @foreach ($jenis as $j)
                                        <option value="{{ $j->id }}"
                                            {{ old('jenisSparepart') == $j->id ? 'selected' : '' }}>
                                            {{ $j->jenis }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenisSparepart')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="typeSparepart" class="form-label">Type Sparepart</label>
                                <select class="form-select @error('typeSparepart') is-invalid @enderror"
                                    id="typeSparepart" name="typeSparepart" required>
                                    <option value="" selected>Pilih tipe sparepart</option>
                                    @foreach ($tipe as $t)
                                        <option value="{{ $t->id }}"
                                            {{ old('typeSparepart') == $t->id ? 'selected' : '' }}>{{ $t->tipe }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('typeSparepart')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="serialNumber" class="form-label">Serial Number</label>
                                <input type="text"
                                    class="form-control @error('serial_number') is-invalid @enderror"
                                    id="serialNumber" name="serial_number" placeholder="Masukkan serial number"
                                    value="{{ old('serial_number') }}">
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                    id="quantity" name="quantity" placeholder="Masukkan jumlah" required
                                    min="1" value="{{ old('quantity', 1) }}">
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="spk" class="form-label">SPK</label>
                                <input type="text" class="form-control @error('spk') is-invalid @enderror"
                                    id="spk" name="spk" placeholder="Masukkan SPK"
                                    value="{{ old('spk') }}">
                                @error('spk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                    id="harga" name="harga" placeholder="Masukkan harga" required
                                    value="{{ old('harga') }}">
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="vendor" class="form-label">Vendor</label>
                                <input type="text" class="form-control @error('vendor') is-invalid @enderror"
                                    id="vendor" name="vendor" placeholder="Masukkan vendor"
                                    value="{{ old('vendor') }}">
                                @error('vendor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="pic" class="form-label">PIC</label>
                                <input type="text" class="form-control @error('pic') is-invalid @enderror"
                                    id="pic" name="pic" placeholder="Masukkan PIC" required
                                    value="{{ old('pic') }}">
                                @error('pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control @error('department') is-invalid @enderror"
                                    id="department" name="department" placeholder="Masukkan department"
                                    value="{{ old('department') }}">
                                @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" rows="3" placeholder="Tambahkan keterangan tambahan..."></textarea>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Sparepart</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" id="editSparepartModal{{ $sparepart->id }}" tabindex="-1" aria-labelledby="editSparepartModalLabel{{ $sparepart->id }}" aria-hidden="true">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editSparepartModalLabel"><i class="bi bi-pencil-square me-2"></i>Edit Sparepart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editSparepartForm">
    @csrf
    @method('PUT')
                    <div class="row g-3">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- ID Sparepart -->
                        <div class="col-12">
                            <label for="tiketSparepart" class="form-label">ID Sparepart</label>
                            <input type="text" class="form-control" id="tiketSparepart" name="tiket_sparepart" value="{{ $sparepart->tiket_sparepart }}" disabled>
                        </div>
                        <!-- Serial Number -->
                        <div class="col-md-6">
                            <label for="serialNumber" class="form-label">Serial Number</label>
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror" id="serialNumber" name="serial_number" placeholder="Masukkan serial number" value="{{ old('serial_number', $sparepart->serial_number) }}">
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Type Sparepart -->
                        <div class="col-md-6">
                            <label for="typeSparepart" class="form-label">Type Sparepart</label>
                            <select class="form-select @error('typeSparepart') is-invalid @enderror" id="typeSparepart" name="typeSparepart" required>
                                <option value="" selected>Pilih tipe sparepart</option>
                                @foreach ($tipe as $t)
                                    <option value="{{ $t->id }}" {{ old('typeSparepart', $sparepart->tipe_id) == $t->id ? 'selected' : '' }}>
                                        {{ $t->tipe }}
                                    </option>
                                @endforeach
                            </select>
                            @error('typeSparepart')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Quantity -->
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" placeholder="Masukkan jumlah" required min="1" value="{{ old('quantity', $sparepart->quantity) }}">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Tanggal -->
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $sparepart->tanggal) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Harga -->
                        <div class="col-md-6">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" placeholder="Masukkan harga" required value="{{ old('harga', $sparepart->harga) }}">
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Vendor -->
                        <div class="col-md-6">
                            <label for="vendor" class="form-label">Vendor</label>
                            <input type="text" class="form-control @error('vendor') is-invalid @enderror" id="vendor" name="vendor" placeholder="Masukkan vendor" value="{{ old('vendor', $sparepart->vendor) }}">
                            @error('vendor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- PIC -->
                        <div class="col-md-6">
                            <label for="pic" class="form-label">PIC</label>
                            <input type="text" class="form-control @error('pic') is-invalid @enderror" id="pic" name="pic" placeholder="Masukkan PIC" required value="{{ old('pic', $sparepart->pic) }}">
                            @error('pic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Keterangan -->
                        <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control @error('department') is-invalid @enderror" id="department" name="department" placeholder="Masukkan department" value="{{ old('department', $sparepart->department) }}">
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan keterangan tambahan...">{{ old('keterangan', $sparepart->keterangan) }}</textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update Sparepart</button>
            </div>
            </form>
            @endforeach
        </div>
    </div> --}}
    </div>


    <div class="modal fade" id="sparepartDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-receipt me-2"></i>Detail Sparepart</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-primary" id="sparepart-spinner" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div id="sparepart-content" style="display:none;">
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>ID Sparepart:</strong> <span id="trx-id"></span></div>
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
                                        <th>Status</th>
                                        <th>Harga</th>
                                        <th>Vendor (Supplier)</th>
                                        <th>SPK</th>
                                        <th>PIC</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="trx-items-list">
                                </tbody>

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



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let sparepartDetailModal;

        document.addEventListener("DOMContentLoaded", function() {
            sparepartDetailModal = new bootstrap.Modal(document.getElementById('sparepartDetailModal'));

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
            // spinner dan konten sesuai dengan id modal detail kamu
            document.getElementById('sparepart-spinner').style.display = 'block';
            document.getElementById('sparepart-content').style.display = 'none';

            document.getElementById('trx-id').textContent = data.id || '-';

            const tbody = document.getElementById('trx-items-list');
            tbody.innerHTML = "";

            data.items.forEach((item, i) => {
                let statusClass = 'bg-secondary';
                if (item.status === 'tersedia') {
                    statusClass = 'bg-success';
                } else if (item.status === 'habis') {
                    statusClass = 'bg-danger';
                } else if (item.status === 'dipesan') {
                    statusClass = 'bg-warning';
                }

                const row = `
            <tr>
                <td>${i + 1}</td>
                <td>${item.serial || '-'}</td>
                <td>${data.type || '-'}</td>
                <td>${data.jenis || '-'}</td>
                <td><span class="badge ${statusClass}">${item.status ? item.status.charAt(0).toUpperCase() + item.status.slice(1) : '-'}</span></td>
                <td>${item.harga ? formatRupiah(item.harga) : '-'}</td>
                <td>${item.vendor || '-'}</td>
                <td>${item.spk || '-'}</td>
                <td>${item.pic || '-'}</td>
                <td>${item.keterangan || '-'}</td>
                <td>${item.tanggal || '-'}</td>
                <td>
                    <button class="btn btn-primary btn-action" data-bs-toggle="tooltip" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-action" data-bs-toggle="tooltip" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
                tbody.insertAdjacentHTML("beforeend", row);
            });

            document.getElementById('sparepart-spinner').style.display = 'none';
            document.getElementById('sparepart-content').style.display = 'block';

            sparepartDetailModal.show();
        }

        function showDetail(tiket_sparepart) {
            fetch(`/kepalagudang/sparepart/${tiket_sparepart}/detail`)
                .then(res => res.json())
                .then(data => {
                    showTransaksiDetail(data);
                    console.log(data);
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    alert('Gagal mengambil detail!');
                });
        }
    </script>
</body>

</html>