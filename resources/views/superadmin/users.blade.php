@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    <form method="GET" action="{{ route('superadmin.users.index') }}" class="mb-4 flex">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="border rounded px-3 py-2 mr-2 w-64">
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold">Cari</button>
    </form>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-red-700">Kelola User</h1>
        <!-- Tombol Tambah User -->
        <button onclick="document.getElementById('addUserModal').classList.remove('hidden')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold shadow">Tambah User</button>
    </div>
    <!-- Tabel User -->
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-red-200">
            <thead class="bg-red-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-red-100">
                @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @foreach($user->roles as $role)
                            <span class="inline-block bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold mr-1">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <!-- Tombol Edit -->
                        <button onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->roles->pluck('name')->first() }}')" class="text-blue-600 hover:text-blue-900 font-semibold mr-2">Edit</button>
                        <!-- Tombol Hapus -->
                        <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

<!-- Modal Tambah User -->
<div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <button onclick="document.getElementById('addUserModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-red-600">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-red-700">Tambah User</h2>
        @if($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('superadmin.users.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Nama</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2 mt-1" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2 mt-1" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2 mt-1" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2 mt-1" required>
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit User (akan diisi via JS) -->
<div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <button onclick="document.getElementById('editUserModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-red-600">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-red-700">Edit User</h2>
        @if($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700">Nama</label>
                <input type="text" name="name" id="editName" class="w-full border rounded px-3 py-2 mt-1" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" id="editEmail" class="w-full border rounded px-3 py-2 mt-1" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" id="editPassword" class="w-full border rounded px-3 py-2 mt-1">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Role</label>
                <select name="role" id="editRole" class="w-full border rounded px-3 py-2 mt-1" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name, email, role) {
    document.getElementById('editUserModal').classList.remove('hidden');
    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editRole').value = role;
    document.getElementById('editPassword').value = '';
    document.getElementById('editUserForm').action = '/superadmin/users/' + id;
}
</script>
@endsection 