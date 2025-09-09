<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .table th {
            background-color: #4e73df;
            color: white;
            vertical-align: middle;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #224abe 0%, #4e73df 100%);
        }

        .btn-back {
            background-color: #858796;
            border: none;
            color: white;
        }

        .btn-back:hover {
            background-color: #717384;
        }

        .ticket-row:hover {
            background-color: #f1f3f9;
            cursor: pointer;
        }

        .modal-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
        }

        .badge-status {
            font-size: 0.85rem;
            padding: 0.35rem 0.65rem;
            border-radius: 0.5rem;
        }

        .page-title {
            color: #2c3e50;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .loading-spinner {
            display: none;
            width: 3rem;
            height: 3rem;
            margin: 20px auto;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold page-title">Request Sparepart</h2>
            <a href="{{ route('home') }}" class="btn btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Home
            </a>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- History Request -->
        <div id="history-section">
            <div class="card p-4 mb-4">
                <h4 class="fw-bold mb-3"><i class="fas fa-history me-2"></i>History Request</h4>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="history-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tiket</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permintaans as $index => $p)
                                <tr class="ticket-row">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold text-primary">{{ $p->tiket }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal_permintaan)->translatedFormat('l, d F Y') }}
                                    </td>
                                    <td>{{ $p->status ?? '-' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="showDetail('{{ $p->tiket }}')">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada history request</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary" onclick="showForm()">
                        <i class="fas fa-plus-circle me-2"></i>Buat Request Baru
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Request -->
        <div id="form-section" class="card p-4 d-none">
            <h4 class="fw-bold mb-3"><i class="fas fa-file-alt me-2"></i>Form Request Barang</h4>
            <form id="request-form" action="{{ route('request.store') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th>No</th>
                                <th>Nama Item</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="request-table-body">
                            <tr>
                                <td>1</td>
                                <td><input type="text" class="form-control" name="items[0][nama]" required></td>
                                <td><input type="text" class="form-control" name="items[0][deskripsi]" required></td>
                                <td><input type="number" class="form-control" name="items[0][jumlah]" min="1"
                                        value="1" required></td>
                                <td><input type="text" class="form-control" name="items[0][keterangan]" required>
                                </td>
                                <td><button type="button" class="btn btn-sm btn-danger" disabled><i
                                            class="fas fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-primary" onclick="tambahRow()">
                        <i class="fas fa-plus me-2"></i>Tambah Baris
                    </button>
                    <div>
                        <button type="button" class="btn btn-secondary me-2" onclick="cancelForm()">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Request
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-primary" id="modal-spinner" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="modal-content" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nama Tiket:</strong> <span id="modal-ticket-name"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Tanggal:</strong> <span id="modal-ticket-date"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>User:</strong> <span id="modal-ticket-user"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Jumlah Item:</strong> <span id="modal-ticket-count"></span>
                            </div>
                        </div>
                        <h6 class="mt-4 mb-3">Daftar Barang:</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Item</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-items-list">
                                    <!-- Items will be inserted here -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let noRow = 1;
        let detailModal = null;

        const allTickets = {!! json_encode(
            $permintaans->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'name' => $p->tiket,
                        'date' => $p->tanggal_permintaan,
                        'status' => $p->status,
                        'author' => $p->user ? $p->user->name : '-',
                        'items' => $p->details->map(function ($d) {
                                return [
                                    'nama' => $d->nama_item,
                                    'desc' => $d->deskripsi ?? '-',
                                    'qty' => $d->jumlah,
                                    'note' => $d->keterangan ?? '-',
                                ];
                            })->toArray(),
                    ];
                })->toArray(),
        ) !!};

        document.addEventListener('DOMContentLoaded', function() {
            detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
        });

        function showForm() {
            document.getElementById('history-section').classList.add('d-none');
            document.getElementById('form-section').classList.remove('d-none');
        }

        function cancelForm() {
            document.getElementById('form-section').classList.add('d-none');
            document.getElementById('history-section').classList.remove('d-none');
            document.getElementById('request-form').reset();
            document.getElementById('request-table-body').innerHTML = `
        <tr>
          <td>1</td>
          <td><input type="text" class="form-control" name="items[0][nama]" required></td>
          <td><input type="text" class="form-control" name="items[0][deskripsi]" required></td>
          <td><input type="number" class="form-control" name="items[0][jumlah]" min="1" value="1" required></td>
          <td><input type="text" class="form-control" name="items[0][keterangan]" required></td>
          <td><button type="button" class="btn btn-sm btn-danger" disabled><i class="fas fa-trash"></i></button></td>
        </tr>`;
            noRow = 1;
        }

        function tambahRow() {
            noRow++;
            const tbody = document.getElementById('request-table-body');
            const row = document.createElement('tr');
            row.innerHTML =
                `
        <td>${noRow}</td>
        <td><input type="text" class="form-control" name="items[${noRow-1}][nama]" required></td>
        <td><input type="text" class="form-control" name="items[${noRow-1}][deskripsi]" required></td>
        <td><input type="number" class="form-control" name="items[${noRow-1}][jumlah]" min="1" value="1" required></td>
        <td><input type="text" class="form-control" name="items[${noRow-1}][keterangan]" required></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>`;
            tbody.appendChild(row);
        }

        function removeRow(btn) {
            const row = btn.closest('tr');
            row.remove();
            const rows = document.querySelectorAll('#request-table-body tr');
            rows.forEach((row, index) => {
                row.cells[0].textContent = index + 1;
            });
            noRow = rows.length;
        }

        function showDetail(tiket) {
            document.getElementById('modal-spinner').style.display = 'block';
            document.getElementById('modal-content').style.display = 'none';

            fetch(`/requestbarang/${tiket}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modal-ticket-name').textContent = data.tiket;
                    document.getElementById('modal-ticket-date').textContent = new Date(data.tanggal_permintaan)
                        .toLocaleDateString('id-ID', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                    document.getElementById('modal-ticket-user').textContent = data ? data.name : '-';
                    document.getElementById('modal-ticket-count').textContent = data.details.length;

                    // Isi daftar barang
                    const itemsList = document.getElementById('modal-items-list');
                    itemsList.innerHTML = '';

                    data.details.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
              <td>${index + 1}</td>
              <td>${item.nama}</td>
              <td>${item.deskripsi || '-'}</td>
              <td>${item.jumlah}</td>
              <td>${item.keterangan || '-'}</td>
            `;
                        itemsList.appendChild(row);
                    });

                    document.getElementById('modal-spinner').style.display = 'none';
                    document.getElementById('modal-content').style.display = 'block';

                    detailModal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat detail permintaan');
                });
        }
    </script>
</body>

</html>
