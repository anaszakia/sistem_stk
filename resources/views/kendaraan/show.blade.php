@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">Detail Kendaraan</h2>
                <div class="flex space-x-2">
                    @can('edit kendaraan')
                    <a href="{{ route('kendaraan.edit', $kendaraan) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    @endcan
                    <a href="{{ route('kendaraan.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 gap-6">
                <!-- Nama Kendaraan -->
                <div class="border-b border-gray-200 pb-4">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Nama Kendaraan</dt>
                    <dd class="text-lg font-semibold text-gray-900">{{ $kendaraan->nama_kendaraan }}</dd>
                </div>

                <!-- Jenis -->
                <div class="border-b border-gray-200 pb-4">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Jenis Kendaraan</dt>
                    <dd class="text-sm">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $kendaraan->jenis }}
                        </span>
                    </dd>
                </div>

                <!-- Plat Nomor -->
                <div class="border-b border-gray-200 pb-4">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Plat Nomor</dt>
                    <dd class="text-lg font-mono font-bold text-gray-900 bg-yellow-100 inline-block px-3 py-1 rounded border-2 border-black">
                        {{ $kendaraan->plat_nomor }}
                    </dd>
                </div>

                <!-- Pajak STNK -->
                <div class="border-b border-gray-200 pb-4">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Pajak STNK</dt>
                    <dd class="text-sm">
                        @if($kendaraan->pajak_stnk)
                            @php
                                $today = now();
                                $pajak = \Carbon\Carbon::parse($kendaraan->pajak_stnk);
                                $daysDiff = $today->diffInDays($pajak, false);
                            @endphp
                            
                            <div class="flex items-center space-x-3">
                                <span class="text-lg font-semibold text-gray-900">
                                    {{ $pajak->format('d F Y') }}
                                </span>
                                
                                @if($daysDiff < 0)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Expired {{ abs($daysDiff) }} hari yang lalu
                                    </span>
                                @elseif($daysDiff <= 30)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Akan expired dalam {{ $daysDiff }} hari
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Masih berlaku
                                    </span>
                                @endif
                            </div>
                        @else
                            <span class="text-gray-400 italic">Belum diisi</span>
                        @endif
                    </dd>
                </div>

                <!-- Informasi Sistem -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Informasi Sistem</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">Dibuat</dt>
                            <dd class="text-gray-900">{{ $kendaraan->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Diperbarui</dt>
                            <dd class="text-gray-900">{{ $kendaraan->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
            @can('delete kendaraan')
            <form action="{{ route('kendaraan.destroy', $kendaraan) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="button" 
                        onclick="confirmDelete(this.closest('form'), '{{ $kendaraan->nama_kendaraan }}')"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </form>
            @endcan
        </div>
    </div>
</div>
@endsection