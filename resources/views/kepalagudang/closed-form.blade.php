@extends('layouts.kepalagudang')

@section('title', 'Closed Form - Validasi User')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">
            <i class="bi bi-file-earmark-check me-2 text-primary"></i>
            Closed Form (Validasi User)
        </h1>
        <p class="page-subtitle">Daftar permintaan yang sudah divalidasi oleh user</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-container">
        <h5>
            <i class="bi bi-list-ul me-2"></i>
            Daftar Permintaan
        </h5>

        @if($permintaans->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 mb-3 d-block"></i>
                <p>Belum ada permintaan yang divalidasi user.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Tiket</th>
                            <th>User</th>
                            <th>Tanggal Validasi</th>
                            <th>Bukti</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permintaans as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><code>{{ $p->tiket }}</code></td>
                                <td>{{ $p->user_name ?? '-' }}</td>
                                <td>
                                    @if($p->tanggal_penerimaan)
                                        {{ \Carbon\Carbon::parse($p->tanggal_penerimaan)->translatedFormat('d F Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($p->foto_bukti_penerimaan)
                                        <a href="{{ asset('storage/' . $p->foto_bukti_penerimaan) }}" 
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('kepalagudang.closed.form.verify', $p->tiket) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle me-1"></i> Verifikasi
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection