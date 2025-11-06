@extends('layouts.app')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Detail Pemesanan</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap pemesanan kendaraan</p>
        </div>
        <a href="{{ route('pemesanan.index') }}" 
           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info Card -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Status Pemesanan
                    </h3>
                    @php
                        $statusConfig = [
                            'pending' => ['color' => 'yellow', 'icon' => 'clock', 'text' => 'Menunggu Persetujuan'],
                            'approved' => ['color' => 'green', 'icon' => 'check-circle', 'text' => 'Disetujui'],
                            'rejected' => ['color' => 'red', 'icon' => 'times-circle', 'text' => 'Ditolak'],
                            'completed' => ['color' => 'blue', 'icon' => 'flag-checkered', 'text' => 'Selesai'],
                            'cancelled' => ['color' => 'gray', 'icon' => 'ban', 'text' => 'Dibatalkan'],
                        ];
                        $config = $statusConfig[$pemesanan->status] ?? ['color' => 'gray', 'icon' => 'question', 'text' => ucfirst($pemesanan->status)];
                    @endphp
                    <span class="bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 px-4 py-2 rounded-lg font-semibold text-sm flex items-center">
                        <i class="fas fa-{{ $config['icon'] }} mr-2"></i>
                        {{ $config['text'] }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Kode Pemesanan:</span>
                        <p class="font-semibold text-gray-900 mt-1">#PMS-{{ str_pad($pemesanan->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">Tanggal Dibuat:</span>
                        <p class="font-semibold text-gray-900 mt-1">{{ $pemesanan->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Kendaraan -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-car text-blue-600 mr-2"></i>
                    Informasi Kendaraan
                </h3>
                <div class="space-y-4">
                    <div class="flex items-start pb-4 border-b border-gray-200">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-car text-blue-600 text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 text-lg">{{ $pemesanan->kendaraan->nama_kendaraan }}</h4>
                            <p class="text-gray-600 text-sm">{{ $pemesanan->kendaraan->jenis }}</p>
                        </div>
                        @php
                            $statusKendaraan = [
                                'kosong' => ['color' => 'green', 'icon' => 'check-circle', 'text' => 'Tersedia'],
                                'terpakai' => ['color' => 'red', 'icon' => 'times-circle', 'text' => 'Terpakai'],
                                'service' => ['color' => 'yellow', 'icon' => 'wrench', 'text' => 'Service'],
                            ];
                            $kConfig = $statusKendaraan[$pemesanan->kendaraan->status] ?? ['color' => 'gray', 'icon' => 'question', 'text' => ucfirst($pemesanan->kendaraan->status)];
                        @endphp
                        <span class="bg-{{ $kConfig['color'] }}-100 text-{{ $kConfig['color'] }}-800 px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                            <i class="fas fa-{{ $kConfig['icon'] }} mr-1"></i>
                            {{ $kConfig['text'] }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-gray-600 text-sm block mb-1">
                                <i class="fas fa-id-card text-gray-400 mr-1"></i>
                                Nomor Plat
                            </span>
                            <p class="font-semibold text-gray-900">{{ $pemesanan->kendaraan->plat_nomor }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600 text-sm block mb-1">
                                <i class="fas fa-calendar-alt text-gray-400 mr-1"></i>
                                Pajak STNK
                            </span>
                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($pemesanan->kendaraan->pajak_stnk)->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Pemesanan -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-clipboard-list text-blue-600 mr-2"></i>
                    Detail Pemesanan
                </h3>
                <div class="space-y-4">
                    <div>
                        <span class="text-gray-600 text-sm block mb-2">
                            <i class="fas fa-tasks text-gray-400 mr-1"></i>
                            Keperluan
                        </span>
                        <p class="text-gray-900 font-medium">{{ $pemesanan->keperluan }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm block mb-2">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                            Tujuan
                        </span>
                        <p class="text-gray-900">{{ $pemesanan->tujuan }}</p>
                    </div>
                    @if($pemesanan->penumpang)
                    <div class="pt-4 border-t border-gray-200">
                        <span class="text-gray-600 text-sm block mb-2">
                            <i class="fas fa-users text-gray-400 mr-1"></i>
                            Daftar Penumpang
                        </span>
                        <div class="bg-gray-50 rounded-lg p-4">
                            @php
                                $penumpangList = preg_split('/[\n,]+/', $pemesanan->penumpang);
                                $penumpangList = array_filter(array_map('trim', $penumpangList));
                            @endphp
                            <ul class="space-y-2">
                                @foreach($penumpangList as $index => $penumpang)
                                <li class="flex items-center text-gray-900">
                                    <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-semibold mr-2">
                                        {{ $index + 1 }}
                                    </span>
                                    {{ $penumpang }}
                                </li>
                                @endforeach
                            </ul>
                            <p class="text-xs text-gray-500 mt-3 pt-3 border-t border-gray-200">
                                <i class="fas fa-info-circle mr-1"></i>
                                Total: <strong>{{ count($penumpangList) }} penumpang</strong>
                            </p>
                        </div>
                    </div>
                    @endif
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                        <div class="bg-green-50 rounded-lg p-4">
                            <span class="text-green-700 text-sm font-medium block mb-1">
                                <i class="fas fa-calendar-day mr-1"></i>
                                Tanggal Mulai
                            </span>
                            <p class="text-green-900 font-semibold">{{ $pemesanan->tanggal_mulai->format('d M Y') }}</p>
                            <p class="text-green-700 text-sm">{{ $pemesanan->tanggal_mulai->format('H:i') }} WIB</p>
                        </div>
                        <div class="bg-red-50 rounded-lg p-4">
                            <span class="text-red-700 text-sm font-medium block mb-1">
                                <i class="fas fa-calendar-check mr-1"></i>
                                Tanggal Selesai
                            </span>
                            <p class="text-red-900 font-semibold">{{ $pemesanan->tanggal_selesai->format('d M Y') }}</p>
                            <p class="text-red-700 text-sm">{{ $pemesanan->tanggal_selesai->format('H:i') }} WIB</p>
                        </div>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <span class="text-blue-700 text-sm font-medium block mb-1">
                            <i class="fas fa-clock mr-1"></i>
                            Durasi Pemesanan
                        </span>
                        <p class="text-blue-900 font-semibold">
                            {{ $pemesanan->tanggal_mulai->diffInDays($pemesanan->tanggal_selesai) }} hari
                            ({{ $pemesanan->tanggal_mulai->diffInHours($pemesanan->tanggal_selesai) }} jam)
                        </p>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            @if($pemesanan->catatan)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h4 class="font-medium text-yellow-900 mb-2">
                    <i class="fas fa-sticky-note mr-2"></i>
                    Catatan
                </h4>
                <p class="text-yellow-800 text-sm">{{ $pemesanan->catatan }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Pemesan Info -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-user text-blue-600 mr-2"></i>
                    Pemesan
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-blue-600 text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $pemesanan->user->name }}</p>
                            <p class="text-gray-600 text-sm">{{ $pemesanan->user->email }}</p>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-gray-200">
                        <span class="text-gray-600 text-sm">Role:</span>
                        <p class="font-medium text-gray-900 mt-1">
                            {{ $pemesanan->user->roles->pluck('name')->map(fn($role) => ucwords(str_replace('_', ' ', $role)))->join(', ') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Approval Info -->
            @if($pemesanan->approved_by && $pemesanan->approved_at)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-user-check text-green-600 mr-2"></i>
                    Disetujui Oleh
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-tie text-green-600 text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $pemesanan->approvedBy->name ?? 'N/A' }}</p>
                            <p class="text-gray-600 text-sm">{{ $pemesanan->approvedBy->email ?? '' }}</p>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-gray-200">
                        <span class="text-gray-600 text-sm">Tanggal Persetujuan:</span>
                        <p class="font-medium text-gray-900 mt-1">{{ $pemesanan->approved_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Surat Jalan Info -->
            @if($pemesanan->suratJalan)
            <div class="bg-green-50 border border-green-200 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-green-900 mb-4">
                    <i class="fas fa-file-alt text-green-600 mr-2"></i>
                    Surat Jalan
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-green-700 text-sm">Nomor Surat:</span>
                        <p class="font-semibold text-green-900 mt-1">{{ $pemesanan->suratJalan->nomor_surat }}</p>
                    </div>
                    <div class="pt-3 border-t border-green-200">
                        <a href="{{ route('surat-jalan.show', $pemesanan->suratJalan) }}" 
                           class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-file-alt mr-2"></i>
                            Lihat Surat Jalan
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('surat-jalan.print', $pemesanan->suratJalan) }}" 
                           target="_blank"
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-print mr-2"></i>
                            Print PDF
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-cog text-blue-600 mr-2"></i>
                    Aksi
                </h3>
                <div class="space-y-3">
                    @can('edit pemesanan')
                        @if($pemesanan->status === 'pending' && $pemesanan->user_id === auth()->id())
                        <a href="{{ route('pemesanan.edit', $pemesanan) }}" 
                           class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Pemesanan
                        </a>
                        @endif
                    @endcan

                    @can('approve pemesanan')
                        @if($pemesanan->status === 'pending')
                        <a href="{{ route('pemesanan.approve.form', $pemesanan) }}" 
                           class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-check mr-2"></i>
                            Setujui
                        </a>
                        <form action="{{ route('pemesanan.reject', $pemesanan) }}" method="POST" class="reject-form">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-times mr-2"></i>
                                Tolak
                            </button>
                        </form>
                        @endif

                        @if($pemesanan->status === 'approved')
                        <form action="{{ route('pemesanan.complete', $pemesanan) }}" method="POST" class="complete-form">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-flag-checkered mr-2"></i>
                                Selesaikan
                            </button>
                        </form>
                        @endif
                    @endcan

                    @can('delete pemesanan')
                        @if($pemesanan->status === 'pending' && $pemesanan->user_id === auth()->id())
                        <form action="{{ route('pemesanan.destroy', $pemesanan) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-trash mr-2"></i>
                                Batalkan
                            </button>
                        </form>
                        @endif
                    @endcan

                    <a href="{{ route('kendaraan.show', $pemesanan->kendaraan) }}" 
                       class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-car mr-2"></i>
                        Lihat Detail Kendaraan
                    </a>
                </div>
            </div>

            <!-- Timeline/History -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-history text-blue-600 mr-2"></i>
                    Riwayat
                </h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Pemesanan Dibuat</p>
                            <p class="text-xs text-gray-600">{{ $pemesanan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @if($pemesanan->approved_at)
                    <div class="flex items-start">
                        <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $pemesanan->status === 'rejected' ? 'Ditolak' : 'Disetujui' }}
                            </p>
                            <p class="text-xs text-gray-600">{{ $pemesanan->approved_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @endif
                    @if($pemesanan->status === 'completed')
                    <div class="flex items-start">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 mr-3"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Selesai</p>
                            <p class="text-xs text-gray-600">{{ $pemesanan->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Reject confirmation
    document.querySelectorAll('.reject-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Tolak Pemesanan?',
                text: 'Pemesanan akan ditolak dan kendaraan tetap tersedia',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Complete confirmation
    document.querySelectorAll('.complete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Selesaikan Pemesanan?',
                text: 'Kendaraan akan kembali tersedia setelah diselesaikan',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Selesaikan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Batalkan Pemesanan?',
                text: 'Pemesanan akan dibatalkan dan tidak dapat dikembalikan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
