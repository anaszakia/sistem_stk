@extends('layouts.app')

@section('title', 'Tambah Kendaraan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Tambah Kendaraan Baru</h1>
            <p class="text-gray-600 mt-1">Isi formulir di bawah untuk menambahkan kendaraan baru</p>
        </div>
        <a href="{{ route('kendaraan.index') }}" 
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

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <i class="fas fa-car text-blue-600 mr-2"></i>
                Informasi Kendaraan
            </h3>
        </div>

        <form action="{{ route('kendaraan.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Nama Kendaraan -->
                <div>
                    <label for="nama_kendaraan" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-car text-gray-400 mr-1"></i>
                        Nama Kendaraan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama_kendaraan" 
                           id="nama_kendaraan"
                           value="{{ old('nama_kendaraan') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_kendaraan') border-red-500 @enderror"
                           placeholder="Contoh: Toyota Avanza"
                           required>
                    @error('nama_kendaraan')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Jenis Kendaraan -->
                <div>
                    <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag text-gray-400 mr-1"></i>
                        Jenis Kendaraan <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis" 
                            id="jenis"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jenis') border-red-500 @enderror"
                            required>
                        <option value="">-- Pilih Jenis Kendaraan --</option>
                        <option value="Mobil" {{ old('jenis') == 'Mobil' ? 'selected' : '' }}>🚗 Mobil</option>
                        <option value="Motor" {{ old('jenis') == 'Motor' ? 'selected' : '' }}>🏍️ Motor</option>
                        <option value="Truk" {{ old('jenis') == 'Truk' ? 'selected' : '' }}>🚚 Truk</option>
                        <option value="Bus" {{ old('jenis') == 'Bus' ? 'selected' : '' }}>🚌 Bus</option>
                        <option value="Lainnya" {{ old('jenis') == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                    </select>
                    @error('jenis')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Plat Nomor -->
                <div>
                    <label for="plat_nomor" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-id-card text-gray-400 mr-1"></i>
                        Plat Nomor <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="plat_nomor" 
                           id="plat_nomor"
                           value="{{ old('plat_nomor') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-lg font-bold uppercase @error('plat_nomor') border-red-500 @enderror"
                           placeholder="Contoh: B 1234 ABC"
                           style="text-transform: uppercase;"
                           required>
                    @error('plat_nomor')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Format: Kode Area + Nomor + Kode Seri (contoh: B 1234 ABC)</p>
                </div>

                <!-- Pajak STNK -->
                <div>
                    <label for="pajak_stnk" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt text-gray-400 mr-1"></i>
                        Tanggal Jatuh Tempo Pajak STNK
                    </label>
                    <input type="date" 
                           name="pajak_stnk" 
                           id="pajak_stnk"
                           value="{{ old('pajak_stnk') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('pajak_stnk') border-red-500 @enderror">
                    @error('pajak_stnk')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Opsional - Kosongkan jika tidak ada atau belum diketahui
                    </p>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-blue-500 mr-2 mt-0.5"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Tips:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Pastikan plat nomor ditulis dengan benar dan sesuai STNK</li>
                                <li>Tanggal pajak STNK membantu mengingatkan masa berlaku pajak kendaraan</li>
                                <li>Semua field bertanda (*) wajib diisi</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('kendaraan.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center shadow-sm">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Kendaraan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto uppercase plat nomor
    document.getElementById('plat_nomor').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });
    
    // Set min date for pajak_stnk to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('pajak_stnk').setAttribute('min', today);
</script>
@endsection