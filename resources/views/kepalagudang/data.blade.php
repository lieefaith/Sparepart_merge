<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Sparepart - Kepala Gudang</title>
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
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }

        /* Form Styling */
        .form-container {
            background: white;
            border-radius: var(--card-border-radius);
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        /* Button Styling */
        .btn {
            border-radius: 6px;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }

        .btn-primary {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(120deg, var(--secondary), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
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

        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary);
            font-weight: 600;
            border-bottom: 3px solid var(--primary);
        }

        .required-field::after {
            content: " *";
            color: var(--danger);
        }

        .simple-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .edit-mode {
            display: none;
        }

        .badge-aset {
            background-color: var(--success);
        }

        .badge-non-aset {
            background-color: var(--info);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="navbar-toggler me-2 d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">
                <i class="bi bi-archive-fill me-2"></i> Kepala Gudang
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> Kepala Gudang
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
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

    <div class="sidebar">
        <div class="list-group list-group-flush">
            <a href="{{ route('kepalagudang.dashboard') }}" class="list-group-item list-group-item-action py-3 ">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('kepalagudang.request.index') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-send"></i> <span>Request / Send</span>
            </a>
            <a href="{{ route('kepalagudang.sparepart.index') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-tools"></i> <span>Daftar Sparepart</span>
            </a>
            <a href="{{ route('kepalagudang.data') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-folder2-open"></i> <span>Data</span>
            </a>
            <a href="{{ route('kepalagudang.history.index') }}" class="list-group-item list-group-item-action py-3">
                <i class="bi bi-clock-history"></i> <span>Histori Barang</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <h4 class="page-title"><i class="bi bi-plus-circle me-2"></i> Tambah Data Sparepart</h4>
        <p class="page-subtitle">Kelola data jenis sparepart, tipe sparepart, dan vendor</p>

        <div class="card shadow-sm">
            <div class="card-body">
                <ul class="nav nav-tabs mb-4" id="sparepartTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="jenis-tab" data-bs-toggle="tab" data-bs-target="#jenis"
                            type="button" role="tab">
                            <i class="bi bi-grid me-1"></i> Jenis Sparepart
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tipe-tab" data-bs-toggle="tab" data-bs-target="#tipe" type="button"
                            role="tab">
                            <i class="bi bi-tag me-1"></i> Tipe Sparepart
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="vendor-tab" data-bs-toggle="tab" data-bs-target="#vendor"
                            type="button" role="tab">
                            <i class="bi bi-building me-1"></i> Vendor
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="sparepartTabsContent">
                    <!-- Tab Jenis Sparepart -->
                    <div class="tab-pane fade show active" id="jenis" role="tabpanel">
                        <div class="form-container">
                            <h5 class="mb-4 text-center"><i class="bi bi-grid me-2"></i>
                                <span class="add-mode">Tambah Jenis Sparepart</span>
                                <span class="edit-mode">Edit Jenis Sparepart</span>
                            </h5>
                            <form id="formJenis" class="simple-form">
                                <input type="hidden" id="jenisId">
                                <div class="mb-4">
                                    <label for="namaJenis" class="form-label required-field">Nama Jenis
                                        Sparepart</label>
                                    <input type="text" class="form-control form-control-lg" id="namaJenis"
                                        placeholder="Masukkan nama jenis sparepart" required>
                                </div>
                                <div class="mb-4">
                                    <label for="kategoriJenis" class="form-label required-field">Kategori</label>
                                    <select class="form-select form-select-lg" id="kategoriJenis" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Aset">Aset</option>
                                        <option value="Non Aset">Non Aset</option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-save me-1"></i> <span class="add-mode">Simpan</span><span
                                            class="edit-mode">Update</span> Jenis Sparepart
                                    </button>
                                    <button type="button" id="batalEditJenis"
                                        class="btn btn-secondary btn-lg edit-mode ms-2">
                                        <i class="bi bi-x-circle me-1"></i> Batal
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive mt-4">
                            <h5 class="mb-3"><i class="bi bi-list-ul me-2"></i> Daftar Jenis Sparepart</h5>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Jenis</th>
                                        <th>Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableJenisBody">
                                    <tr>
                                        <td>1</td>
                                        <td>Engine Parts</td>
                                        <td><span class="badge bg-success">Aset</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"
                                                onclick="editJenis(1, 'Engine Parts', 'Aset')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="hapusJenis(1)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Electrical Parts</td>
                                        <td><span class="badge bg-info">Non Aset</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"
                                                onclick="editJenis(2, 'Electrical Parts', 'Non Aset')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="hapusJenis(2)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Suspension Parts</td>
                                        <td><span class="badge bg-success">Aset</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"
                                                onclick="editJenis(3, 'Suspension Parts', 'Aset')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="hapusJenis(3)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Tipe Sparepart -->
                    <div class="tab-pane fade" id="tipe" role="tabpanel">
                        <div class="form-container">
                            <h5 class="mb-4 text-center"><i class="bi bi-tag me-2"></i>
                                <span class="add-mode">Tambah Tipe Sparepart</span>
                                <span class="edit-mode">Edit Tipe Sparepart</span>
                            </h5>
                            <form id="formTipe" class="simple-form">
                                <input type="hidden" id="tipeId">
                                <div class="mb-4">
                                    <label for="namaTipe" class="form-label required-field">Nama Tipe Sparepart</label>
                                    <input type="text" class="form-control form-control-lg" id="namaTipe"
                                        placeholder="Masukkan nama tipe sparepart" required>
                                </div>
                                <!-- Inside the Tipe Sparepart Tab -->
                                <div class="mb-4">
                                    <label for="kategoriTipe" class="form-label required-field">Kategori</label>
                                    <select class="form-select form-select-lg" id="kategoriTipe" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Aset">Aset</option>
                                        <option value="Non Aset">Non Aset</option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-save me-1"></i> <span class="add-mode">Simpan</span><span
                                            class="edit-mode">Update</span> Tipe Sparepart
                                    </button>
                                    <button type="button" id="batalEditTipe"
                                        class="btn btn-secondary btn-lg edit-mode ms-2">
                                        <i class="bi bi-x-circle me-1"></i> Batal
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive mt-4">
                            <h5 class="mb-3"><i class="bi bi-list-ul me-2"></i> Daftar Tipe Sparepart</h5>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tipe</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableTipeBody">
                                    <tr>
                                        <td>1</td>
                                        <td>Piston Set</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"
                                                onclick="editTipe(1, 'Piston Set')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="hapusTipe(1)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Alternator</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"
                                                onclick="editTipe(2, 'Alternator')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="hapusTipe(2)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Shock Absorber</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"
                                                onclick="editTipe(3, 'Shock Absorber')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="hapusTipe(3)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Vendor -->
                    <div class="tab-pane fade" id="vendor" role="tabpanel">
                        <div class="form-container">
                            <h5 class="mb-4 text-center"><i class="bi bi-building me-2"></i>
                                <span class="add-mode">Tambah Vendor</span>
                                <span class="edit-mode">Edit Vendor</span>
                            </h5>
                            <form id="formVendor" class="simple-form">
                                <input type="hidden" id="vendorId">
                                <div class="mb-4">
                                    <label for="namaVendor" class="form-label required-field">Nama Vendor</label>
                                    <input type="text" class="form-control form-control-lg" id="namaVendor"
                                        placeholder="Masukkan nama vendor" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-save me-1"></i> <span class="add-mode">Simpan</span><span
                                            class="edit-mode">Update</span> Vendor
                                    </button>
                                    <button type="button" id="batalEditVendor"
                                        class="btn btn-secondary btn-lg edit-mode ms-2">
                                        <i class="bi bi-x-circle me-1"></i> Batal
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive mt-4">
                            <h5 class="mb-3"><i class="bi bi-list-ul me-2"></i> Daftar Vendor</h5>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Vendor</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableVendorBody">
                                    <tr>
                                        <td>1</td>
                                        <td>PT Auto Parts Indonesia</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"
                                                onclick="editVendor(1, 'PT Auto Parts Indonesia')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="hapusVendor(1)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>CV Maju Jaya Sparepart</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"
                                                onclick="editVendor(2, 'CV Maju Jaya Sparepart')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="hapusVendor(2)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>PT Sumber Rejeki Motor</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"
                                                onclick="editVendor(3, 'PT Sumber Rejeki Motor')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="hapusVendor(3)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Data storage (simulasi database)
        let jenisData = [
            { id: 1, nama: 'Engine Parts', kategori: 'Aset' },
            { id: 2, nama: 'Electrical Parts', kategori: 'Non Aset' },
            { id: 3, nama: 'Suspension Parts', kategori: 'Aset' }
        ];

        let tipeData = [
            { id: 1, nama: 'Piston Set' },
            { id: 2, nama: 'Alternator' },
            { id: 3, nama: 'Shock Absorber' }
        ];

        let vendorData = [
            { id: 1, nama: 'PT Auto Parts Indonesia' },
            { id: 2, nama: 'CV Maju Jaya Sparepart' },
            { id: 3, nama: 'PT Sumber Rejeki Motor' }
        ];

        // Variables untuk operasi edit/hapus
        let currentDeleteId = null;
        let currentDeleteType = null;
        const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

        // Function to toggle sidebar on mobile
        document.querySelector('.navbar-toggler').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Toggle mode (add/edit)
        function toggleEditMode(type, isEdit) {
            const elements = document.querySelectorAll(`#${type} .edit-mode, #${type} .add-mode`);
            elements.forEach(el => {
                if (el.classList.contains('edit-mode')) {
                    el.style.display = isEdit ? 'inline' : 'none';
                } else {
                    el.style.display = isEdit ? 'none' : 'inline';
                }
            });
        }

        // Reset form
        function resetForm(type) {
            document.getElementById(`${type}Id`).value = '';
            document.getElementById(`nama${type.charAt(0).toUpperCase() + type.slice(1)}`).value = '';

            // Reset kategori hanya untuk jenis
            if (type === 'jenis') {
                document.getElementById('kategoriJenis').value = '';
            }

            toggleEditMode(type, false);
        }

        // ===== JENIS SPAREPART =====
        // Form submission handlers
        document.getElementById('formJenis').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('jenisId').value;
            const namaJenis = document.getElementById('namaJenis').value;
            const kategoriJenis = document.getElementById('kategoriJenis').value;

            if (namaJenis.trim() === '') {
                alert('Nama jenis sparepart tidak boleh kosong!');
                return;
            }

            if (kategoriJenis === '') {
                alert('Kategori harus dipilih!');
                return;
            }

            if (id) {
                // Edit existing
                const index = jenisData.findIndex(item => item.id == id);
                if (index !== -1) {
                    jenisData[index].nama = namaJenis;
                    jenisData[index].kategori = kategoriJenis;
                    alert('Data jenis sparepart berhasil diupdate!');
                }
            } else {
                // Add new
                const newId = jenisData.length > 0 ? Math.max(...jenisData.map(item => item.id)) + 1 : 1;
                jenisData.push({ id: newId, nama: namaJenis, kategori: kategoriJenis });
                alert('Data jenis sparepart "' + namaJenis + '" berhasil disimpan!');
            }

            renderJenisTable();
            this.reset();
            resetForm('jenis');
        });

        // Edit jenis
        function editJenis(id, nama, kategori) {
            document.getElementById('jenisId').value = id;
            document.getElementById('namaJenis').value = nama;
            document.getElementById('kategoriJenis').value = kategori;
            document.getElementById('namaJenis').focus();
            toggleEditMode('jenis', true);
        }

        // Hapus jenis
        function hapusJenis(id) {
            currentDeleteId = id;
            currentDeleteType = 'jenis';
            document.getElementById('confirmDelete').onclick = confirmDeleteJenis;
            confirmDeleteModal.show();
        }

        function confirmDeleteJenis() {
            jenisData = jenisData.filter(item => item.id != currentDeleteId);
            renderJenisTable();
            confirmDeleteModal.hide();
            alert('Data berhasil dihapus!');
        }

        // Render table
        function renderJenisTable() {
            const tableBody = document.getElementById('tableJenisBody');
            tableBody.innerHTML = '';

            jenisData.forEach((item, index) => {
                const badgeClass = item.kategori === 'Aset' ? 'badge-aset' : 'badge-non-aset';
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${item.nama}</td>
                    <td><span class="badge ${badgeClass}">${item.kategori}</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-1" onclick="editJenis(${item.id}, '${item.nama}', '${item.kategori}')">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="hapusJenis(${item.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Batal edit
        document.getElementById('batalEditJenis').addEventListener('click', function () {
            resetForm('jenis');
        });

        // ===== TIPE SPAREPART =====

        // Form submission
        document.getElementById('formTipe').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('tipeId').value;
            const namaTipe = document.getElementById('namaTipe').value;
            const kategoriTipe = document.getElementById('kategoriTipe').value;

            if (namaTipe.trim() === '') {
                alert('Nama tipe sparepart tidak boleh kosong!');
                return;
            }
            if (kategoriTipe === '') {
                alert('Kategori harus dipilih!');
                return;
            }

            if (id) {
                // Edit existing
                const index = tipeData.findIndex(item => item.id == id);
                if (index !== -1) {
                    tipeData[index].nama = namaTipe;
                    tipeData[index].kategori = kategoriTipe;
                    alert('Data tipe sparepart berhasil diupdate!');
                }
            } else {
                // Add new
                const newId = tipeData.length > 0 ? Math.max(...tipeData.map(item => item.id)) + 1 : 1;
                tipeData.push({ id: newId, nama: namaTipe, kategori: kategoriTipe });
                alert(`Data tipe sparepart "${namaTipe}" berhasil disimpan!`);
            }

            renderTipeTable();
            this.reset();
            resetForm('tipe');
        });

        // Edit tipe
        function editTipe(id, nama, kategori) {
            document.getElementById('tipeId').value = id;
            document.getElementById('namaTipe').value = nama;
            document.getElementById('kategoriTipe').value = kategori;
            document.getElementById('namaTipe').focus();
            toggleEditMode('tipe', true);
        }

        // Hapus tipe
        function hapusTipe(id) {
            currentDeleteId = id;
            currentDeleteType = 'tipe';
            document.getElementById('confirmDelete').onclick = confirmDeleteTipe;
            confirmDeleteModal.show();
        }

        function confirmDeleteTipe() {
            tipeData = tipeData.filter(item => item.id != currentDeleteId);
            renderTipeTable();
            confirmDeleteModal.hide();
            alert('Data berhasil dihapus!');
        }

        // Render table
        function renderTipeTable() {
            const tableBody = document.getElementById('tableTipeBody');
            tableBody.innerHTML = '';

            tipeData.forEach((item, index) => {
                const badgeClass = item.kategori === 'Aset' ? 'badge-aset' : 'badge-non-aset';
                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${index + 1}</td>
            <td>${item.nama}</td>
            <td><span class="badge ${badgeClass}">${item.kategori}</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary me-1" onclick="editTipe(${item.id}, '${item.nama}', '${item.kategori}')">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="hapusTipe(${item.id})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
                tableBody.appendChild(row);
            });
        }

        // Batal edit
        document.getElementById('batalEditTipe').addEventListener('click', function () {
            resetForm('tipe');
        });


        // ===== VENDOR =====
        document.getElementById('formVendor').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('vendorId').value;
            const namaVendor = document.getElementById('namaVendor').value;

            if (namaVendor.trim() === '') {
                alert('Nama vendor tidak boleh kosong!');
                return;
            }

            if (id) {
                // Edit existing
                const index = vendorData.findIndex(item => item.id == id);
                if (index !== -1) {
                    vendorData[index].nama = namaVendor;
                    alert('Data vendor berhasil diupdate!');
                }
            } else {
                // Add new
                const newId = vendorData.length > 0 ? Math.max(...vendorData.map(item => item.id)) + 1 : 1;
                vendorData.push({ id: newId, nama: namaVendor });
                alert('Data vendor "' + namaVendor + '" berhasil disimpan!');
            }

            renderVendorTable();
            this.reset();
            resetForm('vendor');
        });

        function editVendor(id, nama) {
            document.getElementById('vendorId').value = id;
            document.getElementById('namaVendor').value = nama;
            document.getElementById('namaVendor').focus();
            toggleEditMode('vendor', true);
        }

        function hapusVendor(id) {
            currentDeleteId = id;
            currentDeleteType = 'vendor';
            document.getElementById('confirmDelete').onclick = confirmDeleteVendor;
            confirmDeleteModal.show();
        }

        function confirmDeleteVendor() {
            vendorData = vendorData.filter(item => item.id != currentDeleteId);
            renderVendorTable();
            confirmDeleteModal.hide();
            alert('Data berhasil dihapus!');
        }

        function renderVendorTable() {
            const tableBody = document.getElementById('tableVendorBody');
            tableBody.innerHTML = '';

            vendorData.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${item.nama}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-1" onclick="editVendor(${item.id}, '${item.nama}')">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="hapusVendor(${item.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        document.getElementById('batalEditVendor').addEventListener('click', function () {
            resetForm('vendor');
        });

        // Tab functionality
        const triggerTabList = document.querySelectorAll('#sparepartTabs button');
        triggerTabList.forEach(triggerEl => {
            triggerEl.addEventListener('click', function () {
                // Reset forms when switching tabs
                resetForm('jenis');
                resetForm('tipe');
                resetForm('vendor');
            });
        });

        // Initial render
        renderJenisTable();
        renderTipeTable();
        renderVendorTable();
    </script>
</body>

</html>