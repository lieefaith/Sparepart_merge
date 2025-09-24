@extends('layouts.user')

@section('title', 'History Barang')

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title mb-1"><i class="bi bi-clock-history me-2"></i> History Barang</h4>
            <p class="text-muted mb-0">Riwayat permintaan dan penerimaan barang Anda.</p>
        </div>
        <div class="badge bg-primary fs-6 p-2">
            <i class="bi bi-list-check me-1"></i> Total: {{ $requests->count() }} Request
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="dikirim">Dikirim</option>
                    <option value="diterima">Diterima</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date" class="form-control" id="dateFilter">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Pencarian</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="searchFilter" placeholder="Cari ID Request...">
                    <button class="btn btn-primary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Request List -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-blue-700 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">Nama Tiket</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $index => $req)
                            <tr class="ticket-row hover:bg-gray-50 cursor-pointer transition-colors">
                                <td class="px-4 py-3 text-sm text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-blue-600">{{ $req->tiket }}</td>
                                <td class="px-4 py-3 text-sm">
                                    {{ \Carbon\Carbon::parse($req->tanggal_permintaan)->translatedFormat('l, d F Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex items-center space-x-2">
                                        @if($req->status_penerimaan == 'diterima')
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Diterima</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Dikirim</span>
                                        @endif

                                        <button 
                                            type="button"
                                            onclick="showStatusDetailModal('{{ $req->tiket }}', 'user')"
                                            class="text-blue-600 hover:text-blue-800 focus:outline-none"
                                            title="Lihat detail progres approval">
                                            <i class="fas fa-eye text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <button class="btn btn-info btn-sm btn-detail" 
                                        data-tiket="{{ $req->tiket }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalDetail">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">
                                    <i class="fas fa-inbox fa-3x text-gray-400 block mb-3"></i>
                                    <p>Belum ada riwayat permintaan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="bi bi-clock-history"></i> Detail History Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Data Request (readonly) -->
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

                    <!-- Data Pengiriman (readonly) -->
                    <!-- Data Pengiriman (readonly) -->
<h6 class="fw-bold text-success mb-3"><i class="bi bi-truck"></i> Data Pengiriman</h6>
<div class="mb-3">
    <p><strong>Tanggal Pengiriman:</strong> <span id="modal-tanggal-pengiriman-display">-</span></p>
    <p><strong>No Resi:</strong> <span id="modal-resi-display">-</span></p>
    <p><strong>Lampiran:</strong> 
        <span id="modal-attachment-display">-</span>
    </p>
</div>


                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-success">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Item</th>
                                    <th>Merk</th>
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
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Approval Berjenjang -->
    <div x-data="{ showStatusDetail: false, status: {}, role: 'user' }"
         x-show="showStatusDetail"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         id="status-detail-modal">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-black bg-opacity-50 absolute inset-0" @click="showStatusDetail = false"></div>
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 z-10">
                <div class="modal-header bg-blue-600 text-white p-4 rounded-t-lg flex justify-between items-center">
                    <h5 class="text-lg font-semibold">Detail Progres Approval</h5>
                    <button @click="showStatusDetail = false" class="text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6">
                    <div class="space-y-4 text-sm">
                        <!-- Kepala RO -->
                        <template x-if="['user'].includes(role)">
                            <div class="flex justify-between items-center p-3 border border-gray-200 rounded">
                                <span class="font-medium">Kepala RO</span>
                                <span :class="{
                                    'bg-yellow-100 text-yellow-800': status.ro === 'pending',
                                    'bg-green-100 text-green-800': status.ro === 'approved',
                                    'bg-red-100 text-red-800': status.ro === 'rejected'
                                }" class="px-3 py-1 rounded-full text-xs font-medium">
                                    <template x-if="status.ro === 'pending'">Pending</template>
                                    <template x-if="status.ro === 'approved'">Disetujui</template>
                                    <template x-if="status.ro === 'rejected'">Ditolak</template>
                                </span>
                            </div>
                        </template>

                        <!-- Kepala Gudang -->
                        <template x-if="['user', 'kepala_ro'].includes(role)">
                            <div class="flex justify-between items-center p-3 border border-gray-200 rounded">
                                <span class="font-medium">Kepala Gudang</span>
                                <span :class="{
                                    'bg-yellow-100 text-yellow-800': status.gudang === 'pending',
                                    'bg-green-100 text-green-800': status.gudang === 'approved',
                                    'bg-red-100 text-red-800': status.gudang === 'rejected'
                                }" class="px-3 py-1 rounded-full text-xs font-medium">
                                    <template x-if="status.gudang === 'pending'">Pending</template>
                                    <template x-if="status.gudang === 'approved'">Disetujui</template>
                                    <template x-if="status.gudang === 'rejected'">Ditolak</template>
                                </span>
                            </div>
                        </template>

                        <!-- Admin -->
                        <template x-if="['user', 'kepala_ro', 'kepala_gudang'].includes(role)">
                            <div class="flex justify-between items-center p-3 border border-gray-200 rounded">
                                <span class="font-medium">Admin</span>
                                <span :class="{
                                    'bg-yellow-100 text-yellow-800': status.admin === 'pending',
                                    'bg-green-100 text-green-800': status.admin === 'approved',
                                    'bg-red-100 text-red-800': status.admin === 'rejected'
                                }" class="px-3 py-1 rounded-full text-xs font-medium">
                                    <template x-if="status.admin === 'pending'">Pending</template>
                                    <template x-if="status.admin === 'approved'">Disetujui</template>
                                    <template x-if="status.admin === 'rejected'">Ditolak</template>
                                </span>
                            </div>
                        </template>

                        <!-- Super Admin -->
                        <template x-if="['user', 'kepala_ro', 'kepala_gudang', 'admin'].includes(role)">
                            <div class="flex justify-between items-center p-3 border border-gray-200 rounded">
                                <span class="font-medium">Super Admin</span>
                                <span :class="{
                                    'bg-yellow-100 text-yellow-800': status.super_admin === 'pending',
                                    'bg-green-100 text-green-800': status.super_admin === 'approved',
                                    'bg-red-100 text-red-800': status.super_admin === 'rejected'
                                }" class="px-3 py-1 rounded-full text-xs font-medium">
                                    <template x-if="status.super_admin === 'pending'">Pending</template>
                                    <template x-if="status.super_admin === 'approved'">Disetujui</template>
                                    <template x-if="status.super_admin === 'rejected'">Ditolak</template>
                                </span>
                            </div>
                        </template>

                        <!-- Catatan Jika Ditolak -->
                        <div class="mt-4 text-sm" x-show="status.catatan">
                            <strong>Catatan:</strong>
                            <p x-text="status.catatan" class="text-gray-600 mt-1"></p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end">
                    <button @click="showStatusDetail = false" class="btn btn-secondary bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Buka modal detail
    document.querySelectorAll('.btn-detail').forEach(button => {
        button.addEventListener('click', function() {
            const tiket = this.dataset.tiket;

            // Reset modal
            document.getElementById('modal-tiket-display').textContent = '-';
            document.getElementById('modal-requester-display').textContent = '-';
            document.getElementById('modal-tanggal-request-display').textContent = '-';
            document.getElementById('modal-tanggal-pengiriman-display').textContent = '-';

            // Reset tabel
            document.getElementById('request-table-body').innerHTML = '<tr><td colspan="5" class="text-center">Memuat data...</td></tr>';
            document.getElementById('pengiriman-table-body').innerHTML = '<tr><td colspan="7" class="text-center">Memuat data...</td></tr>';

            // Fetch data
            fetch(`/requestbarang/${tiket}`)
                .then(response => response.json())
                .then(data => {
                    // Isi data request
                    document.getElementById('modal-tiket-display').textContent = data.tiket;
                    document.getElementById('modal-requester-display').textContent = data.name || 'User';
                    document.getElementById('modal-tanggal-request-display').textContent = new Date(data.tanggal_permintaan)
                        .toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });

                    // Isi tabel request
                    const requestTable = document.getElementById('request-table-body');
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
                    if (data.pengiriman) {
                        document.getElementById('modal-tanggal-pengiriman-display').textContent = new Date(data.pengiriman.tanggal_transaksi)
                            .toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });

                        const pengirimanTable = document.getElementById('pengiriman-table-body');
                        pengirimanTable.innerHTML = '';
                        data.pengiriman.details.forEach((item, index) => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${index + 1}</td>
                                <td>${item.nama}</td>
                                <td>${item.merk || '-'}</td>
                                <td>${item.sn || '-'}</td>
                                <td>${item.tipe || '-'}</td>
                                <td>${item.jumlah}</td>
                                <td>${item.keterangan || '-'}</td>
                            `;
                            pengirimanTable.appendChild(tr);
                        });
                    } else {
                        document.getElementById('pengiriman-table-body').innerHTML = '<tr><td colspan="7" class="text-center">Belum ada data pengiriman.</td></tr>';
                    }

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

    // Filter pencarian
    document.getElementById('searchFilter')?.addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Detail status approval
    window.showStatusDetailModal = function(tiket, userRole) {
        fetch(`/requestbarang/api/permintaan/${tiket}/status`)
            .then(response => response.json())
            .then(data => {
                const modal = document.getElementById('status-detail-modal');
                if (modal && modal.__x) {
                    modal.__x.$data.status = data;
                    modal.__x.$data.role = userRole;
                    modal.__x.$data.showStatusDetail = true;
                }
            })
            .catch(err => {
                alert('Gagal muat detail status approval.');
            });
    };
});
</script>
@endpush