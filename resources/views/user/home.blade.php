<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Aplikasi Sparepart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .container {
            max-width: 800px;
        }
        
        .welcome-text {
            color: #2c3e50;
        }
        
        .subtitle {
            color: #6c757d;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }
        
        .card-jenis {
            border-top: 4px solid #4e73df;
        }
        
        .card-request {
            border-top: 4px solid #1cc88a;
        }
        
        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        .icon-jenis {
            color: #4e73df;
        }
        
        .icon-request {
            color: #1cc88a;
        }
        
        .btn-jenis {
            background-color: #4e73df;
            border-color: #4e73df;
            color: white;
        }
        
        .btn-jenis:hover {
            background-color: #3a56c4;
            border-color: #3a56c4;
            color: white;
        }
        
        .btn-request {
            background-color: #1cc88a;
            border-color: #1cc88a;
            color: white;
        }
        
        .btn-request:hover {
            background-color: #17a673;
            border-color: #17a673;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold welcome-text">Selamat Datang di Aplikasi Sparepart</h1>
            <p class="subtitle">Lihat daftar sparepart & ajukan request barang dengan mudah.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-5 mb-4">
                <div class="card p-4 text-center h-100 card-jenis">
                    <div class="card-icon icon-jenis">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h4 class="fw-bold">Jenis Barang</h4>
                    <p class="text-muted">Lihat daftar sparepart yang tersedia</p>
                    <a href="{{ route('jenis.barang') }}" class="btn btn-jenis mt-2">Lihat</a>
                </div>
            </div>
            <div class="col-md-5 mb-4">
                <div class="card p-4 text-center h-100 card-request">
                    <div class="card-icon icon-request">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4 class="fw-bold">Request Barang</h4>
                    <p class="text-muted">Ajukan permintaan sparepart baru</p>
                    <a href="{{ route('request.barang') }}" class="btn btn-request mt-2">Request</a>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <p class="text-muted">© 2023 Aplikasi Sparepart</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>