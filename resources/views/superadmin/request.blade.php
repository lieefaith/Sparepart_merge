@extends('layouts.superadmin')

@section('title', 'Request Barang - Superadmin')

@section('content')
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-0"><i class="bi bi-cart-check me-2"></i>Request Barang</h4>
                <p class="text-muted mb-0">Kelola permintaan barang yang sudah di-approve Kepala Gudang</p>
            </div>
            <a href="{{ route('superadmin.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label">Status</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="dateFilter" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="dateFilter">
                </div>
                <div class="col-md-4">
                    <label for="searchFilter" class="form-label">Pencarian</label>
                    <input type="text" class="form-control" id="searchFilter"
                        placeholder="Cari ID Request, Requester, atau Barang...">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Terapkan Filter</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID Request</th>
                            <th>Requester</th>
                            <th>Tanggal Request</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                            <tr>
                                <td><span class="fw-bold">{{ $req->tiket }}</span></td>
                                <td>{{ $req->user->name ?? 'User' }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($req->tanggal_permintaan)->translatedFormat('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $req->status_gudang == 'approved' ? 'success' : 'danger' }}">
                                        {{ $req->status_gudang == 'approved' ? 'Diterima' : 'Ditolak' }}
                                    </span>
                                </td>
                                <td class="action-buttons">
                                    <button class="btn btn-info btn-sm btn-detail" data-tiket="{{ $req->tiket }}"
                                        data-requester="{{ $req->user->name ?? 'User' }}"
                                        data-tanggal="{{ \Illuminate\Support\Carbon::parse($req->tanggal_permintaan)->translatedFormat('d M Y') }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada permintaan yang menunggu approval Superadmin.</td>
                            </tr>
                        @endforelse
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

    <!-- Modal Detail (Read-Only) -->
    <div class="modal fade" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="bi bi-eye"></i> Detail Request</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Data Request (readonly) -->
                    <h6 class="fw-bold text-primary mb-3"><i class="bi bi-cart-check"></i> Data Request</h6>
                    <div class="mb-3">
                        <p><strong>No Tiket:</strong> <span id="modal-tiket-display">-</span></p>
                        <p><strong>Requester:</strong> <span id="modal-requester-display">-</span></p>
                        <p><strong>Tanggal Request:</strong> <span id="modal-tanggal-display">-</span></p>
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
                            <tbody id="detail-request-body">
                                <!-- Akan diisi otomatis oleh JS -->
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <!-- Data Pengiriman (readonly) -->
                    <h6 class="fw-bold text-success mb-3"><i class="bi bi-truck"></i> Data Pengiriman</h6>
                    <div class="mb-3">
                        <p><strong>Tanggal Pengiriman:</strong> <span id="modal-tanggal-pengiriman-display">-</span></p>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-success">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Item</th>
                                    <th>Merk</th>
                                    <th>SN</th>
                                    <th>Tipe</th>
                                    <th>Jumlah Dikirim</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="detail-pengiriman-body">
                                <!-- Akan diisi otomatis oleh JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success btn-approve-modal" data-tiket="">
                        <i class="bi bi-check-circle"></i> Approve
                    </button>
                    <button class="btn btn-danger btn-reject-modal" data-tiket="">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Filter pencarian
    document.getElementById('searchFilter')?.addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Isi modal saat tombol "Detail" diklik
    document.querySelectorAll('.btn-detail').forEach(button => {
        button.addEventListener('click', function () {
            const tiket = this.dataset.tiket;
            const requester = this.dataset.requester;
            const tanggal = this.dataset.tanggal;

            // Isi header modal
            document.getElementById('modal-tiket-display').textContent = tiket;
            document.getElementById('modal-requester-display').textContent = requester;
            document.getElementById('modal-tanggal-display').textContent = tanggal;

            // Reset isi tabel
            document.getElementById('detail-request-body').innerHTML = '<tr><td colspan="5" class="text-center">Memuat data...</td></tr>';
            document.getElementById('detail-pengiriman-body').innerHTML = '<tr><td colspan="7" class="text-center">Memuat data...</td></tr>';

            // Ambil data dari API
            fetch(`/requestbarang/${tiket}`)
                .then(response => response.json())
                .then(data => {
                    // Isi data request
                    const requestTable = document.getElementById('detail-request-body');
                    requestTable.innerHTML = '';
                    data.details.forEach((item, index) => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${item.nama}</td>
                            <td>${item.deskripsi || '-'}</td>
                            <td>${item.jumlah}</td>
                            <td>${item.keterangan || '-'}</td>
                        `;
                        requestTable.appendChild(tr);
                    });

                    // Isi data pengiriman
                    if (data.pengiriman && data.pengiriman.details) {
                        const pengirimanTable = document.getElementById('detail-pengiriman-body');
                        pengirimanTable.innerHTML = '';
                        data.pengiriman.details.forEach((item, index) => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${index + 1}</td>
                                <td>${item.nama_item}</td>
                                <td>${item.merk || '-'}</td>
                                <td>${item.sn || '-'}</td>
                                <td>${item.tipe || '-'}</td>
                                <td>${item.jumlah}</td>
                                <td>${item.keterangan || '-'}</td>
                            `;
                            pengirimanTable.appendChild(tr);
                        });
                    } else {
                        document.getElementById('detail-pengiriman-body').innerHTML = '<tr><td colspan="7" class="text-center">Belum ada data pengiriman.</td></tr>';
                    }

                    // Set data-tiket untuk tombol approve/tolak
                    document.querySelector('.btn-approve-modal').dataset.tiket = tiket;
                    document.querySelector('.btn-reject-modal').dataset.tiket = tiket;

                    // Buka modal
                    const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
                    modal.show();
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Gagal memuat detail request.');
                });
        });
    });

    // Approve request
    document.querySelector('.btn-approve-modal').addEventListener('click', function () {
        const tiket = this.dataset.tiket;

        if (confirm('Apakah Anda yakin ingin menyetujui request ini?')) {
            fetch(`/superadmin/request/${tiket}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Request berhasil disetujui!');
                    location.reload();
                } else {
                    alert('Gagal menyetujui request: ' + data.message);
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Terjadi kesalahan teknis.');
            });
        }
    });

    // Reject request
    document.querySelector('.btn-reject-modal').addEventListener('click', function () {
        const tiket = this.dataset.tiket;
        const reason = prompt('Masukkan alasan penolakan:');

        if (reason) {
            fetch(`/superadmin/request/${tiket}/reject`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ catatan: reason })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Request berhasil ditolak!');
                    location.reload();
                } else {
                    alert('Gagal menolak request: ' + data.message);
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Terjadi kesalahan teknis.');
            });
        }
    });
</script>
@endpush