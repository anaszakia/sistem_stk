@extends('layouts.app')

@section('title', 'Edit Kendaraan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">Edit Kendaraan</h2>
                <a href="{{ route('kendaraan.index') }}" 
                   class="text-gray-600 hover:text-gray-900 transition duration-200">
                    <i class="fas fa-times text-lg"></i>
                </a>
            </div>
        </div>

        <form action="{{ route('kendaraan.update', $kendaraan) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="nama_kendaraan" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kendaraan <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nama_kendaraan" 
                       id="nama_kendaraan"
                       value="{{ old('nama_kendaraan', $kendaraan->nama_kendaraan) }}"
                       class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('nama_kendaraan') ? 'border-red-500' : 'border-gray-300' }}"
                       placeholder="Contoh: Toyota Avanza"
                       required>
                @error('nama_kendaraan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Kendaraan <span class="text-red-500">*</span>
                </label>
                <select name="jenis" 
                        id="jenis"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('jenis') ? 'border-red-500' : 'border-gray-300' }}"
                        required>
                    <option value="">Pilih Jenis Kendaraan</option>
                    <option value="Mobil" {{ old('jenis', $kendaraan->jenis) == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                    <option value="Motor" {{ old('jenis', $kendaraan->jenis) == 'Motor' ? 'selected' : '' }}>Motor</option>
                    <option value="Truk" {{ old('jenis', $kendaraan->jenis) == 'Truk' ? 'selected' : '' }}>Truk</option>
                    <option value="Bus" {{ old('jenis', $kendaraan->jenis) == 'Bus' ? 'selected' : '' }}>Bus</option>
                    <option value="Lainnya" {{ old('jenis', $kendaraan->jenis) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('jenis')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="plat_nomor" class="block text-sm font-medium text-gray-700 mb-2">
                    Plat Nomor <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="plat_nomor" 
                       id="plat_nomor"
                       value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}"
                       class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono uppercase {{ $errors->has('plat_nomor') ? 'border-red-500' : 'border-gray-300' }}"
                       placeholder="Contoh: B 1234 ABC"
                       style="text-transform: uppercase;"
                       required>
                @error('plat_nomor')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="pajak_stnk" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Pajak STNK
                </label>
                <input type="date" 
                       name="pajak_stnk" 
                       id="pajak_stnk"
                       value="{{ old('pajak_stnk', $kendaraan->pajak_stnk ? $kendaraan->pajak_stnk->format('Y-m-d') : '') }}"
                       class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('pajak_stnk') ? 'border-red-500' : 'border-gray-300' }}">
                @error('pajak_stnk')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ada atau belum diketahui</p>
            </div>

            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('kendaraan.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-500 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto uppercase plat nomor
    document.getElementById('plat_nomor').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });
</script>
@endsection