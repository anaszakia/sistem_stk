@extends('layouts.app')

@section('title', 'Detail Permission')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Detail Permission</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap permission</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('permissions.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
            @can('edit permissions')
                <a href="{{ route('permissions.edit', $permission) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
            @endcan
            @can('delete permissions')
                <button onclick="deletePermission()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus
                </button>
            @endcan
        </div>
    </div>

    <!-- Permission Info Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-key text-purple-600"></i>
                </div>
                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
            </h3>
        </div>
        
        <div class="px-6 py-6 space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Permission</label>
                    <p class="text-gray-900 font-medium">{{ $permission->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Guard Name</label>
                    <p class="text-gray-900 font-medium">{{ $permission->guard_name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Created At</label>
                    <p class="text-gray-900">{{ $permission->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Updated At</label>
                    <p class="text-gray-900">{{ $permission->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <!-- Roles that have this permission -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-3">Role yang Memiliki Permission Ini</label>
                @if($permission->roles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($permission->roles as $role)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3
                                            @if($role->name === 'super_admin') bg-red-100
                                            @elseif($role->name === 'admin') bg-blue-100
                                            @else bg-gray-100
                                            @endif">
                                            <i class="fas @if($role->name === 'super_admin') fa-crown text-red-600
                                                @elseif($role->name === 'admin') fa-user-shield text-blue-600
                                                @else fa-user text-gray-600
                                                @endif"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">
                                                {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                            </h4>
                                            <p class="text-xs text-gray-500">{{ $role->permissions->count() }} permissions</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                        <i class="fas fa-user-slash text-gray-300 text-3xl mb-2"></i>
                        <p class="text-gray-500">Permission ini belum diberikan ke role manapun</p>
                    </div>
                @endif
            </div>

            <!-- Users with this permission directly -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-3">User yang Memiliki Permission Ini (Langsung)</label>
                @if($permission->users->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($permission->users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                                </div>
                                                <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($user->roles as $userRole)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                        @if($userRole->name === 'super_admin') bg-red-100 text-red-800
                                                        @elseif($userRole->name === 'admin') bg-blue-100 text-blue-800
                                                        @else bg-gray-100 text-gray-800
                                                        @endif">
                                                        {{ ucwords(str_replace('_', ' ', $userRole->name)) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                        <i class="fas fa-users-slash text-gray-300 text-3xl mb-2"></i>
                        <p class="text-gray-500">Tidak ada user yang memiliki permission ini secara langsung</p>
                        <p class="text-xs text-gray-400 mt-1">User biasanya mendapat permission melalui role mereka</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<form id="delete-form" action="{{ route('permissions.destroy', $permission) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deletePermission() {
    Swal.fire({
        title: 'Hapus Permission?',
        text: `Apakah Anda yakin ingin menghapus permission "{{ $permission->name }}"? Tindakan ini tidak dapat dibatalkan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form').submit();
        }
    });
}
</script>
@endsection
