@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center">
        <!-- Success Icon -->
        <div class="w-24 h-24 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-8">
            <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-4xl"></i>
        </div>

        <!-- Success Message -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
            Test Drive Berhasil Diajukan!
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
            Terima kasih telah mengajukan test drive. Tim kami akan segera menghubungi Anda untuk konfirmasi dan detail lebih lanjut.
        </p>

        <!-- Test Drive Details -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center justify-center">
                <i class="fas fa-info-circle text-red-600 mr-2"></i>
                Detail Pengajuan
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Kode Tiket</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $code }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Nama</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Email</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Telepon</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ session('phone') ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Mobil</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ session('car_name') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal Test Drive</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ session('test_drive_date') ? \Carbon\Carbon::parse(session('test_drive_date'))->format('d M Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Waktu</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ session('test_drive_time') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            <i class="fas fa-clock mr-1"></i>
                            Menunggu Konfirmasi
                        </span>
                    </div>
                </div>
            </div>

            @if(session('message'))
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Pesan:</p>
                <p class="text-gray-900 dark:text-white italic">"{{ session('message') }}"</p>
            </div>
            @endif
        </div>

        <!-- Next Steps -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center justify-center">
                <i class="fas fa-list-check text-blue-600 mr-2"></i>
                Langkah Selanjutnya
            </h3>
            <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-white text-xs font-bold">1</span>
                    </div>
                    <div>
                        <p class="font-medium">Tim kami akan menghubungi Anda dalam 1-2 jam kerja</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-white text-xs font-bold">2</span>
                    </div>
                    <div>
                        <p class="font-medium">Konfirmasi jadwal dan lokasi test drive</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-white text-xs font-bold">3</span>
                    </div>
                    <div>
                        <p class="font-medium">Siapkan KTP dan SIM yang masih berlaku</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-white text-xs font-bold">4</span>
                    </div>
                    <div>
                        <p class="font-medium">Datang ke showroom sesuai jadwal yang ditentukan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-2xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center justify-center">
                <i class="fas fa-headset text-red-600 mr-2"></i>
                Butuh Bantuan?
            </h3>
            <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                <div class="flex items-center justify-center space-x-3">
                    <i class="fas fa-phone text-red-600"></i>
                    <span>+62 812-3456-7890</span>
                </div>
                <div class="flex items-center justify-center space-x-3">
                    <i class="fas fa-envelope text-red-600"></i>
                    <span>testdrive@autodealer.com</span>
                </div>
                <div class="flex items-center justify-center space-x-3">
                    <i class="fas fa-clock text-red-600"></i>
                    <span>Senin - Jumat: 09:00 - 17:00</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('cars.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg">
                <i class="fas fa-car mr-2"></i>
                Lihat Mobil Lain
            </a>
            <a href="{{ route('dashboard') }}" 
               class="inline-flex items-center px-6 py-3 border-2 border-red-500 text-red-600 dark:text-red-400 font-semibold rounded-xl hover:bg-red-500 hover:text-white transition-all duration-200">
                <i class="fas fa-home mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
