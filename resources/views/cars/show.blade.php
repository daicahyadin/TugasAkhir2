@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('cars.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400">
                    <i class="fas fa-car mr-2"></i>
                    Mobil
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $car->name }}</span>
                </div>
            </li>
        </ol>
    </nav>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Car Images -->
        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <img src="{{ $car->image ? asset('storage/'.$car->image) : 'https://via.placeholder.com/600x400?text=No+Image' }}"
                     alt="{{ $car->name }}"
                     class="w-full h-96 object-cover">
                @if(isset($car->promo) && $car->promo && $car->promo->discount_percentage > 0)
                    <span class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-4 py-2 rounded shadow-lg z-10">PROMO {{ $car->promo->discount_percentage }}%</span>
                @endif
            </div>
            <!-- Galeri Gambar Tambahan -->
            @if($car->images)
            <div class="grid grid-cols-4 gap-4">
                @foreach(json_decode($car->images, true) as $img)
                <img src="{{ asset('storage/'.$img) }}" alt="Galeri {{ $car->name }}" class="h-24 w-full object-cover rounded-lg">
                @endforeach
            </div>
            @endif
        </div>
        <!-- Car Details -->
        <div class="space-y-6">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $car->name }}</h1>
                    <span class="px-3 py-1 bg-red-500 text-white text-sm font-medium rounded-full">
                        {{ $car->type }}
                    </span>
                </div>
                <div class="flex items-center gap-4 mb-2">
                    @if(isset($car->promo) && $car->promo && $car->promo->discount_percentage > 0)
                        <span class="text-gray-400 line-through text-lg">Rp {{ number_format($car->price, 0, ',', '.') }}</span>
                        <span class="text-red-600 font-bold text-2xl">Rp {{ number_format($car->price * (1 - $car->promo->discount_percentage/100), 0, ',', '.') }}</span>
                    @else
                        <span class="text-red-600 font-bold text-2xl">Rp {{ number_format($car->price, 0, ',', '.') }}</span>
                    @endif
                </div>
                <p class="text-gray-600 mb-4">{{ $car->description ?? 'Deskripsi tidak tersedia' }}</p>
            </div>
            <!-- Spesifikasi -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-cogs text-red-600 mr-2"></i>
                    Spesifikasi
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-gas-pump text-red-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Bahan Bakar</p>
                            <p class="font-medium text-gray-900">{{ $car->fuel ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cog text-red-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Transmisi</p>
                            <p class="font-medium text-gray-900">{{ $car->transmission ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar text-red-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tahun</p>
                            <p class="font-medium text-gray-900">{{ $car->year ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-road text-red-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kilometer</p>
                            <p class="font-medium text-gray-900">{{ $car->kilometer ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="flex flex-col gap-3">
                <a href="{{ route('testdrive.form', $car->id) }}" class="bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-semibold text-center transition"><i class="fas fa-road mr-2"></i>Booking Test Drive</a>
                <a href="{{ route('beli.form', $car->id) }}" class="bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-semibold text-center transition"><i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang</a>
            </div>
            <!-- Kontak Tim -->
            <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-phone text-red-600 mr-2"></i>
                    Hubungi Kami
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-phone text-red-600"></i>
                        <span class="text-gray-700">+62 812-3456-7890</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-red-600"></i>
                        <span class="text-gray-700">info@autodealer.com</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-map-marker-alt text-red-600"></i>
                        <span class="text-gray-700">Jl. Sudirman No. 123, Jakarta</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
