@extends('layouts.superadmin')

@section('title', 'Request Barang - Superadmin')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-0"><i class="bi bi-cart-check me-2"></i>Daftar Request Barang</h4>
                <p class="text-muted mb-0">Kelola permintaan barang dari berbagai RO</p>
            </div>
            <div>
                <span class="badge bg-light text-dark me-2">
                    <i class="bi bi-calendar me-1"></i> {{ date('d F Y') }}
                </span>
                <a href="{{ route('superadmin.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card card p-3 mb-4">
        <h5 class="mb-4"><i class="bi bi-funnel me-2"></i>Filter Request</h5>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="statusFilter" class="form-label">Status Request</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="menunggu">Menunggu Approval</option>
                    <option value="diproses">Diproses</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="dikirim">Dikirim</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="dateFilter" class="form-label">Tanggal Request</label>
                <input type="date" class="form-control" id="dateFilter">
            </div>
            <div class="col-md-4 mb-3">
                <label for="searchFilter" class="form-label">Cari Request</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari ID atau nama barang..." id="searchFilter">
                    <button class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button class="btn btn-light me-2">
                <i class="bi bi-arrow-clockwise me-1"></i> Reset
            </button>
            <button class="btn btn-primary">
                <i class="bi bi-filter me-1"></i> Terapkan Filter
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="dashboard-card p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-clock-history text-warning fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Pending</h6>
                        <h4 class="mb-0 fw-bold text-warning">3</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-check-circle text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Disetujui</h6>
                        <h4 class="mb-0 fw-bold text-success">12</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 p-3 rounded me-3">
                        <i class="bi bi-x-circle text-danger fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Ditolak</h6>
                        <h4 class="mb-0 fw-bold text-danger">2</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <table class="table">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Requester</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>REQ001</td>
                <td>08/09/2025</td>
                <td>RO Batam</td>
                <td><span class="badge bg-warning">Pending</span></td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="showRequestDetail('REQ001')">Detail</button>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="requestDetailModal" tabindex="-1" aria-labelledby="requestDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestDetailLabel">Detail Request Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Info Request -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>ID Request:</strong> <span id="detailReqId"></span></p>
                            <p><strong>Requester:</strong> <span id="detailRequester"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tanggal:</strong> <span id="detailTanggal"></span></p>
                            <p><strong>Status:</strong> <span class="badge bg-warning" id="detailStatus"></span></p>
                        </div>
                    </div>

                    <!-- Table Items -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Item</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="detailItems">
                                <!-- isi via JS -->
                            </tbody>
                        </table>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-success" onclick="approveRequest()">Approve</button>
                        <button type="button" class="btn btn-danger" onclick="rejectRequest()">Reject</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




        <!-- Pagination -->
        <div class="pagination-container d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Menampilkan 1 hingga 5 dari 22 entri
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Sebelumnya</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Selanjutnya</a>
                    </li>
                </ul>
            </nav>
        </div>

@endsection

    @push('scripts')
        <script>
            function showRequestDetail(id) {
                const requests = {
                    "REQ001": {
                        requester: "RO Batam",
                        tanggal: "2025-08-25",
                        status: "Menunggu Approval",
                        items: [
                            { nama: "Oli Mesin", deskripsi: "Pelumas mesin motor", jumlah: 50, keterangan: "Urgent" },
                            { nama: "Filter Udara", deskripsi: "Filter udara standar", jumlah: 30, keterangan: "Stok menipis" },
                            { nama: "Busi", deskripsi: "Busi NGK", jumlah: 100, keterangan: "-" },
                        ]
                    }
                };

                let req = requests[id];
                if (req) {
                    document.getElementById("detailReqId").innerText = id;
                    document.getElementById("detailRequester").innerText = req.requester;
                    document.getElementById("detailTanggal").innerText = req.tanggal;
                    document.getElementById("detailStatus").innerText = req.status;

                    let itemsHtml = "";
                    req.items.forEach((item, index) => {
                        itemsHtml += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.nama}</td>
                        <td>${item.deskripsi}</td>
                        <td>${item.jumlah}</td>
                        <td>${item.keterangan}</td>
                    </tr>
                `;
                    });
                    document.getElementById("detailItems").innerHTML = itemsHtml;
                }

                let modal = new bootstrap.Modal(document.getElementById('requestDetailModal'));
                modal.show();
            }

            function approveRequest() {
                document.getElementById("detailStatus").innerText = "Disetujui";
                document.getElementById("detailStatus").className = "badge bg-success";
                alert("Request berhasil disetujui!");
            }

            function rejectRequest() {
                let alasan = prompt("Masukkan alasan penolakan request:");
                if (alasan && alasan.trim() !== "") {
                    document.getElementById("detailStatus").innerText = "Ditolak";
                    document.getElementById("detailStatus").className = "badge bg-danger";
                    alert("Request ditolak dengan alasan: " + alasan);
                } else {
                    alert("Penolakan dibatalkan. Alasan wajib diisi!");
                }
            }

        </script>
    @endpush