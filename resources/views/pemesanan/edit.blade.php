@extends('layouts.app')

@section('title', 'Edit Pemesanan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Edit Pemesanan</h1>
            <p class="text-gray-600 mt-1">Perbarui informasi pemesanan kendaraan</p>
        </div>
        <a href="{{ route('pemesanan.index') }}" 
           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-500 mr-2 mt-0.5"></i>
                <div>
                    <h3 class="text-red-800 font-medium mb-1">Ada kesalahan pada input:</h3>
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if($pemesanan->status !== 'pending')
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                <span class="text-yellow-800">Pemesanan dengan status "{{ ucfirst($pemesanan->status) }}" tidak dapat diubah.</span>
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <i class="fas fa-edit text-yellow-600 mr-2"></i>
                Edit Pemesanan Kendaraan
            </h3>
        </div>

        <form action="{{ route('pemesanan.update', $pemesanan) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Pilih Kendaraan -->
                <div>
                    <label for="kendaraan_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-car text-gray-400 mr-1"></i>
                        Pilih Kendaraan <span class="text-red-500">*</span>
                    </label>
                    <select name="kendaraan_id" 
                            id="kendaraan_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kendaraan_id') border-red-500 @enderror"
                            required>
                        <option value="">-- Pilih Kendaraan yang Tersedia --</option>
                        @foreach($kendaraan as $item)
                            <option value="{{ $item->id }}" {{ old('kendaraan_id', $pemesanan->kendaraan_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kendaraan }} - {{ $item->plat_nomor }} ({{ $item->jenis }})
                            </option>
                        @endforeach
                    </select>
                    @error('kendaraan_id')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Keperluan -->
                <div>
                    <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-clipboard-list text-gray-400 mr-1"></i>
                        Keperluan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="keperluan" 
                           id="keperluan"
                           value="{{ old('keperluan', $pemesanan->keperluan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('keperluan') border-red-500 @enderror"
                           placeholder="Contoh: Kunjungan ke client, Meeting eksternal, dll"
                           required>
                    @error('keperluan')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Tujuan -->
                <div>
                    <label for="tujuan" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                        Tujuan/Lokasi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="tujuan" 
                              id="tujuan"
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tujuan') border-red-500 @enderror"
                              placeholder="Tuliskan alamat lengkap atau lokasi tujuan"
                              required>{{ old('tujuan', $pemesanan->tujuan) }}</textarea>
                    @error('tujuan')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Penumpang -->
                <div>
                    <label for="penumpang" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-users text-gray-400 mr-1"></i>
                        Daftar Penumpang <span class="text-red-500">*</span>
                    </label>
                    <textarea name="penumpang" 
                              id="penumpang"
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('penumpang') border-red-500 @enderror"
                              placeholder="Tuliskan nama-nama karyawan yang akan menumpang, pisahkan dengan enter atau koma&#10;Contoh:&#10;John Doe&#10;Jane Smith&#10;Ahmad Subarjo"
                              required>{{ old('penumpang', $pemesanan->penumpang) }}</textarea>
                    @error('penumpang')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Tuliskan nama lengkap setiap penumpang, satu baris per orang atau dipisah dengan koma
                    </p>
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-day text-gray-400 mr-1"></i>
                        Tanggal & Waktu Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" 
                           name="tanggal_mulai" 
                           id="tanggal_mulai"
                           value="{{ old('tanggal_mulai', $pemesanan->tanggal_mulai->format('Y-m-d\TH:i')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_mulai') border-red-500 @enderror"
                           required>
                    @error('tanggal_mulai')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Tanggal Selesai -->
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-check text-gray-400 mr-1"></i>
                        Tanggal & Waktu Selesai <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" 
                           name="tanggal_selesai" 
                           id="tanggal_selesai"
                           value="{{ old('tanggal_selesai', $pemesanan->tanggal_selesai->format('Y-m-d\TH:i')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_selesai') border-red-500 @enderror"
                           required>
                    @error('tanggal_selesai')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-yellow-600 mr-2 mt-0.5"></i>
                        <div class="text-sm text-yellow-800">
                            <p class="font-medium mb-1">Informasi:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Pemesanan dibuat: {{ $pemesanan->created_at->format('d M Y, H:i') }}</li>
                                <li>Status saat ini: <strong>{{ ucfirst($pemesanan->status) }}</strong></li>
                                <li>Perubahan hanya dapat dilakukan jika status masih "Pending"</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('pemesanan.show', $pemesanan) }}" 
                       class="text-gray-600 hover:text-gray-900 transition-colors flex items-center">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat Detail
                    </a>
                    <div class="flex space-x-3">
                        <a href="{{ route('pemesanan.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center shadow-sm"
                                @if($pemesanan->status !== 'pending') disabled @endif>
                            <i class="fas fa-save mr-2"></i>
                            Update Pemesanan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Set minimum date to today
    const today = new Date().toISOString().slice(0, 16);
    document.getElementById('tanggal_mulai').setAttribute('min', today);
    
    // Update minimum end date when start date changes
    document.getElementById('tanggal_mulai').addEventListener('change', function() {
        document.getElementById('tanggal_selesai').setAttribute('min', this.value);
    });
</script>
@endsection
