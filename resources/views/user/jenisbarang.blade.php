<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis Barang - Aplikasi Sparepart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        .btn-back {
            background-color: #858796;
            border: none;
            color: white;
        }

        .btn-back:hover {
            background-color: #717384;
            color: white;
        }

        .table th {
            background-color: #4e73df;
            color: white;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }

        .page-title {
            color: #2c3e50;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        /* Improved Pagination Styles */
        .pagination {
            margin-bottom: 0;
        }

        .page-item {
            margin: 0 4px;
        }

        .page-link {
            border-radius: 6px;
            border: 1px solid #d1d3e2;
            color: #4e73df;
            font-weight: 500;
            padding: 0.5rem 0.9rem;
            transition: all 0.2s ease;
        }

        .page-link:hover {
            background-color: #eaecf4;
            border-color: #c2c9dd;
            color: #224abe;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border-color: #4e73df;
            color: white;
        }

        .page-item.disabled .page-link {
            color: #b7b9cc;
            background-color: #f8f9fc;
            border-color: #d1d3e2;
        }
    </style>
</head>

<body>
    <!-- Main Content -->
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold page-title">
                Daftar Jenis Sparepart
            </h2>
            <a href="{{ route('home') }}" class="btn btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Home
            </a>
        </div>

        <!-- Table -->
        <div class="card p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Nama Item</th>
                            <th style="width: 25%">Deskripsi (Type)</th>
                            <th style="width: 20%">Kategori</th>
                            <th style="width: 30%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>SFP</td>
                            <td>1G-850nm-300m</td>
                            <td>Transceiver</td>
                            <td>IN - Tri (01-Jan-24)</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>SFP</td>
                            <td>1G-1310nm-10km</td>
                            <td>Transceiver</td>
                            <td>IN - Tri (01-Jan-24)</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Kabel LAN</td>
                            <td>Belden Cat 6 - Biru</td>
                            <td>Kabel</td>
                            <td>IN - Joko (05-Jan-24)</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Router</td>
                            <td>MikroTik CCR1009</td>
                            <td>Networking</td>
                            <td>IN - Andi (10-Jan-24)</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Switch</td>
                            <td>Cisco Catalyst 2960</td>
                            <td>Networking</td>
                            <td>IN - Rina (15-Jan-24)</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Improved Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                            <i class="fas fa-chevron-left me-1"></i> Previous
                        </a>
                    </li>
                    <li class="page-item active" aria-current="page">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            Next <i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>