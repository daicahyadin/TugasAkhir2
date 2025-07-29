@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-16 text-center">
    <div class="text-green-500 text-6xl mb-4">
        <i class="fas fa-check-circle"></i>
    </div>
    <h1 class="text-2xl font-bold mb-2">Pengajuan Pembelian Terkirim!</h1>
    <p class="text-gray-700 mb-6">
        Pengajuan pembelian Anda telah berhasil dikirim.<br>
        Silakan tunggu konfirmasi dari admin melalui dashboard atau WhatsApp.
    </p>
    <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Kembali ke Dashboard</a>
</div>
@endsection 