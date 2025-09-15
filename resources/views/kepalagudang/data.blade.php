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
                    <button class="nav-link" id="vendor-tab" data-bs-toggle="tab" data-bs-target="#vendor" type="button"
                        role="tab">
                        <i class="bi bi-building me-1"></i> Vendor
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="sparepartTabsContent">

                <!-- Tab Jenis Sparepart -->
                <div class="tab-pane fade show active" id="jenis" role="tabpanel">
                    <form id="formJenis" class="simple-form" action="{{ route('kepalagudang.jenis.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="jenisId">

                        <div class="mb-4">
                            <label for="namaJenis" class="form-label required-field">Nama Jenis Sparepart</label>
                            <input type="text" class="form-control form-control-lg" id="namaJenis" name="nama"
                                placeholder="Masukkan nama jenis sparepart" required>
                        </div>

                        <div class="mb-4">
                            <label for="kategoriJenis" class="form-label required-field">Kategori</label>
                            <select class="form-select form-select-lg" id="kategoriJenis" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="aset">Aset</option>
                                <option value="non-aset">Non Aset</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save me-1"></i> Simpan Jenis Sparepart
                            </button>
                        </div>
                    </form>

                    <!-- Tabel Jenis Sparepart -->
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
                            <tbody>
                                @foreach ($jenis as $index => $j)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $j->nama }}</td>
                                        <td>
                                            <span class="badge {{ $j->kategori === 'aset' ? 'badge-aset' : 'badge-non-aset' }}">
                                                {{ $j->kategori }}
                                            </span>
                                        </td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editJenisModal{{ $j->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editJenisModal{{ $j->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('kepalagudang.jenis.update', $j->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Jenis Sparepart</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label>Nama Jenis</label>
                                                                    <input type="text" name="nama" class="form-control"
                                                                        value="{{ $j->nama }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label>Kategori</label>
                                                                    <select name="kategori" class="form-control" required>
                                                                        <option value="aset" {{ $j->kategori == 'aset' ? 'selected' : '' }}>Aset</option>
                                                                        <option value="non-aset" {{ $j->kategori == 'non-aset' ? 'selected' : '' }}>Non-Aset</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('kepalagudang.jenis.destroy', $j->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Tipe Sparepart -->
                <div class="tab-pane fade" id="tipe" role="tabpanel">
                    <form id="formTipe" class="simple-form" action="{{ route('kepalagudang.tipe.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="tipeId">

                        <div class="mb-4">
                            <label for="namaTipe" class="form-label required-field">Nama Tipe Sparepart</label>
                            <input type="text" class="form-control form-control-lg" id="namaTipe" name="nama"
                                placeholder="Masukkan nama tipe sparepart" required>
                        </div>

                        <div class="mb-4">
                            <label for="kategoriTipe" class="form-label required-field">Kategori</label>
                            <select class="form-select form-select-lg" id="kategoriTipe" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="aset">Aset</option>
                                <option value="non-aset">Non Aset</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save me-1"></i> Simpan Tipe Sparepart
                            </button>
                        </div>
                    </form>

                    <!-- Tabel Tipe Sparepart -->
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
                            <tbody>
                                @foreach ($tipe as $index => $t)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $t->nama }}</td>
                                        <td>
                                            <span class="badge {{ $t->kategori === 'aset' ? 'badge-aset' : 'badge-non-aset' }}">
                                                {{ $t->kategori }}
                                            </span>
                                        </td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editTipeModal{{ $t->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editTipeModal{{ $t->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('kepalagudang.tipe.update', $t->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Jenis Sparepart</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label>Nama Jenis</label>
                                                                    <input type="text" name="nama" class="form-control"
                                                                        value="{{ $t->nama }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label>Kategori</label>
                                                                    <select name="kategori" class="form-control" required>
                                                                        <option value="aset" {{ $t->kategori == 'aset' ? 'selected' : '' }}>Aset</option>
                                                                        <option value="non-aset" {{ $t->kategori == 'non-aset' ? 'selected' : '' }}>Non-Aset</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('kepalagudang.tipe.destroy', $t->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Vendor -->
                <div class="tab-pane fade" id="vendor" role="tabpanel">
                    <form id="formVendor" class="simple-form" action="{{ route('kepalagudang.vendor.store') }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="id" id="vendorId">

                        <div class="mb-4">
                            <label for="namaVendor" class="form-label required-field">Nama Vendor</label>
                            <input type="text" class="form-control form-control-lg" id="namaVendor" name="nama"
                                placeholder="Masukkan nama vendor" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save me-1"></i> Simpan Vendor
                            </button>
                        </div>
                    </form>

                    <!-- Tabel Vendor -->
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
                            <tbody>
                                @foreach ($vendor as $index => $v)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $v->nama }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editVendorModal{{ $v->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Modal Edit Vendor -->
                                            <div class="modal fade" id="editVendorModal{{ $v->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('kepalagudang.vendor.update', $v->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Vendor</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label>Nama Vendor</label>
                                                                    <input type="text" name="nama" class="form-control"
                                                                        value="{{ $v->nama }}" required>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('kepalagudang.vendor.destroy', $v->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Yakin ingin menghapus vendor ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
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
        document.addEventListener("DOMContentLoaded", function () {
            // Ambil tab terakhir dari localStorage
            let activeTab = localStorage.getItem("activeTab");
            if (activeTab) {
                let tabElement = document.querySelector(`[data-bs-target="${activeTab}"]`);
                if (tabElement) {
                    let tab = new bootstrap.Tab(tabElement);
                    tab.show();
                }
            }

            // Simpan tab terakhir saat user klik
            const tabButtons = document.querySelectorAll('button[data-bs-toggle="tab"]');
            tabButtons.forEach(button => {
                button.addEventListener("shown.bs.tab", function (e) {
                    let target = e.target.getAttribute("data-bs-target");
                    localStorage.setItem("activeTab", target);
                });
            });
        });
    </script>
@endpush