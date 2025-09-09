<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Gudang</title>
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

        .dashboard-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .dashboard-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .dashboard-card:nth-child(4) {
            animation-delay: 0.3s;
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
            <a class="navbar-brand" href="#">
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
                            <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
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
            <a href="{{ route('kepalagudang.dashboard') }}" class="list-group-item list-group-item-action py-3 active">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('kepalagudang.request.index') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-send"></i> <span>Request / Send</span>
            </a>
            <a href="{{ route('kepalagudang.sparepart.index') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-tools"></i> <span>Daftar Sparepart</span>
            </a>
            <a href="{{ route('kepalagudang.history.index') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-clock-history"></i> <span>Histori Barang</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Dashboard Kepala Gudang</h3>
            <span class="badge badge-date"><i class="bi bi-calendar me-1"></i> <span
                    id="current-date">{{ date('d F Y') }}</span></span>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card p-4">
                    <div class="card-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-box-arrow-in-down"></i>
                    </div>
                    <h4 class="stats-number">25</h4>
                    <p class="stats-title">Barang Masuk</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card p-4">
                    <div class="card-icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-box-arrow-up"></i>
                    </div>
                    <h4 class="stats-number">10</h4>
                    <p class="stats-title">Barang Keluar</p>
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
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-md-6">
                <div class="table-container">
                    <h5><i class="bi bi-box-arrow-in-down me-2"></i>Barang Masuk Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge bg-primary">IN001</span></td>
                                    <td>Filter Oli</td>
                                    <td>30</td>
                                    <td>2025-08-28</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-primary">IN002</span></td>
                                    <td>Kampas Rem</td>
                                    <td>25</td>
                                    <td>2025-08-27</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-primary">IN003</span></td>
                                    <td>Busi</td>
                                    <td>50</td>
                                    <td>2025-08-27</td>
                                    <td><span class="badge bg-warning">Proses</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="table-container">
                    <h5><i class="bi bi-box-arrow-up me-2"></i>Barang Keluar Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge bg-danger">OUT001</span></td>
                                    <td>Kampas Rem</td>
                                    <td>15</td>
                                    <td>2025-08-30</td>
                                    <td><span class="badge bg-success">Terkirim</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-danger">OUT002</span></td>
                                    <td>Filter Oli</td>
                                    <td>20</td>
                                    <td>2025-08-29</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-danger">OUT003</span></td>
                                    <td>Oli Mesin</td>
                                    <td>35</td>
                                    <td>2025-08-29</td>
                                    <td><span class="badge bg-success">Terkirim</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to update date
        function updateDate() {
            const now = new Date();
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            const formattedDate = now.toLocaleDateString('id-ID', options);
            document.getElementById('current-date').textContent = formattedDate;
        }

        // Initial call
        updateDate();

        // Toggle sidebar on mobile (if needed)
        document.querySelector('.navbar-toggler').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>
</body>

</html>