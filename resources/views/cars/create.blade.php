@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white rounded-xl shadow-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Tambah Mobil</h2>
    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nama Mobil</label>
            <input type="text" name="name" class="input w-full" required>
        </div>
        <div class="mb-3">
            <label>Tipe</label>
            <input type="text" name="type" class="input w-full" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price" class="input w-full" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stock" class="input w-full" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="input w-full" required></textarea>
        </div>
        <div class="mb-3">
            <label>Foto Mobil</label>
            <input type="file" name="image" class="input w-full">
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
