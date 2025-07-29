<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Mobil') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.cars.edit', $car) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.cars.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Gambar Mobil -->
                        <div>
                            @if($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="w-full h-64 object-cover rounded-lg shadow-lg">
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded-lg shadow-lg flex items-center justify-center">
                                    <i class="fas fa-car text-gray-400 text-6xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Informasi Mobil -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $car->name }}</h3>
                                <div class="flex items-center space-x-4">
                                    <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">
                                        {{ $car->type }}
                                    </span>
                                    <span class="px-3 py-1 {{ $car->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-sm font-medium rounded-full">
                                        {{ $car->stock > 0 ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Harga</h4>
                                    <p class="text-3xl font-bold text-red-600">Rp {{ number_format($car->price, 0, ',', '.') }}</p>
                                </div>

                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Stok</h4>
                                    <p class="text-xl font-medium {{ $car->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $car->stock }} unit
                                    </p>
                                </div>

                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h4>
                                    <p class="text-gray-700 leading-relaxed">{{ $car->description }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Tipe</h4>
                                        <p class="mt-1 text-lg text-gray-900">{{ $car->type }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Status</h4>
                                        <p class="mt-1 text-lg {{ $car->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $car->stock > 0 ? 'Tersedia' : 'Habis' }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Tanggal Ditambahkan</h4>
                                    <p class="mt-1 text-lg text-gray-900">{{ date('d/m/Y H:i', strtotime($car->created_at)) }}</p>
                                </div>

                                @if($car->updated_at != $car->created_at)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Terakhir Diupdate</h4>
                                    <p class="mt-1 text-lg text-gray-900">{{ date('d/m/Y H:i', strtotime($car->updated_at)) }}</p>
                                </div>
                                @endif
                            </div>

                            <!-- Statistik -->
                            <div class="border-t pt-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-blue-50 p-4 rounded-lg">
                                        <div class="text-2xl font-bold text-blue-600">
                                            {{ $car->testDrives()->count() }}
                                        </div>
                                        <div class="text-sm text-blue-600">Test Drive</div>
                                    </div>
                                    <div class="bg-green-50 p-4 rounded-lg">
                                        <div class="text-2xl font-bold text-green-600">
                                            {{ $car->purchases()->count() }}
                                        </div>
                                        <div class="text-sm text-green-600">Pembelian</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 