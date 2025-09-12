@extends('layouts.kepalagudang') @section('title', 'Request Barang - Kepala Gudang')

@push('styles')

@endpush

@section('content')

<h4 class="page-title"><i class="bi bi-cart-check me-2"></i> Daftar Request Barang</h4>
        <p class="page-subtitle">Kelola permintaan barang yang sudah di-approve Superadmin</p>

<!-- Filter Section -->
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

<!-- Table -->
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
                            <a href="#" class="btn btn-sm btn-info"><i class="bi bi-eye"></i> Detail</a>
                            <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-in-down"></i> Terima</a>
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
                            <a href="#" class="btn btn-sm btn-info"><i class="bi bi-eye"></i> Detail</a>
                            <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-in-down"></i> Terima</a>
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
                            <a href="#" class="btn btn-sm btn-info"><i class="bi bi-eye"></i> Detail</a>
                            <a href="#" class="btn btn-sm btn-secondary disabled"><i class="bi bi-clock"></i> Proses</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>

@endsection

@push('scripts')
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
@endpush