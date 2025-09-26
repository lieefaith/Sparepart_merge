@extends('layouts.kepalagudang')

@section('title', 'Closed Form - Validasi User')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <h1 class="page-title">
                <i class="bi bi-file-earmark-check me-2 text-primary"></i>
                Closed Form (Validasi User)
            </h1>
            <p class="page-subtitle">Klik "Closed" untuk memverifikasi detail permintaan</p>
        </div>

        <div class="table-container">
            <h5><i class="bi bi-list-ul me-2"></i> Daftar Permintaan Tervalidasi</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nomor Tiket</th>
                            <th>Requester</th>
                            <th>Tanggal Validasi</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permintaans as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="text-primary fw-bold">{{ $p->tiket }}</span></td>
                                <td>User {{ $p->user->region ?? 'Umum' }} {{ $p->user->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_penerimaan)->translatedFormat('j F Y') }}</td>
                                <td>
                                    <!-- 🔘 Tombol "Closed" di kolom Aksi -->
                                    <button class="btn btn-sm btn-success" onclick="showClosedDetail('{{ $p->tiket }}')">
                                        <i class="bi bi-check-circle me-1"></i> Closed
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detail Closed Form -->
    <div class="modal fade" id="modalClosedDetail" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-clipboard-check"></i> Verifikasi Closed Form</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Data Request -->
                    <h6 class="fw-bold text-primary mb-3"><i class="bi bi-cart-check"></i> Data Request</h6>
                    <div class="mb-3">
                        <p><strong>No Tiket:</strong> <span id="modal-tiket-display">-</span></p>
                        <p><strong>Requester:</strong> <span id="modal-requester-display">-</span></p>
                        <p><strong>Tanggal Request:</strong> <span id="modal-tanggal-request-display">-</span></p>
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
                            <tbody id="request-table-body">
                                <tr>
                                    <td colspan="5" class="text-center">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <!-- Data Pengiriman -->
                    <h6 class="fw-bold text-success mb-3"><i class="bi bi-truck"></i> Data Pengiriman</h6>
                    <div class="mb-3">
                        <p><strong>Tanggal Pengiriman:</strong> <span id="modal-tanggal-pengiriman-display">-</span></p>
                        <p><strong>Ekspedisi:</strong> <span id="modal-ekspedisi-display">-</span></p>
                        <p><strong>Nomor Resi:</strong> <span id="modal-resi-display">-</span></p>
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
                            <tbody id="pengiriman-table-body">
                                <tr>
                                    <td colspan="7" class="text-center">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <!-- 🔸 Bagian Bukti Penerimaan -->
                    <h6 class="fw-bold text-info mb-3"><i class="bi bi-image"></i> Bukti Penerimaan</h6>
                    <div class="card">
                        <div class="card-body text-center">
                            <div id="bukti-preview" class="d-flex justify-content-center align-items-center"
                                style="min-height: 150px;">
                                <div class="text-muted">Memuat bukti...</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <!-- 🔘 Tombol "Closed" di dalam modal -->
                    <button type="button" class="btn btn-success" id="btnClosedFinal">
                        <i class="bi bi-check-circle me-1"></i> Closed
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showClosedDetail(tiket) {
                const modal = new bootstrap.Modal(document.getElementById('modalClosedDetail'));
                modal.show();

                // Reset data
                document.getElementById('modal-tiket-display').textContent = '-';
                document.getElementById('modal-requester-display').textContent = '-';
                document.getElementById('modal-tanggal-request-display').textContent = '-';
                document.getElementById('modal-tanggal-pengiriman-display').textContent = '-';
                document.getElementById('modal-ekspedisi-display').textContent = '-';
                document.getElementById('modal-resi-display').textContent = '-';
                document.getElementById('request-table-body').innerHTML = '<tr><td colspan="5" class="text-center">Memuat...</td></tr>';
                document.getElementById('pengiriman-table-body').innerHTML = '<tr><td colspan="7" class="text-center">Memuat...</td></tr>';

                // Simulasi load data (nanti ganti dengan API)
                setTimeout(() => {
                    // Dummy data sesuai tiket
                    const requester = 'User CLG ' + Math.floor(Math.random() * 50) + 1;
                    document.getElementById('modal-tiket-display').textContent = tiket;
                    document.getElementById('modal-requester-display').textContent = requester;
                    document.getElementById('modal-tanggal-request-display').textContent = '10 September 2025';
                    document.getElementById('modal-tanggal-pengiriman-display').textContent = '12 September 2025';
                    document.getElementById('modal-ekspedisi-display').textContent = 'JNE';
                    document.getElementById('modal-resi-display').textContent = 'RESI-' + Math.floor(Math.random() * 900000 + 100000);

                    // Request items
                    const reqBody = document.getElementById('request-table-body');
                    reqBody.innerHTML = `
                    <tr>
                        <td>1</td>
                        <td>Laptop Dell</td>
                        <td>Core i5, 8GB RAM</td>
                        <td>2</td>
                        <td>Baru</td>
                    </tr>
                `;

                    // Pengiriman items
                    const pengBody = document.getElementById('pengiriman-table-body');
                    pengBody.innerHTML = `
                    <tr>
                        <td>1</td>
                        <td>Laptop Dell</td>
                        <td>Dell</td>
                        <td>SN123456</td>
                        <td>Latitude</td>
                        <td>2</td>
                        <td>Dikirim sesuai</td>
                    </tr>
                `;
                }, 300);
            }

            // Aksi tombol "Closed" di modal
            document.getElementById('btnClosedFinal').addEventListener('click', function () {
                if (!confirm('Apakah Anda yakin ingin menutup form ini?')) return;

                alert('Form berhasil ditutup!');
                // Nanti ganti dengan fetch ke API
                location.reload();
            });
        </script>
    @endpush
@endsection