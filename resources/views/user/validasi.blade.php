@extends('layouts.user')

@section('title', 'Validasi Penerimaan Barang')

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title mb-1"><i class="bi bi-cart-check me-2"></i> Validasi Penerimaan Barang</h4>
            <p class="text-muted mb-0">Konfirmasi penerimaan barang yang sudah dikirim ke Anda.</p>
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
                                        @if ($req->status_penerimaan == 'diterima')
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Diterima</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Dikirim</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($req->status_penerimaan != 'diterima')
                                        <button class="btn btn-success btn-sm btn-terima" data-tiket="{{ $req->tiket }}"
                                            data-bs-toggle="modal" data-bs-target="#modalTerima">
                                            <i class="bi bi-check-circle me-1"></i> Terima
                                        </button>
                                    @else
                                        <button class="btn btn-outline-success btn-sm" disabled>
                                            <i class="bi bi-check-circle me-1"></i> Sudah Diterima
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">
                                    <i class="fas fa-inbox fa-3x text-gray-400 block mb-3"></i>
                                    <p>Belum ada barang yang menunggu konfirmasi.</p>
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

    <!-- Modal Terima Barang -->
    <div class="modal fade" id="modalTerima" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-check-circle"></i> Konfirmasi Penerimaan Barang</h5>
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
                                <tr>
                                    <td colspan="5" class="text-center">Memuat data...</td>
                                </tr>
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
                            <tbody id="pengiriman-table-body">
                                <tr>
                                    <td colspan="7" class="text-center">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr>
                    <div class="row mt-3">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0"><i class="bi bi-paperclip"></i> Lampiran File</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Upload File Pendukung</label>
                                    <input type="file" class="form-control" name="file_upload" id="fileUpload">
                                    <div class="form-text mt-2">
                                        <small>Format: PDF, JPG, PNG, DOC, DOCX<br>Maksimal: 5MB</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Layout Kanan-Kiri untuk Opsi Ekspedisi dan Upload File -->
                    <div class="row mt-3">
                        <!-- Kolom Kiri: Opsi Ekspedisi -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0"><i class="bi bi-ticket-perforated"></i> Resi Pengiriman
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="col-12">
                                        <label class="form-label">Nomor Resi</label>
                                        <input type="text" class="form-control" name="no_resi"
                                            placeholder="Nomor tracking pengiriman">
                                    </div>
                                    <!-- Form tambahan jika memilih Ya -->
                                    <div id="formEkspedisi" class="mt-3" style="display: none;">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <label class="form-label">Nama Ekspedisi</label>
                                                <input type="text" class="form-control" name="nama_ekspedisi"
                                                    placeholder="JNE, TIKI, POS Indonesia">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Nomor Resi</label>
                                                <input type="text" class="form-control" name="no_resi"
                                                    placeholder="Nomor tracking pengiriman">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Upload File -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0"><i class="bi bi-paperclip"></i> Lampiran File</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Upload File Pendukung</label>
                                        <input type="file" class="form-control" name="file_upload" id="fileUpload">
                                        <div class="form-text mt-2">
                                            <small>Format: PDF, JPG, PNG, DOC, DOCX<br>Maksimal: 5MB</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="btnKonfirmasi">
                        <i class="bi bi-check-circle me-1"></i> Konfirmasi Penerimaan
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            document.addEventListener('DOMContentLoaded', function() {
                // ----- Helper -----
                const safeQuery = (sel, root = document) => root.querySelector(sel);
                const safeQueryAll = (sel, root = document) => Array.from(root.querySelectorAll(sel));
                const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                    'content') || '';

                const formatDateId = (iso) => {
                    try {
                        return new Date(iso).toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                    } catch (e) {
                        return iso ?? '-';
                    }
                };

                // ----- Ensure preview image exists (create if missing) -----
                const fileInput = safeQuery('#fileUpload') || safeQuery(
                    'input[type="file"][name="file_upload"]') || null;
                let previewImg = safeQuery('#previewFoto');
                if (!previewImg) {
                    if (fileInput && fileInput.parentElement) {
                        previewImg = document.createElement('img');
                        previewImg.id = 'previewFoto';
                        previewImg.alt = 'Preview';
                        previewImg.style.display = 'none';
                        previewImg.style.maxWidth = '200px';
                        previewImg.style.marginTop = '10px';
                        fileInput.parentElement.appendChild(previewImg);
                    }
                }

                if (fileInput) {
                    fileInput.addEventListener('change', function(e) {
                        const file = e.target.files && e.target.files[0];
                        if (!file) {
                            if (previewImg) {
                                previewImg.style.display = 'none';
                                previewImg.src = '';
                            }
                            return;
                        }
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            if (previewImg) {
                                previewImg.src = ev.target.result;
                                previewImg.style.display = 'block';
                            }
                        };
                        reader.readAsDataURL(file);
                    });
                }

                // ----- Ensure hidden input for tiket exists (create if missing) -----
                let inputTiket = safeQuery('#inputTiket');
                const modalTerima = safeQuery('#modalTerima');
                if (!inputTiket) {
                    inputTiket = document.createElement('input');
                    inputTiket.type = 'hidden';
                    inputTiket.id = 'inputTiket';
                    inputTiket.name = 'tiket';
                    if (modalTerima) {
                        // append to modal body if exists
                        const body = safeQuery('.modal-body', modalTerima) || modalTerima;
                        body.appendChild(inputTiket);
                    } else {
                        document.body.appendChild(inputTiket);
                    }
                }

                // Bootstrap modal instance helper (Bootstrap 5)
                const getBootstrapModal = (element) => {
                    if (!element) return null;
                    if (typeof bootstrap === 'undefined' || !bootstrap.Modal) return null;
                    return bootstrap.Modal.getOrCreateInstance(element);
                };

                const modalInstanceTerima = getBootstrapModal(modalTerima);

                // ----- Table body placeholders -----
                const requestTableBody = safeQuery('#request-table-body');
                const pengirimanTableBody = safeQuery('#pengiriman-table-body');

                // Ganti fungsi loadRequestDetailToModal Anda dengan ini
                async function loadRequestDetailToModal(tiket) {
                    if (!tiket) return;
                    // Reset UI
                    safeQuery('#modal-tiket-display') && (safeQuery('#modal-tiket-display').textContent =
                        '-');
                    safeQuery('#modal-requester-display') && (safeQuery('#modal-requester-display')
                        .textContent = '-');
                    safeQuery('#modal-tanggal-request-display') && (safeQuery(
                        '#modal-tanggal-request-display').textContent = '-');
                    safeQuery('#modal-tanggal-pengiriman-display') && (safeQuery(
                        '#modal-tanggal-pengiriman-display').textContent = '-');
                    if (inputTiket) inputTiket.value = tiket;
                    if (previewImg) {
                        previewImg.style.display = 'none';
                        previewImg.src = '';
                    }

                    if (requestTableBody) requestTableBody.innerHTML =
                        '<tr><td colspan="5" class="text-center">Memuat data...</td></tr>';
                    if (pengirimanTableBody) pengirimanTableBody.innerHTML =
                        '<tr><td colspan="7" class="text-center">Memuat data...</td></tr>';

                    try {
                        const url = `/user/validasi/${encodeURIComponent(tiket)}/api?_=${Date.now()}`;
                        const resp = await fetch(url, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            credentials: 'same-origin',
                            cache: 'no-store'
                        });

                        const rawText = await resp.clone().text();
                        // Jika bukan OK, tampilkan response untuk debugging
                        if (!resp.ok) {
                            console.error('Fetch error:', resp.status, rawText);
                            throw new Error(`Fetch gagal: ${resp.status}`);
                        }

                        let data;
                        try {
                            data = rawText ? JSON.parse(rawText) : {};
                        } catch (e) {
                            console.error('JSON parse error. Response text:', rawText);
                            throw e;
                        }

                        // Struktur: data.permintaan, data.pengiriman
                        const permintaan = data.permintaan || null;
                        const pengiriman = data.pengiriman || null;

                        // Isi dasar permintaan
                        if (permintaan) {
                            safeQuery('#modal-tiket-display') && (safeQuery('#modal-tiket-display')
                                .textContent = permintaan.tiket ?? tiket);
                            safeQuery('#modal-requester-display') && (safeQuery('#modal-requester-display')
                                .textContent = permintaan.user?.name ?? '-');
                            if (permintaan.tanggal_permintaan) {
                                safeQuery('#modal-tanggal-request-display') && (safeQuery(
                                    '#modal-tanggal-request-display').textContent = formatDateId(
                                    permintaan.tanggal_permintaan));
                            }

                            // Preview foto jika ada (contoh: path atau URL)
                            if (previewImg && permintaan.foto_bukti_penerimaan) {
                                let src = permintaan.foto_bukti_penerimaan;
                                // Jika stored path (mis. 'uploads/..'), coba prefix /storage/
                                if (!/^https?:\/\//i.test(src) && !src.startsWith('/')) {
                                    // sesuaikan prefix sesuai cara Anda menyajikan file (Storage::url, dsb.)
                                    // Jika Anda menggunakan public storage -> /storage/{path}
                                    src = '/storage/' + src;
                                }
                                previewImg.src = src;
                                previewImg.style.display = 'block';
                            }
                        } else {
                            safeQuery('#modal-tiket-display') && (safeQuery('#modal-tiket-display')
                                .textContent = tiket);
                        }

                        // Populate request details table (permintaan.details)
                        if (requestTableBody) {
                            requestTableBody.innerHTML = '';
                            const details = Array.isArray(permintaan?.details) ? permintaan.details : [];
                            if (details.length === 0) {
                                requestTableBody.innerHTML =
                                    '<tr><td colspan="5" class="text-center">Tidak ada item.</td></tr>';
                            } else {
                                details.forEach((item, idx) => {
                                    const tr = document.createElement('tr');
                                    // field names sesuai contoh JSON: nama_item, deskripsi, jumlah, keterangan
                                    tr.innerHTML = `
            <td>${idx + 1}</td>
            <td>${item.nama_item ?? item.nama ?? '-'}</td>
            <td>${item.deskripsi ?? '-'}</td>
            <td>${item.jumlah ?? '-'}</td>
            <td>${item.keterangan ?? '-'}</td>
          `;
                                    requestTableBody.appendChild(tr);
                                });
                            }
                        }

                        // Populate pengiriman
                        if (pengiriman) {
                            if (pengiriman.tanggal_transaksi) {
                                safeQuery('#modal-tanggal-pengiriman-display') && (safeQuery(
                                    '#modal-tanggal-pengiriman-display').textContent = formatDateId(
                                    pengiriman.tanggal_transaksi));
                            }
                            if (pengirimanTableBody) {
                                pengirimanTableBody.innerHTML = '';
                                const pDetails = Array.isArray(pengiriman.details) ? pengiriman.details :
                            [];
                                if (pDetails.length === 0) {
                                    pengirimanTableBody.innerHTML =
                                        '<tr><td colspan="7" class="text-center">Tidak ada item pengiriman.</td></tr>';
                                } else {
                                    pDetails.forEach((item, idx) => {
                                        const tr = document.createElement('tr');
                                        // field names sesuai contoh JSON: nama, merk, sn, tipe, jumlah, keterangan
                                        tr.innerHTML = `
              <td>${idx + 1}</td>
              <td>${item.nama ?? item.nama_item ?? '-'}</td>
              <td>${item.merk ?? '-'}</td>
              <td>${item.sn ?? '-'}</td>
              <td>${item.tipe ?? '-'}</td>
              <td>${item.jumlah ?? '-'}</td>
              <td>${item.keterangan ?? '-'}</td>
            `;
                                        pengirimanTableBody.appendChild(tr);
                                    });
                                }
                            }
                        } else {
                            if (pengirimanTableBody) pengirimanTableBody.innerHTML =
                                '<tr><td colspan="7" class="text-center">Belum ada data pengiriman.</td></tr>';
                        }

                    } catch (err) {
                        console.error('Error loadRequestDetailToModal:', err);
                        if (requestTableBody) requestTableBody.innerHTML =
                            '<tr><td colspan="5" class="text-center">Gagal memuat data.</td></tr>';
                        if (pengirimanTableBody) pengirimanTableBody.innerHTML =
                            '<tr><td colspan="7" class="text-center">Gagal memuat data.</td></tr>';
                        alert('Gagal memuat detail request. Lihat console untuk detail.');
                    }
                }
                // ----- Bind click on .btn-terima -----
                safeQueryAll('.btn-terima').forEach(button => {
                    button.addEventListener('click', function(ev) {
                        const tiket = this.dataset.tiket || this.getAttribute('data-tiket');
                        if (!tiket) return;
                        // load data then show modal
                        loadRequestDetailToModal(tiket).finally(() => {
                            // Show modal via Bootstrap if available, otherwise rely on data-bs-toggle
                            if (modalInstanceTerima) modalInstanceTerima.show();
                        });
                    });
                });

                // ----- Build and send confirmation (manual FormData) -----
                const btnKonfirmasi = safeQuery('#btnKonfirmasi');
                btnKonfirmasi && btnKonfirmasi.addEventListener('click', async function() {
                    // get tiket from hidden input OR modal display
                    const tiketVal = (inputTiket && inputTiket.value) || (safeQuery(
                            '#modal-tiket-display') && safeQuery('#modal-tiket-display')
                        .textContent) || '';
                    if (!tiketVal) {
                        alert('Tiket tidak ditemukan. Coba tutup dan buka kembali modal.');
                        return;
                    }

                    // Build FormData manually to avoid requiring a <form> in HTML
                    const fd = new FormData();
                    fd.append('tiket', tiketVal);

                    // Collect ekspedisi fields (if present)
                    const namaEkspedisiEl = safeQuery('input[name="nama_ekspedisi"]');
                    const noResiEls = safeQueryAll(
                    'input[name="no_resi"]'); // there may be duplicates -> prefer visible non-empty
                    const noResiEl = noResiEls.find(i => i.offsetParent !== null && i.value
                    .trim() !== '') || noResiEls[0] || null;

                    if (namaEkspedisiEl && namaEkspedisiEl.value.trim() !== '') fd.append(
                        'nama_ekspedisi', namaEkspedisiEl.value.trim());
                    if (noResiEl && noResiEl.value.trim() !== '') fd.append('no_resi', noResiEl
                        .value.trim());

                    // Attach file if present
                    const fileEls = safeQueryAll('input[type="file"]');
                    if (fileEls.length > 0) {
                        // take first file from first file input that has files
                        let attached = false;
                        for (const fEl of fileEls) {
                            if (fEl.files && fEl.files.length > 0) {
                                fd.append(fEl.name || 'file_upload', fEl.files[0]);
                                attached = true;
                                break;
                            }
                        }
                        if (!attached) {
                            // no files chosen -> fine (server may accept)
                        }
                    }

                    // Optionally include other inputs inside modal, e.g. textarea[name="keterangan"]
                    const otherInputs = safeQueryAll('#modalTerima [name]');
                    otherInputs.forEach(el => {
                        const name = el.name;
                        if (!name) return;
                        // skip file inputs (already handled) and tiket (already appended)
                        if (el.type === 'file') return;
                        if (name === 'tiket') return;
                        const val = (el.value !== undefined) ? el.value : '';
                        // avoid duplicating nama_ekspedisi/no_resi already appended
                        if (name === 'nama_ekspedisi' || name === 'no_resi') return;
                        fd.append(name, val);
                    });

                    // Send POST
                    const endpoint = `/user/validasi/${encodeURIComponent(tiketVal)}/terima`;
                    try {
                        const resp = await fetch(endpoint, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': getCsrfToken(),
                                // 'Accept': 'application/json' // optional
                            },
                            body: fd,
                        });

                        // Try parse JSON safely
                        const text = await resp.text();
                        let data;
                        try {
                            data = text ? JSON.parse(text) : {};
                        } catch (e) {
                            throw new Error('Response JSON invalid: ' + text);
                        }

                        if (resp.ok && data && data.success) {
                            alert(data.message || 'Penerimaan berhasil dikonfirmasi.');
                            // close modal if bootstrap present
                            if (modalInstanceTerima) modalInstanceTerima.hide();
                            // reload to update listing
                            window.location.reload();
                        } else {
                            const msg = data?.message || `Gagal: status ${resp.status}`;
                            alert(msg);
                        }
                    } catch (err) {
                        console.error('Error saat submit konfirmasi:', err);
                        alert(
                            'Terjadi kesalahan saat mengirim konfirmasi. Cek console untuk detail.');
                    }
                });

                // ----- Search filter (only on main listing table with class .table-hover) -----
                const searchInput = safeQuery('#searchFilter');
                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        const filter = this.value.trim().toLowerCase();
                        // choose the main listing table (table-hover)
                        const rows = document.querySelectorAll('.table.table-hover tbody tr');
                        rows.forEach(row => {
                            // don't hide rows inside modal tables (modals are not using .table-hover)
                            const text = row.textContent.toLowerCase();
                            row.style.display = filter === '' || text.includes(filter) ? '' :
                                'none';
                        });
                    });
                }

                // ----- Status detail modal (Alpine.js-aware, fallback if not present) -----
                window.showStatusDetailModal = async function(tiket, userRole = 'user') {
                    if (!tiket) return;
                    try {
                        const resp = await fetch(`/user/validasi/${encodeURIComponent(tiket)}/api`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
                        const data = await resp.json();

                        const modal = safeQuery('#status-detail-modal');
                        if (!modal) return;

                        const alpine = modal.__x;
                        if (alpine && alpine.$data) {
                            alpine.$data.status = data ?? {};
                            alpine.$data.role = userRole;
                            alpine.$data.showStatusDetail = true;
                        } else {
                            // Fallback: show modal container (basic)
                            // If using Bootstrap to show overlay modal, you might want to toggle a class here.
                            modal.style.display = 'block';
                            // try to populate a fallback textual area if present
                            const statusTextEl = safeQuery('#status-detail-fallback');
                            if (statusTextEl) statusTextEl.textContent = JSON.stringify(data, null, 2);
                            console.warn('Alpine.js tidak tersedia. Fallback simpel sudah diaktifkan.');
                        }
                    } catch (err) {
                        console.error('Gagal muat detail status approval:', err);
                        alert('Gagal memuat detail status approval. Cek console untuk detail.');
                    }
                };

                // ----- Optional: toggle formEkspedisi visibility if there is a control -----
                (function handleFormEkspedisiToggle() {
                    const formEkspedisi = safeQuery('#formEkspedisi');
                    if (!formEkspedisi) return;
                    // check for a checkbox/radio named show_ekspedisi OR element with id 'toggleEkspedisi'
                    const toggle = safeQuery('[name="show_ekspedisi"]') || safeQuery('#toggleEkspedisi');
                    if (!toggle) {
                        // If there is no toggle, but fields inside formEkspedisi have values, show it; otherwise hide.
                        const anyValue = safeQueryAll(
                                '#formEkspedisi input, #formEkspedisi select, #formEkspedisi textarea')
                            .some(i => i.value && i.value.trim() !== '');
                        formEkspedisi.style.display = anyValue ? 'block' : 'none';
                        return;
                    }

                    const apply = () => {
                        if (toggle.type === 'checkbox') {
                            formEkspedisi.style.display = toggle.checked ? 'block' : 'none';
                        } else {
                            // for select/radio where value 'yes' or '1' indicates show
                            const val = toggle.value;
                            formEkspedisi.style.display = (val === '1' || val.toLowerCase() === 'ya' ||
                                val.toLowerCase() === 'yes') ? 'block' : 'none';
                        }
                    };
                    toggle.addEventListener('change', apply);
                    apply();
                })();

                // End DOMContentLoaded
            });
        })();
    </script>
@endsection
