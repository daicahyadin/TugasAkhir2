@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center space-x-2">
                    <i class="fas fa-car text-red-600"></i>
                    <span>Daftar Mobil</span>
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Kelola semua data mobil dalam sistem</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.cars.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-lg hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Mobil
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <form method="GET" action="" class="flex flex-col md:flex-row gap-4 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari mobil..." class="border rounded px-3 py-2 w-full md:w-1/3">
        <select name="type" class="border rounded px-3 py-2 w-full md:w-1/4">
            <option value="">Semua Tipe</option>
            @foreach($types ?? [] as $type)
                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select>
        <select name="sort" class="border rounded px-3 py-2 w-full md:w-1/4">
            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
        </select>
        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold" type="submit">Filter</button>
    </form>
    <!-- Cars Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($cars as $car)
        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 flex flex-col">
            <div class="relative">
                <img src="{{ $car->image ? asset('storage/'.$car->image) : 'https://via.placeholder.com/400x300?text=No+Image' }}"
                     alt="{{ $car->name }}" class="w-full h-48 object-cover rounded-t-xl">
                @if($car->hasActivePromo())
                    <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded shadow">PROMO</span>
                @endif
            </div>
            <div class="p-4 flex-1 flex flex-col">
                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $car->name }}</h3>
                <p class="text-sm text-gray-500 mb-2">{{ $car->type }}</p>
                <div class="mb-2">
                    @if($car->hasActivePromo())
                        <span class="text-gray-400 line-through text-sm">Rp {{ number_format($car->price, 0, ',', '.') }}</span>
                        <span class="text-red-600 font-bold text-lg ml-2">Rp {{ number_format($car->discounted_price, 0, ',', '.') }}</span>
                        <span class="ml-2 bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded">Diskon {{ $car->promo->discount_percentage }}%</span>
                    @else
                        <span class="text-red-600 font-bold text-lg">Rp {{ number_format($car->price, 0, ',', '.') }}</span>
                    @endif
                </div>
                <div class="flex flex-col gap-2 mt-auto">
                    <a href="{{ route('cars.show', $car->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 rounded font-semibold text-center transition">Lihat Detail</a>
                    @auth
                        @if(auth()->user()->hasRole('customer'))
                            <a href="{{ route('testdrive.form', $car->id) }}" class="bg-green-500 hover:bg-green-600 text-white py-2 rounded font-semibold text-center transition">Booking Test Drive</a>
                            <a href="{{ route('beli.form', $car->id) }}" class="bg-red-600 hover:bg-red-700 text-white py-2 rounded font-semibold text-center transition">Beli</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-700 text-white py-2 rounded font-semibold text-center transition">Login untuk Beli</a>
                        <a href="{{ route('login') }}" class="bg-green-500 hover:bg-green-600 text-white py-2 rounded font-semibold text-center transition">Login untuk Test Drive</a>
                    @endauth
                    <span class="block mt-2 text-sm text-gray-600">Stok: <span class="font-bold {{ $car->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $car->stock }}</span></span>
                    @auth
                        @if(auth()->user()->hasRole('admin') && request()->is('admin/cars'))
                            <div class="flex flex-wrap gap-2 items-center mt-3">
                                <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus mobil ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-2 px-3 rounded font-semibold text-center transition">Hapus</button>
                                </form>
                                <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" class="flex items-center gap-1">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="stock" value="{{ $car->stock }}" min="0" class="w-16 px-2 py-1 border rounded text-sm">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded font-semibold text-sm">Simpan</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if($cars->count() == 0)
    <div class="text-center py-12">
        <div class="w-24 h-24 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-car text-red-600 dark:text-red-400 text-3xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada mobil</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Mobil belum tersedia saat ini.</p>
    </div>
    @endif
</div>
@endsection
