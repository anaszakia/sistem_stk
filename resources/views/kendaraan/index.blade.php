@extends('layouts.app')

@section('title', 'Data Kendaraan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Data Kendaraan</h1>
            <p class="text-gray-600 mt-1">Kelola data kendaraan operasional</p>
        </div>
        @can('create kendaraan')
        <a href="{{ route('kendaraan.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center shadow-sm">
            <i class="fas fa-plus mr-2"></i>
            Tambah Kendaraan
        </a>
        @endcan
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                <span class="text-green-800">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <span class="text-red-800">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-car text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Total Kendaraan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $kendaraan->total() }}</p>
                </div>
            </div>
        </div>
        
        @php
            $allKendaraan = \App\Models\Kendaraan::all();
            $today = now();
            $expired = $allKendaraan->filter(function($k) use ($today) {
                return $k->pajak_stnk && \Carbon\Carbon::parse($k->pajak_stnk)->lt($today);
            })->count();
            $expiringSoon = $allKendaraan->filter(function($k) use ($today) {
                if (!$k->pajak_stnk) return false;
                $pajak = \Carbon\Carbon::parse($k->pajak_stnk);
                $daysDiff = $today->diffInDays($pajak, false);
                return $daysDiff >= 0 && $daysDiff <= 30;
            })->count();
            $active = $allKendaraan->filter(function($k) use ($today) {
                if (!$k->pajak_stnk) return false;
                $pajak = \Carbon\Carbon::parse($k->pajak_stnk);
                return $pajak->diffInDays($today, false) > 30;
            })->count();
        @endphp
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Pajak Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $active }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Segera Expired</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $expiringSoon }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Pajak Expired</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $expired }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Daftar Kendaraan</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plat Nomor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pajak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kendaraan as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $kendaraan->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-car text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $item->nama_kendaraan }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $item->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-tag mr-1.5"></i>
                                {{ $item->jenis }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center font-mono text-sm font-semibold text-gray-900 bg-gray-100 px-3 py-1 rounded">
                                <i class="fas fa-id-card mr-2 text-gray-500"></i>
                                {{ $item->plat_nomor }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->pajak_stnk)
                                @php
                                    $today = now();
                                    $pajak = \Carbon\Carbon::parse($item->pajak_stnk);
                                    $daysDiff = $today->diffInDays($pajak, false);
                                @endphp
                                
                                @if($daysDiff < 0)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1.5"></i>
                                        Expired - {{ $pajak->format('d/m/Y') }}
                                    </span>
                                @elseif($daysDiff <= 30)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-exclamation-triangle mr-1.5"></i>
                                        {{ $daysDiff }} hari lagi
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1.5"></i>
                                        Aktif - {{ $pajak->format('d/m/Y') }}
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    <i class="fas fa-minus-circle mr-1.5"></i>
                                    Tidak ada data
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                @can('view kendaraan')
                                <a href="{{ route('kendaraan.show', $item) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg transition-colors text-xs font-medium"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endcan
                                
                                @can('edit kendaraan')
                                <a href="{{ route('kendaraan.edit', $item) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-lg transition-colors text-xs font-medium"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                
                                @can('delete kendaraan')
                                <button type="button" 
                                        onclick="confirmDelete('{{ route('kendaraan.destroy', $item) }}', '{{ $item->nama_kendaraan }}')"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg transition-colors text-xs font-medium"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-car text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium mb-1">Belum ada data kendaraan</p>
                                <p class="text-gray-400 text-sm mb-4">Tambahkan kendaraan pertama Anda</p>
                                @can('create kendaraan')
                                <a href="{{ route('kendaraan.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah Kendaraan
                                </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kendaraan->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $kendaraan->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation using SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(url, namaKendaraan) {
    Swal.fire({
        title: 'Hapus Kendaraan?',
        html: `Apakah Anda yakin ingin menghapus kendaraan <strong>${namaKendaraan}</strong>?<br><small class="text-gray-500">Tindakan ini tidak dapat dibatalkan.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus',
        cancelButtonText: '<i class="fas fa-times mr-1"></i> Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'px-4 py-2 rounded-lg',
            cancelButton: 'px-4 py-2 rounded-lg'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection