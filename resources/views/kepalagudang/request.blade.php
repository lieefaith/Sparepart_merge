@extends('layouts.kepalagudang')

@section('title', 'Request Sparepart - Kepalagudang')

@push('styles')
@endpush

@section('content')
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
                    <input type="text" class="form-control" id="searchFilter"
                        placeholder="Cari ID Request, Requester, atau Barang...">
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
                                <td>{{ \Illuminate\Support\Carbon::parse($req->tanggal_permintaan)->translatedFormat('d M Y') }}
                                </td>
                                <td><span class="badge bg-success">Disetujui</span></td>
                                <td class="action-buttons">
                                    <button class="btn btn-success btn-sm btn-terima" data-tiket="{{ $req->tiket }}"
                                        data-requester="{{ $req->user->name ?? 'User' }}"
                                        data-tanggal="{{ \Illuminate\Support\Carbon::parse($req->tanggal_permintaan)->translatedFormat('d M Y') }}">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada permintaan yang menunggu proses pengiriman.</td>
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

    <!-- Modal Request (dummy) -->
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
                        <button type="button" class="btn btn-outline-primary"><i class="bi bi-plus"></i> Tambah
                            Baris</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success">Kirim Request</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Terima & Kirim Barang -->
    <div class="modal fade" id="modalTerima" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-box-seam"></i> Terima & Kirim Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Data Request (readonly) -->
                    <h6 class="fw-bold text-primary mb-3"><i class="bi bi-cart-check"></i> Data Request (readonly)</h6>
                    <div class="mb-3">
                        <p><strong>No Tiket:</strong> <span id="modal-tiket-display">-</span></p>
                        <p><strong>Requester:</strong> <span id="modal-requester">-</span></p>
                        <p><strong>Tanggal Request:</strong> <span id="modal-tanggal">-</span></p>
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

                    <!-- Form Pengiriman -->
                    <h6 class="fw-bold text-success mb-3"><i class="bi bi-truck"></i> Form Pengiriman</h6>
                    <form id="formPengiriman">
                        @csrf
                        <input type="hidden" name="tiket" value="" id="tiketInput">

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
                                        <td>
                                            <select class="form-control">
                                                <option value="">Pilih Keterangan</option>
                                                <option value="Baru">Baru</option>
                                                <option value="Bekas">Bekas</option>
                                                <option value="Dipakai">Dipakai</option>
                                            </select>
                                        </td>
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
                            <textarea class="form-control" name="catatan" rows="3"
                                placeholder="Tambahkan catatan jika ada..."></textarea>
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
@endsection

@push('scripts')
    <script>
        // Toggle sidebar
        document.querySelector('.navbar-toggler')?.addEventListener('click', function () {
            document.querySelector('.sidebar')?.classList.toggle('show');
        });

        // Filter pencarian
        document.getElementById('searchFilter')?.addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // Tambah baris
        function tambahBaris() {
            const tbody = document.querySelector('#tabelBarang tbody');
            const nomorBaru = tbody.children.length + 1;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                    <td>${nomorBaru}</td>
                    <td><input type="text" class="form-control" placeholder="Nama Item" required></td>
                    <td><input type="text" class="form-control" placeholder="Merk"></td>
                    <td><input type="text" class="form-control" placeholder="Serial Number"></td>
                    <td><input type="text" class="form-control" placeholder="Tipe"></td>
                    <td><input type="number" class="form-control" value="1" min="1" required></td>
                    <td>
                        <select class="form-control">
                            <option value="">Pilih Keterangan</option>
                            <option value="Baru">Baru</option>
                            <option value="Bekas">Bekas</option>
                            <option value="Dipakai">Dipakai</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
            tbody.appendChild(tr);
        }

        // Hapus baris
        function hapusBaris(button) {
            const tr = button.closest('tr');
            const tbody = tr.parentElement;
            if (tbody.children.length > 1) {
                tr.remove();
                Array.from(tbody.children).forEach((row, i) => row.cells[0].textContent = i + 1);
            } else {
                alert('Minimal satu baris harus ada.');
            }
        }

        // Simpan daftar requests untuk akses global
        const allRequests = @json($requests);

        // ini yang di ganti dari kode // const req = allRequests.find(r => r.tiket === tiket);

        // Isi modal saat tombol "Terima" diklik
        document.querySelectorAll('.btn-terima').forEach(button => {
            button.addEventListener('click', function () {
                const tiket = this.dataset.tiket;
                const requester = this.dataset.requester;
                const tanggal = this.dataset.tanggal;

                // Isi header modal
                document.getElementById('tiketInput').value = tiket;
                document.getElementById('modal-tiket-display').textContent = tiket;
                document.getElementById('modal-requester').textContent = requester;
                document.getElementById('modal-tanggal').textContent = tanggal;

                // ✅ Reset isi tabel data request (bagian atas)
                const detailBody = document.getElementById('detail-request-body');
                detailBody.innerHTML = '<tr><td colspan="5" class="text-center">Memuat data...</td></tr>';

                // ✅ Ambil data request dari API (permintaan_detail)
                fetch(`/requestbarang/${tiket}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal ambil data request');
                        return response.json();
                    })
                    .then(data => {
                        detailBody.innerHTML = '';

                        if (data.details && data.details.length > 0) {
                            data.details.forEach((item, index) => {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                <td>${index + 1}</td>
                                <td>${item.nama || '-'}</td>
                                <td>${item.deskripsi || '-'}</td>
                                <td>${item.jumlah}</td>
                                <td>${item.keterangan || '-'}</td>
                            `;
                                detailBody.appendChild(tr);
                            });
                        } else {
                            const tr = document.createElement('tr');
                            tr.innerHTML = '<td colspan="5" class="text-center">Tidak ada item diminta.</td>';
                            detailBody.appendChild(tr);
                        }

                        // ✅ Baru buka modal setelah data siap
                        const modal = new bootstrap.Modal(document.getElementById('modalTerima'));
                        modal.show();
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        detailBody.innerHTML = '<td colspan="5" class="text-center text-danger">Gagal memuat data request.</td>';
                        alert('Gagal memuat detail request.');
                    });
            });
        });

        // Submit form pengiriman
        document.getElementById('formPengiriman').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const items = [];
            const rows = document.querySelectorAll('#tabelBarang tbody tr');

            let valid = true;
            rows.forEach(row => {
                const cells = row.cells;
                const nama = cells[1].querySelector('input').value.trim();
                const jumlah = cells[5].querySelector('input').value.trim();
                const keterangan = cells[6].querySelector('select').value; // Ambil dari select

                if (!nama || !jumlah) valid = false;

                items.push({
                    nama_item: nama,
                    deskripsi: cells[2].querySelector('input').value.trim(),
                    merk: cells[3].querySelector('input').value.trim(),
                    sn: cells[4].querySelector('input').value.trim(),
                    tipe: cells[4].querySelector('input').value.trim(),
                    jumlah: parseInt(jumlah),
                    keterangan: keterangan
                });
            });

            if (!valid) {
                alert('Semua nama item dan jumlah harus diisi.');
                return;
            }

            formData.append('items', JSON.stringify(items));

            fetch("{{ route('kepalagudang.pengiriman.store') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalTerima'));
                        modal.hide();
                        location.reload();
                    } else {
                        alert('Gagal: ' + data.message);
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Terjadi kesalahan teknis.');
                });
        });
    </script>
@endpush