@extends('layouts.kepalagudang')

@section('title', 'Closed Form - Validasi User')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">
            <i class="bi bi-file-earmark-check me-2 text-primary"></i>
            Closed Form (Validasi User)
        </h1>
        <p class="page-subtitle">Klik pada tiket untuk melihat detail validasi user</p>
    </div>

    <div class="table-container">
        <h5><i class="bi bi-list-ul me-2"></i> Daftar Permintaan Tervalidasi</h5>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Tiket</th>
                        <th>Requester</th>
                        <th>Tanggal Validasi</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permintaans as $index => $p)
                        <tr style="cursor: pointer;" onclick="showValidasiDetail('{{ $p->tiket }}')">
                            <td>{{ $index + 1 }}</td>
                            <td><span class="text-primary fw-bold">{{ $p->tiket }}</span></td>
                            <td>User {{ $p->user->region }} {{ $p->user->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_penerimaan)->translatedFormat('j F Y') }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $p->foto_bukti_penerimaan) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary"
                                   onclick="event.stopPropagation()">
                                    <i class="bi bi-eye me-1"></i> Lihat
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i> Closed
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Validasi (Sama seperti di form user, tapi readonly) -->
<div class="modal fade" id="modalValidasiDetail" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="bi bi-clipboard-check"></i> Detail Validasi User</h5>
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
                            <tr><td colspan="5" class="text-center">Memuat data...</td></tr>
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
                            <tr><td colspan="7" class="text-center">Memuat data...</td></tr>
                        </tbody>
                    </table>
                </div>

                <hr>

                <!-- Lampiran File -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="card-title mb-0"><i class="bi bi-paperclip"></i> Lampiran Validasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Bukti Penerimaan</label>
                            <div id="file-preview-container">
                                <p class="text-muted">Memuat...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showValidasiDetail(tiket) {
    const modal = new bootstrap.Modal(document.getElementById('modalValidasiDetail'));
    modal.show();

    // Reset
    document.getElementById('modal-tiket-display').textContent = '-';
    document.getElementById('modal-requester-display').textContent = '-';
    document.getElementById('modal-tanggal-request-display').textContent = '-';
    document.getElementById('modal-tanggal-pengiriman-display').textContent = '-';
    document.getElementById('modal-ekspedisi-display').textContent = '-';
    document.getElementById('modal-resi-display').textContent = '-';
    document.getElementById('request-table-body').innerHTML = '<tr><td colspan="5" class="text-center">Memuat...</td></tr>';
    document.getElementById('pengiriman-table-body').innerHTML = '<tr><td colspan="7" class="text-center">Memuat...</td></tr>';
    document.getElementById('file-preview-container').innerHTML = '<p class="text-muted">Memuat...</p>';

    // Fetch data
    fetch(`/kepalagudang/closed-form/${tiket}/detail`)
        .then(res => res.json())
        .then(data => {
            // Request info
            document.getElementById('modal-tiket-display').textContent = data.tiket;
            document.getElementById('modal-requester-display').textContent = data.name;
            document.getElementById('modal-tanggal-request-display').textContent = 
                new Date(data.tanggal_permintaan).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });

            // Request details
            const reqBody = document.getElementById('request-table-body');
            reqBody.innerHTML = '';
            data.details.forEach((item, i) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${i+1}</td>
                    <td>${item.nama}</td>
                    <td>${item.deskripsi}</td>
                    <td>${item.jumlah}</td>
                    <td>${item.keterangan}</td>
                `;
                reqBody.appendChild(tr);
            });

            // Pengiriman info
            if (data.pengiriman) {
                document.getElementById('modal-tanggal-pengiriman-display').textContent = 
                    new Date(data.pengiriman.tanggal_transaksi).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
                document.getElementById('modal-ekspedisi-display').textContent = data.nama_ekspedisi || '-';
                document.getElementById('modal-resi-display').textContent = data.no_resi || '-';
                
                const pengBody = document.getElementById('pengiriman-table-body');
                pengBody.innerHTML = '';
                data.pengiriman.details.forEach((item, i) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${i+1}</td>
                        <td>${item.nama}</td>
                        <td>${item.merk || '-'}</td>
                        <td>${item.sn || '-'}</td>
                        <td>${item.tipe || '-'}</td>
                        <td>${item.jumlah}</td>
                        <td>${item.keterangan}</td>
                    `;
                    pengBody.appendChild(tr);
                });
            }

            // File preview
            const fileContainer = document.getElementById('file-preview-container');
            if (data.foto_bukti_penerimaan) {
                const url = `/storage/${data.foto_bukti_penerimaan}`;
                const ext = url.split('.').pop().toLowerCase();
                if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                    fileContainer.innerHTML = `<img src="${url}" class="img-fluid border rounded" style="max-height: 300px;">`;
                } else {
                    fileContainer.innerHTML = `<a href="${url}" target="_blank" class="btn btn-primary">Download File</a>`;
                }
            } else {
                fileContainer.innerHTML = '<p class="text-muted">Tidak ada lampiran.</p>';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Gagal memuat detail validasi.');
        });
}
</script>
@endpush
@endsection