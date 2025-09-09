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
                    <h4 class="stats-number">156</h4>
                    <p class="stats-title">Total Sparepart</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card p-4">
                    <div class="card-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h4 class="stats-number">120</h4>
                    <p class="stats-title">Tersedia</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card p-4">
                    <div class="card-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4 class="stats-number">25</h4>
                    <p class="stats-title">Dipesan</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card p-4">
                    <div class="card-icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <h4 class="stats-number">11</h4>
                    <p class="stats-title">Habis</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-card">
            <h5 class="mb-3"><i class="bi bi-funnel me-2"></i>Filter Data</h5>
            <form>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="jenisFilter" class="form-label">Jenis Sparepart</label>
                        <select class="form-select" id="jenisFilter">
                            <option selected>Semua Jenis</option>
                            <option>SFP 1G-850nm-300m</option>
                            <option>SFP 1G-1310nm-10km</option>
                            <option>Filter Oli</option>
                            <option>Kampas Rem</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option selected>Semua Status</option>
                            <option>Tersedia</option>
                            <option>Dipesan</option>
                            <option>Habis</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="picFilter" class="form-label">PIC</label>
                        <select class="form-select" id="picFilter">
                            <option selected>Semua PIC</option>
                            <option>Andi</option>
                            <option>Budi</option>
                            <option>Citra</option>
                            <option>Dewi</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tanggalFilter" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggalFilter">
                    </div>
                    <div class="col-12 text-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">Reset</button>
                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Daftar Sparepart</h5>
                <div class="d-flex">
                    <input type="text" class="form-control form-control-sm me-2" placeholder="Cari sparepart..."
                        style="width: 200px;">
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-download me-1"></i> Export
                    </button>
                </div>
            </div>

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
                        <tr>
                            <td><span class="fw-bold text-primary">SP001</span></td>
                            <td>SFP 1G-850nm-300m</td>
                            <td><span class="badge bg-success status-badge">Tersedia</span></td>
                            <td>25</td>
                            <td>Andi</td>
                            <td>2025-08-28</td>
                            <td>
                                <button class="btn btn-primary btn-action" data-bs-toggle="tooltip" title="Edit"><i
                                        class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-action" data-bs-toggle="tooltip" title="Hapus"><i
                                        class="bi bi-trash"></i></button>
                                <button class="btn btn-info btn-action" data-bs-toggle="tooltip" title="Detail"><i
                                        class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="fw-bold text-primary">SP002</span></td>
                            <td>SFP 1G-1310nm-10km</td>
                            <td><span class="badge bg-warning status-badge">Dipesan</span></td>
                            <td>10</td>
                            <td>Budi</td>
                            <td>2025-08-27</td>
                            <td>
                                <button class="btn btn-primary btn-action" data-bs-toggle="tooltip" title="Edit"><i
                                        class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-action" data-bs-toggle="tooltip" title="Hapus"><i
                                        class="bi bi-trash"></i></button>
                                <button class="btn btn-info btn-action" data-bs-toggle="tooltip" title="Detail"><i
                                        class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="fw-bold text-primary">SP003</span></td>
                            <td>Filter Oli</td>
                            <td><span class="badge bg-success status-badge">Tersedia</span></td>
                            <td>42</td>
                            <td>Citra</td>
                            <td>2025-08-29</td>
                            <td>
                                <button class="btn btn-primary btn-action" data-bs-toggle="tooltip" title="Edit"><i
                                        class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-action" data-bs-toggle="tooltip" title="Hapus"><i
                                        class="bi bi-trash"></i></button>
                                <button class="btn btn-info btn-action" data-bs-toggle="tooltip" title="Detail"><i
                                        class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="fw-bold text-primary">SP004</span></td>
                            <td>Kampas Rem</td>
                            <td><span class="badge bg-danger status-badge">Habis</span></td>
                            <td>0</td>
                            <td>Dewi</td>
                            <td>2025-08-25</td>
                            <td>
                                <button class="btn btn-primary btn-action" data-bs-toggle="tooltip" title="Edit"><i
                                        class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-action" data-bs-toggle="tooltip" title="Hapus"><i
                                        class="bi bi-trash"></i></button>
                                <button class="btn btn-info btn-action" data-bs-toggle="tooltip" title="Detail"><i
                                        class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination-container d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Menampilkan 1 hingga 4 dari 156 entri
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

    <!-- Modal Tambah Sparepart -->
    <div class="modal fade" id="tambahSparepartModal" tabindex="-1" aria-labelledby="tambahSparepartModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahSparepartModalLabel"><i class="bi bi-plus-circle me-2"></i>Tambah
                        Sparepart Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="jenisSparepart" class="form-label">Jenis</label>
                                <input type="text" class="form-control" id="jenisSparepart"
                                    placeholder="Masukkan jenis sparepart">
                            </div>
                            <div class="col-md-6">
                                <label for="typeSparepart" class="form-label">Type</label>
                                <input type="text" class="form-control" id="typeSparepart"
                                    placeholder="Masukkan type sparepart">
                            </div>
                            <div class="col-md-6">
                                <label for="serialNumber" class="form-label">Serial Number</label>
                                <input type="text" class="form-control" id="serialNumber"
                                    placeholder="Masukkan serial number">
                            </div>
                            <div class="col-md-6">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" min="0" placeholder="0">
                            </div>
                            <div class="col-md-6">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" min="0" placeholder="Rp">
                            </div>
                            <div class="col-md-6">
                                <label for="vendor" class="form-label">Vendor</label>
                                <input type="text" class="form-control" id="vendor" placeholder="Nama vendor">
                            </div>
                            <div class="col-12">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" rows="3"
                                    placeholder="Tambahkan keterangan tambahan..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan Sparepart</button>
                </div>
            </div>
        </div>
    </div>
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Function to update date
        function updateDate() {
            const now = new Date();
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            const formattedDate = now.toLocaleDateString('id-ID', options);
            document.getElementById('current-date').textContent = formattedDate;
        }

        // Set current date in filter
        document.getElementById('tanggalFilter').valueAsDate = new Date();

        // Toggle sidebar on mobile (if needed)
        document.querySelector('.navbar-toggler').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>
</body>

</html>