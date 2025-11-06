@extends('layouts.app')

@section('title', 'Surat Jalan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Surat Jalan</h1>
            <p class="text-gray-600 mt-1">Kelola surat jalan kendaraan operasional</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @php
            $allSuratJalan = auth()->user()->can('view all pemesanan') 
                ? \App\Models\SuratJalan::all() 
                : \App\Models\SuratJalan::where('user_id', auth()->id())->get();
        @endphp
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Total Surat Jalan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $allSuratJalan->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-car-side text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Sedang Berjalan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $allSuratJalan->where('status', 'aktif')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-check-double text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $allSuratJalan->where('status', 'selesai')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Daftar Surat Jalan</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($suratJalan as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-file-alt text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $item->nomor_surat }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $item->kendaraan->nama_kendaraan }}</div>
                            <div class="text-xs text-gray-500">{{ $item->kendaraan->plat_nomor }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $item->user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $item->keperluan }}</div>
                            <div class="text-xs text-gray-500">{{ Str::limit($item->tujuan, 30) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="text-gray-900">{{ $item->tanggal_berangkat->format('d/m/Y') }}</div>
                            <div class="text-gray-500 text-xs">s/d {{ $item->tanggal_kembali->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->status === 'aktif')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-car-side mr-1.5"></i>Sedang Berjalan
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
                                <a href="{{ route('surat-jalan.show', $item) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg transition-colors text-xs font-medium"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="{{ route('surat-jalan.print', $item) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 hover:bg-green-200 rounded-lg transition-colors text-xs font-medium"
                                   title="Print PDF">
                                    <i class="fas fa-print"></i>
                                </a>
                                
                                <a href="{{ route('surat-jalan.download', $item) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-purple-100 text-purple-700 hover:bg-purple-200 rounded-lg transition-colors text-xs font-medium"
                                   title="Download PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-file-alt text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium mb-1">Belum ada surat jalan</p>
                                <p class="text-gray-400 text-sm">Surat jalan akan otomatis dibuat saat pemesanan disetujui</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suratJalan->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $suratJalan->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
