<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori Barang - Kepala Gudang</title>
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
            height: 100%;
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
        
        /* Date Badge */
        .badge-date {
            background: linear-gradient(45deg, var(--primary), var(--info));
            padding: 0.6rem 1.2rem;
            border-radius: 30px;
            font-weight: 500;
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.2);
            color: white;
        }
        
        /* Filter Card */
        .filter-card {
            background: white;
            border-radius: var(--card-border-radius);
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }
        
        /* Pagination Container */
        .pagination-container {
            background: white;
            border-radius: var(--card-border-radius);
            padding: 1rem 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 2rem;
        }
        
        /* Page Header */
        .page-header {
            background: white;
            border-radius: var(--card-border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        /* Button Export */
        .btn-export {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            transition: all 0.3s;
        }
        
        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            color: white;
        }
        
        /* Modal Styling */
        .modal-content {
            border-radius: var(--card-border-radius);
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .modal-header {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
            border-top-left-radius: var(--card-border-radius);
            border-top-right-radius: var(--card-border-radius);
        }
        
        /* Nav Tabs */
        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
            border: none;
            border-bottom: 3px solid transparent;
            padding: 0.75rem 1rem;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary);
            background: transparent;
            border-bottom: 3px solid var(--primary);
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
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
        .card-icon.bg-primary { background-color: rgba(67, 97, 238, 0.1) !important; }
        .card-icon.bg-danger { background-color: rgba(230, 57, 70, 0.1) !important; }
        .card-icon.bg-success { background-color: rgba(76, 201, 240, 0.1) !important; }
        .card-icon.bg-warning { background-color: rgba(247, 37, 133, 0.1) !important; }
        
        .bg-primary { background-color: var(--primary) !important; }
        .bg-danger { background-color: var(--danger) !important; }
        .bg-success { background-color: var(--success) !important; }
        .bg-warning { background-color: var(--warning) !important; }
        
        .text-primary { color: var(--primary) !important; }
        .text-danger { color: var(--danger) !important; }
        .text-success { color: var(--success) !important; }
        .text-warning { color: var(--warning) !important; }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="navbar-toggler me-2 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
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
            <a href="{{ route('kepalagudang.sparepart.index') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-tools"></i> <span>Daftar Sparepart</span>
            </a>
            <a href="{{ route('kepalagudang.history.index') }}" class="list-group-item list-group-item-action py-3 active">
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
                        <tr>
                            <td><span class="fw-bold">HIST001</span></td>
                            <td>Filter Oli</td>
                            <td><span class="badge bg-info">Masuk</span></td>
                            <td><span class="badge bg-success">Diterima</span></td>
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
                            <td>Kampas Rem</td>
                            <td><span class="badge bg-danger">Keluar</span></td>
                            <td><span class="badge bg-success">Dikirim</span></td>
                            <td>2025-08-26</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailModal2">
                                    <i class="bi bi-eye"></i> Detail
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
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailModal3">
                                    <i class="bi bi-eye"></i> Detail
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
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailModal4">
                                    <i class="bi bi-eye"></i> Detail
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

        <!-- Modal Detail Transaksi -->
        <div class="modal fade" id="detailModal1" tabindex="-1" aria-labelledby="detailModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel1">Detail Transaksi HIST001</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="transaksiTab1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="barang-tab1" data-bs-toggle="tab"
                                    data-bs-target="#barang1" type="button" role="tab">Detail Barang</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="status-tab1" data-bs-toggle="tab"
                                    data-bs-target="#status1" type="button" role="tab">Status</button>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content mt-3">
                            <!-- Detail Barang -->
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

                            <!-- Status -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

            document.getElementById('dateFrom').valueAsDate = firstDayOfMonth;
            document.getElementById('dateTo').valueAsDate = today;
            
            // Toggle sidebar on mobile (if needed)
            document.querySelector('.navbar-toggler').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('show');
            });
        });
    </script>
</body>

</html>