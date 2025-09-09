@extends('layouts.user')

@section('title', 'Jenis Barang')

@section('content')
<div class="py-8 px-6">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="table-responsive">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($jenisBarang as $index => $jenis)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium">{{ $jenis->jenis }}</td>
                            <td class="px-6 py-4 text-sm">{{ $jenis->listBarang->count() }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if ($jenis->listBarang->count() > 0)
                                    <span class="badge bg-success text-white px-2 py-1 rounded text-xs">
                                        {{ $jenis->listBarang->sum('quantity') }} unit
                                    </span>
                                @else
                                    <span class="badge bg-secondary text-white px-2 py-1 rounded text-xs">
                                        Kosong
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada jenis barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection