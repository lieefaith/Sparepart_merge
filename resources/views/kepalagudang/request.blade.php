@extends('layouts.kepalagudang')

@section('title', 'Request Sparepart - Kepalagudang')

@push('styles')
    <style>
        .table-success th {
            text-align: center;
            font-weight: 600;
        }

        .table tbody td {
            vertical-align: middle;
        }

        /* Kolom No & Aksi: kecil */
        .no-col,
        .aksi-col {
            width: 50px;
            min-width: 50px;
        }

        /* Kolom Nama, Tipe, Keterangan: lebih besar */
        .nama-col,
        .tipe-col,
        .keterangan-col {
            width: 150px;
            min-width: 150px;
        }
    </style>
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
                                <input type="date" class="form-control" name="tanggal_pengiriman" id="tanggal_pengiriman"
                                    required>
                            </div>
                        </div>
                        <div class="mt-3 table-responsive">
                            <table class="table table-bordered" id="tabelBarang">
                                <thead class="table-success">
                                    <tr>
                                        <th class="no-col">No</th>
                                        <th class="kategori-col">Kategori</th>
                                        <th class="nama-col">Nama</th>
                                        <th class="tipe-col">Tipe</th>
                                        <th class="merk-col">Merk</th>
                                        <th class="sn-col">Nomor Serial</th>
                                        <th class="jumlah-col">Jumlah</th>
                                        <th class="keterangan-col">Keterangan</th>
                                        <th class="aksi-col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="no-col">1</td>
                                        <td class="kategori-col">
                                            <select class="form-control kategori-select" name="kategori">
                                                <option value="">Kategori</option>
                                                <option value="aset">Aset</option>
                                                <option value="non-aset">Non-Aset</option>
                                            </select>
                                        </td>
                                        <!-- Sesudah: tambah class untuk akses JS -->
                                        <td class="nama-col">
                                            <select class="form-control nama-item-select" name="nama_item">
                                                <option value="">Pilih Nama</option>
                                            </select>
                                        </td>
                                        <td class="tipe-col">
                                            <select class="form-control tipe-select" name="tipe">
                                                <option value="">Pilih Tipe</option>
                                            </select>
                                        </td>
                                        <td class="merk-col"><input type="text" class="form-control" placeholder="Merk">
                                        </td>
                                        <td class="sn-col"><input type="text" class="form-control"
                                                placeholder="Nomor Serial"></td>
                                        <td class="jumlah-col"><input type="number" class="form-control" value="1" min="1"
                                                required></td>
                                        <td class="keterangan-col">
                                            <input type="text" class="form-control" name="keterangan"
                                                placeholder="Keterangan">
                                        </td>
                                        <td class="aksi-col">
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
                    <!-- Tombol Batal -->
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                    <!-- Tombol Reject -->
                    <button type="button" class="btn btn-danger" onclick="rejectRequest()">
                        <i class="bi bi-x-circle"></i> Reject
                    </button>

                    <!-- Tombol Approve -->
                    <button type="button" class="btn btn-primary" onclick="approveRequest()">
                        <i class="bi bi-check-circle"></i> Approve
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

        // Fungsi: Muat daftar jenis barang berdasarkan kategori
        async function loadItemsByKategori(selectKategori, targetSelect) {
            const kategori = selectKategori.value;
            if (!kategori || !targetSelect) return;

            try {
                const response = await fetch(`/requestbarang/api/jenis-barang?kategori=${encodeURIComponent(kategori)}`);
                const items = await response.json();

                targetSelect.innerHTML = '<option value="">Pilih Nama</option>';
                items.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;           // ✅ Untuk filter tipe
                    option.textContent = item.nama;   // ✅ Yang ditampilkan
                    option.dataset.nama = item.nama;  // ✅ Simpan nama untuk pakai nanti
                    targetSelect.appendChild(option);
                });

                // Reset tipe setelah isi nama
                const row = targetSelect.closest('tr');
                const tipeSelect = row.querySelector('.tipe-select');
                if (tipeSelect) {
                    tipeSelect.innerHTML = '<option value="">Pilih Tipe</option>';
                }
            } catch (err) {
                console.error('Gagal muat jenis barang:', err);
                targetSelect.innerHTML = '<option value="">Gagal muat</option>';
            }
        }

        // Fungsi: Muat daftar tipe berdasarkan kategori + jenis_id
        async function loadTipeByKategoriAndJenis(selectKategori, selectJenis, targetSelect) {
            const kategori = selectKategori.value;
            const jenisId = selectJenis.value;

            if (!kategori || !jenisId || !targetSelect) {
                if (targetSelect) targetSelect.innerHTML = '<option value="">Pilih Tipe</option>';
                return;
            }

            try {
                const response = await fetch(
                    `/requestbarang/api/tipe-barang?kategori=${encodeURIComponent(kategori)}&jenis_id=${encodeURIComponent(jenisId)}`
                );
                const tipes = await response.json();

                targetSelect.innerHTML = '<option value="">Pilih Tipe</option>';
                tipes.forEach(tipe => {
                    const option = document.createElement('option');
                    option.value = tipe.nama;
                    option.textContent = tipe.nama;
                    targetSelect.appendChild(option);
                });
            } catch (err) {
                console.error('Gagal muat tipe:', err);
                targetSelect.innerHTML = '<option value="">Gagal muat</option>';
            }
        }

        // Cek Serial Number
        async function cekSerialNumber(sn) {
            try {
                const response = await fetch(`/requestbarang/api/cek-sn?sn=${encodeURIComponent(sn)}`);
                const data = await response.json();
                return data.exists;
            } catch (err) {
                console.error('Gagal cek serial number:', err);
                return false;
            }
        }

        // Tambah baris baru
        function tambahBaris() {
            const tbody = document.querySelector('#tabelBarang tbody');
            const nomorBaru = tbody.children.length + 1;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                            <td class="no-col">${nomorBaru}</td>
                            <td class="kategori-col">
                                <select class="form-control kategori-select" name="kategori">
                                    <option value="">Kategori</option>
                                    <option value="aset">Aset</option>
                                    <option value="non-aset">Non-Aset</option>
                                </select>
                            </td>
                            <td class="nama-col">
                                <select class="form-control nama-item-select" name="nama_item">
                                    <option value="">Pilih Nama</option>
                                </select>
                            </td>
                            <td class="tipe-col">
                                <select class="form-control tipe-select" name="tipe">
                                    <option value="">Pilih Tipe</option>
                                </select>
                            </td>
                            <td class="merk-col"><input type="text" class="form-control" placeholder="Merk"></td>
                            <td class="sn-col"><input type="text" class="form-control" placeholder="Nomor Serial"></td>
                            <td class="jumlah-col"><input type="number" class="form-control" value="1" min="1" required></td>
                            <td class="keterangan-col">
                                <input type="text" class="form-control" name="keterangan" placeholder="Keterangan">
                            </td>
                            <td class="aksi-col">
                                <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        `;
            tbody.appendChild(tr);

            const newKategori = tr.querySelector('.kategori-select');
            const newNama = tr.querySelector('.nama-item-select');
            const newTipe = tr.querySelector('.tipe-select');

            newKategori.addEventListener('change', () => {
                loadItemsByKategori(newKategori, newNama);
            });

            newNama.addEventListener('change', () => {
                loadTipeByKategoriAndJenis(newKategori, newNama, newTipe);
            });
        }

        // Hapus baris
        function hapusBaris(button) {
            const tr = button.closest('tr');
            const tbody = tr.parentElement;
            if (tbody.children.length > 1) {
                tr.remove();
                Array.from(tbody.children).forEach((row, i) => {
                    row.cells[0].textContent = i + 1;
                });
            } else {
                alert('Minimal satu baris harus ada.');
            }
        }

        // Simpan daftar requests
        const allRequests = @json($requests);

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

                // Isi detail request
                const req = allRequests.find(r => r.tiket === tiket);
                const detailBody = document.getElementById('detail-request-body');
                detailBody.innerHTML = '';

                if (req && req.details.length > 0) {
                    req.details.forEach((item, index) => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                                        <td>${index + 1}</td>
                                        <td>${item.nama_item || '-'}</td>
                                        <td>${item.deskripsi || '-'}</td>
                                        <td>${item.jumlah}</td>
                                        <td>${item.keterangan || '-'}</td>
                                    `;
                        detailBody.appendChild(tr);
                    });
                } else {
                    const tr = document.createElement('tr');
                    tr.innerHTML = '<td colspan="6" class="text-center">Tidak ada item.</td>';
                    detailBody.appendChild(tr);
                }

                // Buka modal
                const modal = new bootstrap.Modal(document.getElementById('modalTerima'));
                modal.show();

                // 🔥 DEBUG: Cek apakah fetch jalan
                console.log('🔧 Memulai /terima untuk tiket:', tiket);
                // Setelah modal muncul, pasang event listener
                setTimeout(() => {
                    const firstRow = document.querySelector('#tabelBarang tbody tr');
                    if (!firstRow) return;

                    const selectKategori = firstRow.querySelector('.kategori-select');
                    const selectNama = firstRow.querySelector('.nama-item-select');
                    const selectTipe = firstRow.querySelector('.tipe-select');

                    selectKategori.replaceWith(selectKategori.cloneNode(true));
                    selectNama.replaceWith(selectNama.cloneNode(true));
                    selectTipe.replaceWith(selectTipe.cloneNode(true));

                    const newKategori = firstRow.querySelector('.kategori-select');
                    const newNama = firstRow.querySelector('.nama-item-select');
                    const newTipe = firstRow.querySelector('.tipe-select');

                    newKategori.addEventListener('change', () => {
                        loadItemsByKategori(newKategori, newNama);
                    });

                    newNama.addEventListener('change', () => {
                        loadTipeByKategoriAndJenis(newKategori, newNama, newTipe);
                    });

                    if (newKategori.value) {
                        loadItemsByKategori(newKategori, newNama);
                    }
                }, 500);
            });
        });

        function getCsrfToken() {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!token) {
                console.error('CSRF token tidak ditemukan!');
                alert('Sistem bermasalah: token keamanan hilang. Silakan refresh halaman.');
            }
            return token;
        }

        // Approve Request
        function approveRequest() {
            const tiket = document.getElementById('tiketInput').value;
            if (!tiket) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                alert('CSRF token tidak ditemukan.');
                return;
            }
            // ✅ Ambil dengan getElementById (lebih spesifik)
            const tanggalInput = document.getElementById('tanggal_pengiriman');
            if (!tanggalInput || !tanggalInput.value) {
                alert('Tanggal Pengiriman wajib diisi.');
                return;
            }
            const tanggalPengiriman = tanggalInput.value;

            // Ambil catatan
            const catatan = document.querySelector('[name="catatan"]')?.value || '';

            // Ambil items
            const rows = document.querySelectorAll('#tabelBarang tbody tr');
            const items = [];
            let valid = true;

            for (const row of rows) {
                const cells = row.cells;
                const kategori = cells[1].querySelector('select')?.value;
                const nama = cells[2].querySelector('select')?.value;
                const tipe = cells[3].querySelector('select')?.value;
                const merk = cells[4].querySelector('input')?.value.trim();
                const sn = cells[5].querySelector('input')?.value.trim();
                const jumlah = cells[6].querySelector('input')?.value.trim();
                const keterangan = cells[7].querySelector('input')?.value.trim();

                if (!kategori || !nama || !jumlah) {
                    valid = false;
                    continue;
                }

                if (kategori === 'aset' && !sn) {
                    alert(`Serial Number wajib diisi untuk barang Aset di baris ${row.rowIndex}.`);
                    return;
                }


                items.push({
                    kategori,
                    nama_item: nama,
                    tipe,
                    merk,
                    sn,
                    jumlah: parseInt(jumlah),
                    keterangan
                });
            }

            if (!valid || items.length === 0) {
                alert('Isi minimal satu barang dengan lengkap.');
                return;
            }

            // 🔥 DEBUG: Cek data sebelum kirim
            console.log("📦 Mengirim data ke server:", {
                tiket,
                tanggal_pengiriman: tanggalPengiriman,
                catatan,
                items
            });

            // Kirim semua data
            fetch(`/kepalagudang/request/${tiket}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    tiket: tiket,
                    tanggal_pengiriman: tanggalPengiriman,
                    catatan: catatan,
                    items: items
                })
            })

                .then(response => {
                    if (!response.ok) throw new Error('Server error');
                    return response.json();
                })
                .then(data => {
                    const msg = data.message || 'Terjadi kesalahan. Cek log server.';
                    if (data.success) {
                        alert(msg);
                        location.reload();
                    } else {
                        alert('Gagal: ' + msg);
                    }
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    alert('Terjadi kesalahan teknis. Cek koneksi atau refresh halaman.');
                });
        }
        function rejectRequest() {
            const tiket = document.getElementById('tiketInput').value;
            if (!tiket) return;

            const catatan = prompt('Masukkan alasan penolakan (opsional):', '');

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                return;
            }

            fetch(`/kepalagudang/request/${tiket}/reject`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    tiket: tiket,
                    catatan: catatan
                })
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
        }
        
    </script>
@endpush