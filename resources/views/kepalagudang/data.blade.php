@extends('layouts.kepalagudang')

@push('styles')

@endpush

@section('content')
    <h4 class="page-title"><i class="bi bi-plus-circle me-2"></i> Tambah Data Sparepart</h4>
    <p class="page-subtitle">Kelola data jenis sparepart, tipe sparepart, dan vendor</p>
    <div class="card shadow-sm">
        <div class="card-body">
            <ul class="nav nav-tabs mb-4" id="sparepartTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="jenis-tab" data-bs-toggle="tab" data-bs-target="#jenis"
                        type="button" role="tab">
                        <i class="bi bi-grid me-1"></i> Jenis Sparepart
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tipe-tab" data-bs-toggle="tab" data-bs-target="#tipe" type="button"
                        role="tab">
                        <i class="bi bi-tag me-1"></i> Tipe Sparepart
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="vendor-tab" data-bs-toggle="tab" data-bs-target="#vendor"
                        type="button" role="tab">
                        <i class="bi bi-building me-1"></i> Vendor
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="sparepartTabsContent">
                <!-- Tab Jenis Sparepart -->
                <div class="tab-pane fade show active" id="jenis" role="tabpanel">
                    <div class="form-container">
                        <h5 class="mb-4 text-center"><i class="bi bi-grid me-2"></i>
                            <span class="add-mode">Tambah Jenis Sparepart</span>
                            <span class="edit-mode">Edit Jenis Sparepart</span>
                        </h5>
                        <form id="formJenis" class="simple-form">
                            <input type="hidden" id="jenisId">
                            <div class="mb-4">
                                <label for="namaJenis" class="form-label required-field">Nama Jenis
                                    Sparepart</label>
                                <input type="text" class="form-control form-control-lg" id="namaJenis"
                                    placeholder="Masukkan nama jenis sparepart" required>
                            </div>
                            <div class="mb-4">
                                <label for="kategoriJenis" class="form-label required-field">Kategori</label>
                                <select class="form-select form-select-lg" id="kategoriJenis" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Aset">Aset</option>
                                    <option value="Non Aset">Non Aset</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save me-1"></i> <span class="add-mode">Simpan</span><span
                                        class="edit-mode">Update</span> Jenis Sparepart
                                </button>
                                <button type="button" id="batalEditJenis"
                                    class="btn btn-secondary btn-lg edit-mode ms-2">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive mt-4">
                        <h5 class="mb-3"><i class="bi bi-list-ul me-2"></i> Daftar Jenis Sparepart</h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Jenis</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableJenisBody">
                                <!-- Will be populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Tipe Sparepart -->
                <div class="tab-pane fade" id="tipe" role="tabpanel">
                    <div class="form-container">
                        <h5 class="mb-4 text-center"><i class="bi bi-tag me-2"></i>
                            <span class="add-mode">Tambah Tipe Sparepart</span>
                            <span class="edit-mode">Edit Tipe Sparepart</span>
                        </h5>
                        <form id="formTipe" class="simple-form">
                            <input type="hidden" id="tipeId">
                            <div class="mb-4">
                                <label for="namaTipe" class="form-label required-field">Nama Tipe Sparepart</label>
                                <input type="text" class="form-control form-control-lg" id="namaTipe"
                                    placeholder="Masukkan nama tipe sparepart" required>
                            </div>
                            <div class="mb-4">
                                <label for="kategoriTipe" class="form-label required-field">Kategori</label>
                                <select class="form-select form-select-lg" id="kategoriTipe" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Aset">Aset</option>
                                    <option value="Non Aset">Non Aset</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save me-1"></i> <span class="add-mode">Simpan</span><span
                                        class="edit-mode">Update</span> Tipe Sparepart
                                </button>
                                <button type="button" id="batalEditTipe"
                                    class="btn btn-secondary btn-lg edit-mode ms-2">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive mt-4">
                        <h5 class="mb-3"><i class="bi bi-list-ul me-2"></i> Daftar Tipe Sparepart</h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tipe</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableTipeBody">
                                <!-- Will be populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Vendor -->
                <div class="tab-pane fade" id="vendor" role="tabpanel">
                    <div class="form-container">
                        <h5 class="mb-4 text-center"><i class="bi bi-building me-2"></i>
                            <span class="add-mode">Tambah Vendor</span>
                            <span class="edit-mode">Edit Vendor</span>
                        </h5>
                        <form id="formVendor" class="simple-form">
                            <input type="hidden" id="vendorId">
                            <div class="mb-4">
                                <label for="namaVendor" class="form-label required-field">Nama Vendor</label>
                                <input type="text" class="form-control form-control-lg" id="namaVendor"
                                    placeholder="Masukkan nama vendor" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save me-1"></i> <span class="add-mode">Simpan</span><span
                                        class="edit-mode">Update</span> Vendor
                                </button>
                                <button type="button" id="batalEditVendor"
                                    class="btn btn-secondary btn-lg edit-mode ms-2">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive mt-4">
                        <h5 class="mb-3"><i class="bi bi-list-ul me-2"></i> Daftar Vendor</h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Vendor</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableVendorBody">
                                <!-- Will be populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Data storage (simulasi database)
    let jenisData = [
        { id: 1, nama: 'Engine Parts', kategori: 'Aset' },
        { id: 2, nama: 'Electrical Parts', kategori: 'Non Aset' },
        { id: 3, nama: 'Suspension Parts', kategori: 'Aset' }
    ];
    let tipeData = [
        { id: 1, nama: 'Piston Set', kategori: 'Aset' },
        { id: 2, nama: 'Alternator', kategori: 'Non Aset' },
        { id: 3, nama: 'Shock Absorber', kategori: 'Aset' }
    ];
    let vendorData = [
        { id: 1, nama: 'PT Auto Parts Indonesia' },
        { id: 2, nama: 'CV Maju Jaya Sparepart' },
        { id: 3, nama: 'PT Sumber Rejeki Motor' }
    ];

    // Variables untuk operasi edit/hapus
    let currentDeleteId = null;
    let currentDeleteType = null;
    const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

    // Toggle mode (add/edit)
    function toggleEditMode(type, isEdit) {
        const elements = document.querySelectorAll(`#${type} .edit-mode, #${type} .add-mode`);
        elements.forEach(el => {
            if (el.classList.contains('edit-mode')) {
                el.style.display = isEdit ? 'inline' : 'none';
            } else {
                el.style.display = isEdit ? 'none' : 'inline';
            }
        });
    }

    // Reset form
    function resetForm(type) {
        document.getElementById(`${type}Id`).value = '';
        document.getElementById(`nama${type.charAt(0).toUpperCase() + type.slice(1)}`).value = '';
        if (type === 'jenis') {
            document.getElementById('kategoriJenis').value = '';
        }
        if (type === 'tipe') {
            document.getElementById('kategoriTipe').value = '';
        }
        toggleEditMode(type, false);
    }

    // ===== JENIS SPAREPART =====
    document.getElementById('formJenis').addEventListener('submit', function (e) {
        e.preventDefault();
        const id = document.getElementById('jenisId').value;
        const namaJenis = document.getElementById('namaJenis').value;
        const kategoriJenis = document.getElementById('kategoriJenis').value;
        if (namaJenis.trim() === '') {
            alert('Nama jenis sparepart tidak boleh kosong!');
            return;
        }
        if (kategoriJenis === '') {
            alert('Kategori harus dipilih!');
            return;
        }
        if (id) {
            const index = jenisData.findIndex(item => item.id == id);
            if (index !== -1) {
                jenisData[index].nama = namaJenis;
                jenisData[index].kategori = kategoriJenis;
                alert('Data jenis sparepart berhasil diupdate!');
            }
        } else {
            const newId = jenisData.length > 0 ? Math.max(...jenisData.map(item => item.id)) + 1 : 1;
            jenisData.push({ id: newId, nama: namaJenis, kategori: kategoriJenis });
            alert('Data jenis sparepart "' + namaJenis + '" berhasil disimpan!');
        }
        renderJenisTable();
        this.reset();
        resetForm('jenis');
    });

    function editJenis(id, nama, kategori) {
        document.getElementById('jenisId').value = id;
        document.getElementById('namaJenis').value = nama;
        document.getElementById('kategoriJenis').value = kategori;
        document.getElementById('namaJenis').focus();
        toggleEditMode('jenis', true);
    }

    function hapusJenis(id) {
        currentDeleteId = id;
        currentDeleteType = 'jenis';
        document.getElementById('confirmDelete').onclick = confirmDeleteJenis;
        confirmDeleteModal.show();
    }

    function confirmDeleteJenis() {
        jenisData = jenisData.filter(item => item.id != currentDeleteId);
        renderJenisTable();
        confirmDeleteModal.hide();
        alert('Data berhasil dihapus!');
    }

    function renderJenisTable() {
        const tableBody = document.getElementById('tableJenisBody');
        tableBody.innerHTML = '';
        jenisData.forEach((item, index) => {
            const badgeClass = item.kategori === 'Aset' ? 'badge-aset' : 'badge-non-aset';
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${item.nama}</td>
                <td><span class="badge ${badgeClass}">${item.kategori}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editJenis(${item.id}, '${item.nama}', '${item.kategori}')">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="hapusJenis(${item.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    document.getElementById('batalEditJenis').addEventListener('click', function () {
        resetForm('jenis');
    });

    // ===== TIPE SPAREPART =====
    document.getElementById('formTipe').addEventListener('submit', function (e) {
        e.preventDefault();
        const id = document.getElementById('tipeId').value;
        const namaTipe = document.getElementById('namaTipe').value;
        const kategoriTipe = document.getElementById('kategoriTipe').value;
        if (namaTipe.trim() === '') {
            alert('Nama tipe sparepart tidak boleh kosong!');
            return;
        }
        if (kategoriTipe === '') {
            alert('Kategori harus dipilih!');
            return;
        }
        if (id) {
            const index = tipeData.findIndex(item => item.id == id);
            if (index !== -1) {
                tipeData[index].nama = namaTipe;
                tipeData[index].kategori = kategoriTipe;
                alert('Data tipe sparepart berhasil diupdate!');
            }
        } else {
            const newId = tipeData.length > 0 ? Math.max(...tipeData.map(item => item.id)) + 1 : 1;
            tipeData.push({ id: newId, nama: namaTipe, kategori: kategoriTipe });
            alert(`Data tipe sparepart "${namaTipe}" berhasil disimpan!`);
        }
        renderTipeTable();
        this.reset();
        resetForm('tipe');
    });

    function editTipe(id, nama, kategori) {
        document.getElementById('tipeId').value = id;
        document.getElementById('namaTipe').value = nama;
        document.getElementById('kategoriTipe').value = kategori;
        document.getElementById('namaTipe').focus();
        toggleEditMode('tipe', true);
    }

    function hapusTipe(id) {
        currentDeleteId = id;
        currentDeleteType = 'tipe';
        document.getElementById('confirmDelete').onclick = confirmDeleteTipe;
        confirmDeleteModal.show();
    }

    function confirmDeleteTipe() {
        tipeData = tipeData.filter(item => item.id != currentDeleteId);
        renderTipeTable();
        confirmDeleteModal.hide();
        alert('Data berhasil dihapus!');
    }

    function renderTipeTable() {
        const tableBody = document.getElementById('tableTipeBody');
        tableBody.innerHTML = '';
        tipeData.forEach((item, index) => {
            const badgeClass = item.kategori === 'Aset' ? 'badge-aset' : 'badge-non-aset';
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${item.nama}</td>
                <td><span class="badge ${badgeClass}">${item.kategori}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editTipe(${item.id}, '${item.nama}', '${item.kategori}')">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="hapusTipe(${item.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    document.getElementById('batalEditTipe').addEventListener('click', function () {
        resetForm('tipe');
    });

    // ===== VENDOR =====
    document.getElementById('formVendor').addEventListener('submit', function (e) {
        e.preventDefault();
        const id = document.getElementById('vendorId').value;
        const namaVendor = document.getElementById('namaVendor').value;
        if (namaVendor.trim() === '') {
            alert('Nama vendor tidak boleh kosong!');
            return;
        }
        if (id) {
            const index = vendorData.findIndex(item => item.id == id);
            if (index !== -1) {
                vendorData[index].nama = namaVendor;
                alert('Data vendor berhasil diupdate!');
            }
        } else {
            const newId = vendorData.length > 0 ? Math.max(...vendorData.map(item => item.id)) + 1 : 1;
            vendorData.push({ id: newId, nama: namaVendor });
            alert('Data vendor "' + namaVendor + '" berhasil disimpan!');
        }
        renderVendorTable();
        this.reset();
        resetForm('vendor');
    });

    function editVendor(id, nama) {
        document.getElementById('vendorId').value = id;
        document.getElementById('namaVendor').value = nama;
        document.getElementById('namaVendor').focus();
        toggleEditMode('vendor', true);
    }

    function hapusVendor(id) {
        currentDeleteId = id;
        currentDeleteType = 'vendor';
        document.getElementById('confirmDelete').onclick = confirmDeleteVendor;
        confirmDeleteModal.show();
    }

    function confirmDeleteVendor() {
        vendorData = vendorData.filter(item => item.id != currentDeleteId);
        renderVendorTable();
        confirmDeleteModal.hide();
        alert('Data berhasil dihapus!');
    }

    function renderVendorTable() {
        const tableBody = document.getElementById('tableVendorBody');
        tableBody.innerHTML = '';
        vendorData.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${item.nama}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editVendor(${item.id}, '${item.nama}')">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="hapusVendor(${item.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    document.getElementById('batalEditVendor').addEventListener('click', function () {
        resetForm('vendor');
    });

    // Tab functionality
    const triggerTabList = document.querySelectorAll('#sparepartTabs button');
    triggerTabList.forEach(triggerEl => {
        triggerEl.addEventListener('click', function () {
            resetForm('jenis');
            resetForm('tipe');
            resetForm('vendor');
        });
    });

    // Initial render
    renderJenisTable();
    renderTipeTable();
    renderVendorTable();
</script>
@endpush