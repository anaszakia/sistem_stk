@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Edit Permission</h1>
            <p class="text-gray-600 mt-1">Ubah informasi permission</p>
        </div>
        <a href="{{ route('permissions.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
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
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <i class="fas fa-key text-purple-600 mr-2"></i>
                Edit Permission: {{ ucwords(str_replace('_', ' ', $permission->name)) }}
            </h3>
        </div>
        
        <form action="{{ route('permissions.update', $permission) }}" method="POST" class="px-6 py-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Permission Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Permission <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $permission->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('name') border-red-500 @enderror"
                        placeholder="Contoh: view_users, edit_posts"
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        Gunakan snake_case (huruf kecil dengan underscore). Contoh: view_users, edit_kendaraan
                    </p>
                </div>

                <!-- Guard Name -->
                <div>
                    <label for="guard_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Guard Name
                    </label>
                    <input 
                        type="text" 
                        name="guard_name" 
                        id="guard_name" 
                        value="{{ old('guard_name', $permission->guard_name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-gray-50"
                        readonly
                    >
                    <p class="mt-1 text-xs text-gray-500">
                        Guard name tidak dapat diubah. Default: web
                    </p>
                </div>

                <!-- Assign to Roles -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Assign ke Role (Opsional)
                    </label>
                    <div class="space-y-2 border border-gray-200 rounded-lg p-4 max-h-64 overflow-y-auto">
                        @forelse($roles as $role)
                            <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer transition-colors">
                                <input 
                                    type="checkbox" 
                                    name="roles[]" 
                                    value="{{ $role->id }}"
                                    class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                                    {{ $permission->roles->contains($role->id) ? 'checked' : '' }}
                                >
                                <div class="ml-3 flex items-center flex-1">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center mr-2
                                        @if($role->name === 'super_admin') bg-red-100
                                        @elseif($role->name === 'admin') bg-blue-100
                                        @else bg-gray-100
                                        @endif">
                                        <i class="fas @if($role->name === 'super_admin') fa-crown text-red-600
                                            @elseif($role->name === 'admin') fa-user-shield text-blue-600
                                            @else fa-user text-gray-600
                                            @endif text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                        </span>
                                        <span class="text-xs text-gray-500 ml-2">
                                            ({{ $role->permissions->count() }} permissions)
                                        </span>
                                    </div>
                                </div>
                            </label>
                        @empty
                            <p class="text-gray-500 text-sm text-center py-4">Tidak ada role tersedia</p>
                        @endforelse
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        Pilih role yang akan memiliki permission ini
                    </p>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mr-2 mt-0.5"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Informasi Permission:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Permission dibuat: {{ $permission->created_at->format('d M Y, H:i') }}</li>
                                <li>Terakhir diupdate: {{ $permission->updated_at->format('d M Y, H:i') }}</li>
                                <li>Saat ini dimiliki oleh {{ $permission->roles->count() }} role</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <a href="{{ route('permissions.show', $permission) }}" class="text-gray-600 hover:text-gray-900 transition-colors">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat Detail
                    </a>
                    <div class="flex gap-3">
                        <a href="{{ route('permissions.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Update Permission
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    
    // Validate name format (snake_case)
    const snakeCaseRegex = /^[a-z]+(_[a-z]+)*$/;
    if (!snakeCaseRegex.test(name)) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Format Tidak Valid',
            text: 'Nama permission harus menggunakan format snake_case (huruf kecil dengan underscore)',
            confirmButtonColor: '#9333ea'
        });
        return false;
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
