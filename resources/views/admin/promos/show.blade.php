<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Promo') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.promos.edit', $promo) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.promos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Header Promo -->
                        <div class="border-b pb-6">
                            <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $promo->title }}</h3>
                            <div class="flex items-center space-x-4">
                                <span class="px-4 py-2 bg-red-100 text-red-800 text-lg font-semibold rounded-full">
                                    {{ $promo->discount_percentage }}% OFF
                                </span>
                                <span class="px-4 py-2 {{ $promo->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-lg font-semibold rounded-full">
                                    {{ $promo->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>

                        <!-- Informasi Promo -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h4>
                                    <p class="text-gray-700 leading-relaxed">{{ $promo->description }}</p>
                                </div>

                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Periode Promo</h4>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Mulai:</span>
                                            <span class="font-medium">{{ date('d/m/Y', strtotime($promo->start_date)) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Berakhir:</span>
                                            <span class="font-medium">{{ date('d/m/Y', strtotime($promo->end_date)) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Durasi:</span>
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($promo->start_date)->diffInDays($promo->end_date) + 1 }} hari</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Status</h4>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Status Aktif:</span>
                                            <span class="font-medium {{ $promo->is_active ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $promo->is_active ? 'Ya' : 'Tidak' }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Status Periode:</span>
                                            @php
                                                $now = now();
                                                $startDate = \Carbon\Carbon::parse($promo->start_date);
                                                $endDate = \Carbon\Carbon::parse($promo->end_date);
                                                
                                                if ($now < $startDate) {
                                                    $periodStatus = 'Belum Mulai';
                                                    $statusColor = 'text-yellow-600';
                                                } elseif ($now >= $startDate && $now <= $endDate) {
                                                    $periodStatus = 'Sedang Berlangsung';
                                                    $statusColor = 'text-green-600';
                                                } else {
                                                    $periodStatus = 'Sudah Berakhir';
                                                    $statusColor = 'text-red-600';
                                                }
                                            @endphp
                                            <span class="font-medium {{ $statusColor }}">{{ $periodStatus }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Informasi Diskon</h4>
                                    <div class="bg-red-50 p-6 rounded-lg">
                                        <div class="text-center">
                                            <div class="text-4xl font-bold text-red-600 mb-2">
                                                {{ $promo->discount_percentage }}%
                                            </div>
                                            <div class="text-red-700 font-medium">Diskon</div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Informasi Sistem</h4>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Dibuat:</span>
                                            <span class="font-medium">{{ date('d/m/Y H:i', strtotime($promo->created_at)) }}</span>
                                        </div>
                                        @if($promo->updated_at != $promo->created_at)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Diupdate:</span>
                                            <span class="font-medium">{{ date('d/m/Y H:i', strtotime($promo->updated_at)) }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Timeline Status -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Timeline Status</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full {{ $now >= $startDate ? 'bg-green-500' : 'bg-gray-300' }} mr-3"></div>
                                            <span class="text-sm {{ $now >= $startDate ? 'text-green-600' : 'text-gray-500' }}">Promo Dimulai</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full {{ $now >= $startDate && $now <= $endDate ? 'bg-green-500' : 'bg-gray-300' }} mr-3"></div>
                                            <span class="text-sm {{ $now >= $startDate && $now <= $endDate ? 'text-green-600' : 'text-gray-500' }}">Sedang Berlangsung</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full {{ $now > $endDate ? 'bg-red-500' : 'bg-gray-300' }} mr-3"></div>
                                            <span class="text-sm {{ $now > $endDate ? 'text-red-600' : 'text-gray-500' }}">Promo Berakhir</span>
                                        </div>
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