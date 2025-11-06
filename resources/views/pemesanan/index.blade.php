@extends('layouts.app')

@section('title', 'Pemesanan Kendaraan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Pemesanan Kendaraan</h1>
            <p class="text-gray-600 mt-1">Kelola pemesanan kendaraan operasional</p>
        </div>
        @can('create pemesanan')
        <a href="{{ route('pemesanan.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center shadow-sm">
            <i class="fas fa-plus mr-2"></i>
            Pesan Kendaraan
        </a>
        @endcan
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @php
            $allPemesanan = auth()->user()->can('view all pemesanan') 
                ? \App\Models\Pemesanan::all() 
                : \App\Models\Pemesanan::where('user_id', auth()->id())->get();
        @endphp
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $allPemesanan->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Disetujui</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $allPemesanan->where('status', 'disetujui')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Ditolak</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $allPemesanan->where('status', 'ditolak')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-check-double text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $allPemesanan->where('status', 'selesai')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Daftar Pemesanan</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemesan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pemesanan as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $pemesanan->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-car text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $item->kendaraan->nama_kendaraan }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->kendaraan->plat_nomor }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $item->user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $item->keperluan }}</div>
                            <div class="text-xs text-gray-500">{{ Str::limit($item->tujuan, 30) }}</div>
                            @if($item->penumpang)
                                @php
                                    $penumpangCount = count(array_filter(array_map('trim', preg_split('/[\n,]+/', $item->penumpang))));
                                @endphp
                                <div class="text-xs text-blue-600 mt-1">
                                    <i class="fas fa-users mr-1"></i>{{ $penumpangCount }} penumpang
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="text-gray-900">{{ $item->tanggal_mulai->format('d/m/Y H:i') }}</div>
                            <div class="text-gray-500 text-xs">s/d {{ $item->tanggal_selesai->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1.5"></i>Pending
                                </span>
                            @elseif($item->status === 'disetujui')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1.5"></i>Disetujui
                                </span>
                            @elseif($item->status === 'ditolak')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1.5"></i>Ditolak
                                </span>
                            @elseif($item->status === 'selesai')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-check-double mr-1.5"></i>Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($item->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('pemesanan.show', $item) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg transition-colors text-xs font-medium"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @can('approve pemesanan')
                                    @if($item->status === 'pending')
                                        <a href="{{ route('pemesanan.approve.form', $item) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 hover:bg-green-200 rounded-lg transition-colors text-xs font-medium"
                                           title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <button onclick="rejectBooking({{ $item->id }})"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg transition-colors text-xs font-medium"
                                                title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                    @if($item->status === 'disetujui')
                                        <button onclick="completeBooking({{ $item->id }})"
                                                class="inline-flex items-center px-3 py-1.5 bg-purple-100 text-purple-700 hover:bg-purple-200 rounded-lg transition-colors text-xs font-medium"
                                                title="Selesaikan">
                                            <i class="fas fa-flag-checkered"></i>
                                        </button>
                                    @endif
                                @endcan
                                
                                @if($item->user_id === auth()->id() && $item->status === 'pending')
                                    @can('edit pemesanan')
                                        <a href="{{ route('pemesanan.edit', $item) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-lg transition-colors text-xs font-medium"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    
                                    @can('delete pemesanan')
                                        <button onclick="deleteBooking('{{ route('pemesanan.destroy', $item) }}', '{{ $item->keperluan }}')"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg transition-colors text-xs font-medium"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-calendar-check text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium mb-1">Belum ada pemesanan</p>
                                <p class="text-gray-400 text-sm mb-4">Mulai pesan kendaraan untuk kebutuhan Anda</p>
                                @can('create pemesanan')
                                <a href="{{ route('pemesanan.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                                    <i class="fas fa-plus mr-2"></i>
                                    Pesan Kendaraan
                                </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pemesanan->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $pemesanan->links() }}
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function rejectBooking(id) {
    Swal.fire({
        title: 'Tolak Pemesanan?',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan (opsional)',
        inputPlaceholder: 'Masukkan alasan penolakan...',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-times mr-1"></i> Ya, Tolak',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/pemesanan/${id}/reject`;
            form.innerHTML = `@csrf
                <input type="hidden" name="keterangan" value="${result.value || ''}">`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function completeBooking(id) {
    Swal.fire({
        title: 'Selesaikan Pemesanan?',
        text: 'Kendaraan akan kembali tersedia (status kosong)',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#8b5cf6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-flag-checkered mr-1"></i> Selesaikan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/pemesanan/${id}/complete`;
            form.innerHTML = '@csrf';
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function deleteBooking(url, keperluan) {
    Swal.fire({
        title: 'Batalkan Pemesanan?',
        html: `Apakah Anda yakin ingin membatalkan pemesanan untuk <strong>${keperluan}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Batalkan',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection
