@extends('layouts.app')

@section('title', 'Detail Surat Jalan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Detail Surat Jalan</h1>
            <p class="text-gray-600 mt-1">{{ $suratJalan->nomor_surat }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('surat-jalan.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
            <a href="{{ route('surat-jalan.print', $suratJalan) }}" 
               target="_blank"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                <i class="fas fa-print mr-2"></i>
                Print
            </a>
            <a href="{{ route('surat-jalan.download', $suratJalan) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                <i class="fas fa-download mr-2"></i>
                Download PDF
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
        <!-- Status Badge -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">SURAT JALAN</h2>
                <p class="text-lg font-semibold text-blue-600">{{ $suratJalan->nomor_surat }}</p>
            </div>
            @if($suratJalan->status === 'aktif')
                <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-green-100 text-green-800">
                    <i class="fas fa-car-side mr-2"></i>Sedang Berjalan
                </span>
            @else
                <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-blue-100 text-blue-800">
                    <i class="fas fa-check-double mr-2"></i>Selesai
                </span>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b border-gray-200">
            <div>
                <label class="text-sm font-medium text-gray-600 block mb-1">Tanggal Dibuat</label>
                <p class="text-gray-900">{{ $suratJalan->created_at->format('d F Y') }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-600 block mb-1">Disetujui Oleh</label>
                <p class="text-gray-900">{{ $suratJalan->approver->name }}</p>
            </div>
        </div>

        <!-- Informasi Kendaraan -->
        <div class="mb-6 pb-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kendaraan</h3>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-600 block mb-1">Nama Kendaraan</label>
                    <p class="text-gray-900 font-medium">{{ $suratJalan->kendaraan->nama_kendaraan }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600 block mb-1">Plat Nomor</label>
                    <p class="text-gray-900 font-medium">{{ $suratJalan->kendaraan->plat_nomor }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600 block mb-1">Jenis</label>
                    <p class="text-gray-900">{{ $suratJalan->kendaraan->jenis }}</p>
                </div>
            </div>
        </div>

        <!-- Informasi Pemohon -->
        <div class="mb-6 pb-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pemohon</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-600 block mb-1">Nama</label>
                    <p class="text-gray-900 font-medium">{{ $suratJalan->user->name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600 block mb-1">Email</label>
                    <p class="text-gray-900">{{ $suratJalan->user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Informasi Driver -->
        @if($suratJalan->driver)
        <div class="mb-6 pb-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Driver</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-600 block mb-1">Nama Driver</label>
                    <p class="text-gray-900 font-medium">{{ $suratJalan->driver->name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600 block mb-1">Email</label>
                    <p class="text-gray-900">{{ $suratJalan->driver->email }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Detail Perjalanan -->
        <div class="mb-6 pb-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Perjalanan</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-600 block mb-1">Keperluan</label>
                    <p class="text-gray-900">{{ $suratJalan->keperluan }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600 block mb-1">Tujuan</label>
                    <p class="text-gray-900">{{ $suratJalan->tujuan }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600 block mb-1">Tanggal Berangkat</label>
                        <p class="text-gray-900 font-medium">{{ $suratJalan->tanggal_berangkat->format('d F Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 block mb-1">Tanggal Kembali</label>
                        <p class="text-gray-900 font-medium">{{ $suratJalan->tanggal_kembali->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Penumpang -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Penumpang</h3>
            @if($suratJalan->penumpang)
            <div class="bg-gray-50 rounded-lg p-4">
                @php
                    $penumpangList = array_filter(array_map('trim', preg_split('/[\n,]+/', $suratJalan->penumpang)));
                @endphp
                <ul class="space-y-2">
                    @foreach($penumpangList as $index => $penumpang)
                    <li class="flex items-center text-gray-900">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                            {{ $index + 1 }}
                        </span>
                        {{ $penumpang }}
                    </li>
                    @endforeach
                </ul>
                <p class="text-sm text-gray-600 mt-4 pt-4 border-t border-gray-200">
                    <i class="fas fa-users mr-1"></i>
                    Total: <strong>{{ count($penumpangList) }} penumpang</strong>
                </p>
            </div>
            @else
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-500 text-center italic">
                    <i class="fas fa-info-circle mr-2"></i>
                    Data penumpang tidak tersedia
                </p>
            </div>
            @endif
        </div>

        @if($suratJalan->catatan)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <h4 class="font-medium text-yellow-900 mb-2">
                <i class="fas fa-sticky-note mr-2"></i>
                Catatan
            </h4>
            <p class="text-yellow-800 text-sm">{{ $suratJalan->catatan }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
