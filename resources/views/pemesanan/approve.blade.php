@extends('layouts.app')

@section('title', 'Pilih Driver')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Setujui Pemesanan</h1>
            <p class="text-gray-600 mt-1">Pilih driver yang akan mengoperasikan kendaraan</p>
        </div>
        <a href="{{ route('pemesanan.show', $pemesanan) }}" 
           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <!-- Informasi Pemesanan -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-4">
            <i class="fas fa-info-circle mr-2"></i>
            Detail Pemesanan
        </h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-blue-700 font-medium">Kendaraan:</span>
                <p class="text-blue-900">{{ $pemesanan->kendaraan->nama_kendaraan }} ({{ $pemesanan->kendaraan->plat_nomor }})</p>
            </div>
            <div>
                <span class="text-blue-700 font-medium">Pemohon:</span>
                <p class="text-blue-900">{{ $pemesanan->user->name }}</p>
            </div>
            <div>
                <span class="text-blue-700 font-medium">Keperluan:</span>
                <p class="text-blue-900">{{ $pemesanan->keperluan }}</p>
            </div>
            <div>
                <span class="text-blue-700 font-medium">Tujuan:</span>
                <p class="text-blue-900">{{ Str::limit($pemesanan->tujuan, 40) }}</p>
            </div>
            <div>
                <span class="text-blue-700 font-medium">Tanggal:</span>
                <p class="text-blue-900">{{ $pemesanan->tanggal_mulai->format('d/m/Y') }} - {{ $pemesanan->tanggal_selesai->format('d/m/Y') }}</p>
            </div>
            @if($pemesanan->penumpang)
            <div>
                <span class="text-blue-700 font-medium">Penumpang:</span>
                @php
                    $penumpangCount = count(array_filter(array_map('trim', preg_split('/[\n,]+/', $pemesanan->penumpang))));
                @endphp
                <p class="text-blue-900">{{ $penumpangCount }} orang</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Form Pilih Driver -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <i class="fas fa-user-tie text-green-600 mr-2"></i>
                Pilih Driver
            </h3>
        </div>

        <form action="{{ route('pemesanan.approve', $pemesanan) }}" method="POST" class="p-6">
            @csrf
            
            @if($drivers->isEmpty())
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-0.5"></i>
                        <div class="text-sm text-yellow-800">
                            <p class="font-medium mb-1">Tidak ada driver tersedia</p>
                            <p>Silakan tambahkan user dengan role "Driver" terlebih dahulu di menu User Management.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-id-card text-gray-400 mr-1"></i>
                        Pilih Driver <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($drivers as $driver)
                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:bg-gray-50 {{ old('driver_id') == $driver->id ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                            <input type="radio" 
                                   name="driver_id" 
                                   value="{{ $driver->id }}" 
                                   class="w-4 h-4 text-green-600 focus:ring-green-500"
                                   {{ old('driver_id') == $driver->id ? 'checked' : '' }}
                                   required>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $driver->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $driver->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <i class="fas fa-check-circle text-green-500 text-xl {{ old('driver_id') == $driver->id ? '' : 'hidden' }}"></i>
                        </label>
                        @endforeach
                    </div>
                    
                    @error('driver_id')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mt-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-gray-500 mr-2 mt-0.5"></i>
                        <div class="text-sm text-gray-700">
                            <p class="font-medium mb-1">Catatan:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Driver yang dipilih akan tercantum dalam Surat Jalan</li>
                                <li>Surat Jalan akan dibuat otomatis setelah pemesanan disetujui</li>
                                <li>Status kendaraan akan berubah menjadi "Terpakai"</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 mt-6">
                    <a href="{{ route('pemesanan.show', $pemesanan) }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center shadow-sm">
                        <i class="fas fa-check mr-2"></i>
                        Setujui Pemesanan
                    </button>
                </div>
            @endif
        </form>
    </div>
</div>

<script>
    // Add visual feedback when radio button is selected
    document.querySelectorAll('input[name="driver_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove all selected styles
            document.querySelectorAll('label[for], label:has(input[name="driver_id"])').forEach(label => {
                label.classList.remove('border-green-500', 'bg-green-50');
                label.classList.add('border-gray-200');
                const checkIcon = label.querySelector('.fa-check-circle');
                if (checkIcon) checkIcon.classList.add('hidden');
            });
            
            // Add selected style to chosen option
            const parentLabel = this.closest('label');
            parentLabel.classList.remove('border-gray-200');
            parentLabel.classList.add('border-green-500', 'bg-green-50');
            const checkIcon = parentLabel.querySelector('.fa-check-circle');
            if (checkIcon) checkIcon.classList.remove('hidden');
        });
    });
</script>
@endsection
