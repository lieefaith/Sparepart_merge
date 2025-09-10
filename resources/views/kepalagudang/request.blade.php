<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Barang - Kepala Gudang</title>
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
        
        /* Card Styling */
        .card {
            border: none;
            border-radius: var(--card-border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .card-header {
            background: linear-gradient(120deg, #f8f9fa, #e9ecef);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-weight: 600;
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
            background-color: #f8f9fa;
        }
        
        .table td {
            vertical-align: middle;
            padding: 1rem 0.75rem;
        }
        
        /* Badge Styling */
        .badge {
            padding: 0.5em 0.8em;
            font-weight: 500;
        }
        
        /* Button Styling */
        .btn {
            border-radius: 6px;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
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
            
            .table-responsive {
                font-size: 0.875rem;
            }
        }
        
        /* Animation for cards */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .card {
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
        .page-title {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #6c757d;
            margin-bottom: 1.5rem;
        }
        
        .action-buttons .btn {
            margin-right: 0.5rem;
        }
        
        .action-buttons .btn:last-child {
            margin-right: 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="navbar-toggler me-2 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ route('kepalagudang.dashboard') }}">
                <i class="bi bi-archive-fill me-2"></i> Kepala Gudang
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
                            <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <div class="list-group list-group-flush">
            <a href="{{ route('kepalagudang.dashboard') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('kepalagudang.request.index') }}" class="list-group-item list-group-item-action py-3 active">
                <i class="bi bi-cart-check"></i> <span>Request Barang</span>
            </a>
            <a href="{{ route('kepalagudang.sparepart.index') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-tools"></i> <span>Daftar Sparepart</span>
            </a>
            <a href="{{ route('kepalagudang.history.index') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-clock-history"></i> <span>Histori Barang</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <h4 class="page-title"><i class="bi bi-cart-check me-2"></i> Daftar Request Barang</h4>
        <p class="page-subtitle">Kelola permintaan barang yang sudah di-approve Superadmin</p>
        

        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="diproses">Diproses</option>
                            <option value="dikirim">Dikirim</option>
                            <option value="diterima">Diterima</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="dateFilter" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="dateFilter">
                    </div>
                    <div class="col-md-4">
                        <label for="searchFilter" class="form-label">Pencarian</label>
                        <input type="text" class="form-control" id="searchFilter" placeholder="Cari ID Request, Requester, atau Barang...">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Terapkan Filter</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Request</th>
                                <th>Requester</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal Request</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="fw-bold">REQ001</span></td>
                                <td>RO Batam</td>
                                <td>Oli Mesin</td>
                                <td>50</td>
                                <td>28 Agu 2025</td>
                                <td><span class="badge bg-success">Disetujui</span></td>
                                <td class="action-buttons">
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTerima">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold">REQ002</span></td>
                                <td>RO Bekasi</td>
                                <td>Kampas Rem</td>
                                <td>25</td>
                                <td>27 Agu 2025</td>
                                <td><span class="badge bg-success">Disetujui</span></td>
                                <td class="action-buttons">
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTerima">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold">REQ003</span></td>
                                <td>RO Surabaya</td>
                                <td>Filter Udara</td>
                                <td>30</td>
                                <td>26 Agu 2025</td>
                                <td><span class="badge bg-warning">Menunggu</span></td>
                                <td class="action-buttons">
                                    <a href="#" class="btn btn-sm btn-secondary disabled">
                                        <i class="bi bi-clock"></i> Proses
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalRequest" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-cart-check"></i> Form Request Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Item</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" placeholder="Nama Item"></td>
                                        <td><input type="text" class="form-control" placeholder="Deskripsi"></td>
                                        <td><input type="number" class="form-control" value="1"></td>
                                        <td><input type="text" class="form-control" placeholder="Keterangan"></td>
                                        <td><button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-outline-primary"><i class="bi bi-plus"></i> Tambah Baris</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success">Kirim Request</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTerima" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-box-seam"></i> Terima & Kirim Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    
                    <h6 class="fw-bold text-primary mb-3"><i class="bi bi-cart-check"></i> Data Request (readonly)</h6>
                    
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
                                    <td>OEM</td>
                                    <td>25</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <hr>
                    
                    <h6 class="fw-bold text-success mb-3"><i class="bi bi-truck"></i> Form Pengiriman</h6>
                    
                    <form id="formPengiriman">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Pengiriman</label>
                                <input type="date" class="form-control" name="tanggal_pengiriman" required>
                            </div>
                        </div>
                        
                        <div class="mt-3 table-responsive">
                            <table class="table table-bordered" id="tabelBarang">
                                <thead class="table-success">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Merk</th>
                                        <th>SN</th>
                                        <th>Tipe</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" placeholder="Nama Item" required></td>
                                        <td><input type="text" class="form-control" placeholder="Merk"></td>
                                        <td><input type="text" class="form-control" placeholder="Serial Number"></td>
                                        <td><input type="text" class="form-control" placeholder="Tipe"></td>
                                        <td><input type="number" class="form-control" value="1" min="1" required></td>
                                        <td><input type="text" class="form-control" placeholder="Keterangan"></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-outline-success mt-2" onclick="tambahBaris()">
                            <i class="bi bi-plus"></i> Tambah Baris
                        </button>
                        
                        <div class="mt-3">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" name="catatan" rows="3" placeholder="Tambahkan catatan jika ada..."></textarea>
                        </div>
                    </form>
                    
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="formPengiriman" class="btn btn-success">
                        <i class="bi bi-send"></i> Kirim Barang
                    </button>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to toggle sidebar on mobile
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
        
        // Simple filter functionality
        document.getElementById('searchFilter').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
        
        // Fungsi untuk menambah baris pada form pengiriman
        function tambahBaris() {
            const table = document.getElementById('tabelBarang');
            const tbody = table.querySelector('tbody');
            const barisTerakhir = tbody.lastElementChild;
            const nomorBaru = tbody.children.length + 1;
            
            const barisBaru = document.createElement('tr');
            barisBaru.innerHTML = `
                <td>${nomorBaru}</td>
                <td><input type="text" class="form-control" placeholder="Nama Item" required></td>
                <td><input type="text" class="form-control" placeholder="Merk"></td>
                <td><input type="text" class="form-control" placeholder="Serial Number"></td>
                <td><input type="text" class="form-control" placeholder="Tipe"></td>
                <td><input type="number" class="form-control" value="1" min="1" required></td>
                <td><input type="text" class="form-control" placeholder="Keterangan"></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            
            tbody.appendChild(barisBaru);
        }
        
        // Fungsi untuk menghapus baris pada form pengiriman
        function hapusBaris(button) {
            const baris = button.closest('tr');
            const tbody = baris.parentElement;
            
            // Pastikan setidaknya ada satu baris tersisa
            if (tbody.children.length > 1) {
                baris.remove();
                
                // Perbarui nomor urut
                Array.from(tbody.children).forEach((baris, index) => {
                    baris.cells[0].textContent = index + 1;
                });
            } else {
                alert('Setidaknya harus ada satu barang dalam pengiriman.');
            }
        }
        
        // Event listener untuk form submission
        document.getElementById('formPengiriman').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Data pengiriman berhasil dikirim!');
            // Tutup modal setelah submit
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalTerima'));
            modal.hide();
        });
    </script>
</body>
</html>