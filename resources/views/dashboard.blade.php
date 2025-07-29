@extends('layouts.app')

@section('content')
<div class="py-10 bg-gradient-to-br from-red-50 via-white to-red-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
    <div class="max-w-screen-xl w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Notifikasi Status -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Sukses!</strong> <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Gagal!</strong> <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-2xl shadow-xl p-6 text-white flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="text-red-100">Nikmati layanan pembelian, test drive, dan promo mobil terbaik dari kami.</p>
            </div>
            <i class="fas fa-car text-5xl md:text-6xl text-red-200 hidden md:block"></i>
        </div>
        <!-- Judul besar dan subjudul -->
        <div class="mt-20 mb-10 text-center">
            <h2 class="text-4xl md:text-5xl font-black tracking-tight text-red-600 mb-2 drop-shadow font-sans">Promo, Event & News Terbaru</h2>
            <p class="text-lg md:text-xl font-bold text-red-500 font-sans">Dapatkan info terbaru dari kami!</p>
        </div>
        <!-- Grid 3 kolom kategori, 1 card per kategori -->
        <div class="w-full max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 mb-32">
            <!-- PROMO -->
            <div class="flex flex-col items-center">
                <div class="flex items-center mb-6">
                    <i class="fas fa-tags text-2xl text-red-500 mr-2"></i>
                    <h3 class="text-2xl font-bold text-red-500 uppercase">Promo</h3>
                </div>
                @if($promos->count())
                @php $promo = $promos->first(); @endphp
                <div class="relative group bg-gradient-to-br from-red-50/80 via-white/90 to-red-100/80 dark:from-gray-900/80 dark:via-gray-800/90 dark:to-gray-900/80 rounded-3xl shadow-2xl overflow-hidden flex flex-col min-h-[250px] w-full max-w-md animate-fade-in">
                    @if($promo->image)
                    <img src="{{ asset('storage/' . $promo->image) }}" alt="Poster Promo" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300 rounded-t-3xl">
                    @endif
                    <div class="p-6 flex-1 flex flex-col">
                        <h4 class="text-xl font-bold text-gray-200 mb-2 group-hover:underline transition-all">{{ $promo->title }}</h4>
                        <p class="text-gray-300 text-base mb-2 flex-1">{{ Str::limit($promo->description, 80) }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="inline-block bg-red-100 text-red-700 px-4 py-2 rounded-full text-base font-semibold animate-pulse shadow">Diskon {{ $promo->discount_percentage }}%</span>
                            <span class="text-sm text-gray-400">{{ date('d M Y', strtotime($promo->start_date)) }} - {{ date('d M Y', strtotime($promo->end_date)) }}</span>
                        </div>
                    </div>
                    <span class="absolute top-4 left-4 bg-gradient-to-r from-red-500 to-yellow-400 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg animate-bounce">HOT</span>
                </div>
                @else
                <div class="text-gray-400 text-center py-16 w-full max-w-md bg-white/10 rounded-2xl shadow">Belum ada promo</div>
                @endif
            </div>
            <!-- EVENT -->
            <div class="flex flex-col items-center">
                <div class="flex items-center mb-6">
                    <i class="fas fa-calendar-alt text-2xl text-blue-500 mr-2" style="color: #3b82f6 !important;"></i>
                    <h3 class="text-2xl font-bold uppercase" style="color: #3b82f6 !important;">Event</h3>
                </div>
                @if($events->count())
                @php $event = $events->first(); @endphp
                <div class="relative group bg-gradient-to-br from-blue-50/80 via-white/90 to-blue-100/80 dark:from-blue-900/80 dark:via-gray-800/90 dark:to-blue-900/80 rounded-3xl shadow-2xl overflow-hidden flex flex-col min-h-[250px] w-full max-w-md animate-fade-in">
                    @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="Poster Event" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300 rounded-t-3xl">
                    @endif
                    <div class="p-6 flex-1 flex flex-col">
                        <h4 class="text-xl font-bold text-gray-200 mb-2 group-hover:underline transition-all">{{ $event->title }}</h4>
                        <p class="text-gray-300 text-base mb-2 flex-1">{{ Str::limit($event->description, 80) }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="inline-block bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-base font-semibold animate-pulse shadow">Event</span>
                            <span class="text-sm text-gray-400">{{ date('d M Y', strtotime($event->start_date)) }} - {{ date('d M Y', strtotime($event->end_date)) }}</span>
                        </div>
                    </div>
                    <span class="absolute top-4 left-4 bg-gradient-to-r from-blue-500 to-blue-400 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg animate-bounce">NEW</span>
                </div>
                @else
                <div class="text-gray-400 text-center py-16 w-full max-w-md bg-white/10 rounded-2xl shadow">Belum ada event</div>
                @endif
            </div>
            <!-- NEWS -->
            <div class="flex flex-col items-center">
                <div class="flex items-center mb-6">
                    <i class="fas fa-bullhorn text-2xl text-green-500 mr-2" style="color: #22c55e !important;"></i>
                    <h3 class="text-2xl font-bold uppercase" style="color: #22c55e !important;">News</h3>
                </div>
                @if($news->count())
                @php $item = $news->first(); @endphp
                <div class="relative group bg-gradient-to-br from-green-50/80 via-white/90 to-green-100/80 dark:from-green-900/80 dark:via-gray-800/90 dark:to-green-900/80 rounded-3xl shadow-2xl overflow-hidden flex flex-col min-h-[250px] w-full max-w-md animate-fade-in">
                    @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="Poster News" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300 rounded-t-3xl">
                    @endif
                    <div class="p-6 flex-1 flex flex-col">
                        <h4 class="text-xl font-bold text-gray-200 mb-2 group-hover:underline transition-all">{{ $item->title }}</h4>
                        <p class="text-gray-300 text-base mb-2 flex-1">{{ Str::limit($item->description, 80) }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-full text-base font-semibold animate-pulse shadow">News</span>
                            <span class="text-sm text-gray-400">{{ date('d M Y', strtotime($item->start_date)) }} - {{ date('d M Y', strtotime($item->end_date)) }}</span>
                        </div>
                    </div>
                    <span class="absolute top-4 left-4 bg-gradient-to-r from-green-500 to-green-400 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg animate-bounce">INFO</span>
                </div>
                @else
                <div class="text-gray-400 text-center py-16 w-full max-w-md bg-white/10 rounded-2xl shadow">Belum ada news</div>
                @endif
            </div>
        </div>
        <!-- Section Daftar Mobil Tersedia -->
        <div class="mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-black text-red-600 mb-2">Daftar Mobil Tersedia</h2>
                <p class="text-lg font-bold text-red-500">Pilih mobil impian Anda dan lakukan pembelian dengan mudah!</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($cars as $car)
                <div class="bg-white/80 dark:bg-gray-800/90 rounded-xl shadow-2xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200 flex flex-col">
                    <div class="relative">
                        <img src="{{ $car->image ? asset('storage/'.$car->image) : 'https://via.placeholder.com/400x300?text=No+Image' }}"
                             alt="{{ $car->name }}" class="w-full h-48 object-cover rounded-t-xl">
                        @if(isset($car->promo) && $car->promo && $car->promo->discount_percentage > 0)
                            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded shadow">PROMO</span>
                        @endif
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-white mb-1">{{ $car->name }}</h3>
                        <p class="text-sm text-white mb-2">Tipe: {{ $car->type }}</p>
                        <div class="mb-2">
                            @if(isset($car->promo) && $car->promo && $car->promo->discount_percentage > 0)
                                <span class="text-gray-400 line-through text-sm">Rp {{ number_format($car->price, 0, ',', '.') }}</span>
                                <span class="text-red-500 font-bold text-lg ml-2">Rp {{ number_format($car->price * (1 - $car->promo->discount_percentage/100), 0, ',', '.') }}</span>
                                <span class="ml-2 inline-block bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">-{{ $car->promo->discount_percentage }}%</span>
                            @else
                                <span class="text-red-500 font-bold text-lg">Rp {{ number_format($car->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="flex flex-col gap-2 mt-auto">
                            <a href="{{ route('cars.show', $car->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 rounded font-semibold text-center transition">Lihat Detail</a>
                            <a href="{{ route('testdrive.form', $car->id) }}" class="bg-green-500 hover:bg-green-600 text-white py-2 rounded font-semibold text-center transition">Booking Test Drive</a>
                            <a href="{{ route('beli.form', $car->id) }}" class="bg-red-500 hover:bg-red-600 text-white py-2 rounded font-semibold text-center transition">Beli</a>
                            <span class="block mt-2 text-sm text-white">Stok: <span class="font-bold {{ $car->stock > 0 ? 'text-green-400' : 'text-red-500' }}">{{ $car->stock }}</span></span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 col-span-full">
                    <div class="w-24 h-24 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-car text-red-500 dark:text-red-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-100 mb-2">Belum ada mobil</h3>
                    <p class="text-gray-400 mb-6">Mobil belum tersedia saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>
        <!-- Riwayat Test Drive -->
        <div class="mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-black text-red-600 mb-2">Riwayat Test Drive</h2>
                <p class="text-lg font-bold text-red-500">Lihat status dan riwayat test drive Anda</p>
            </div>
            <div class="overflow-x-auto bg-white/80 dark:bg-gray-800/90 rounded-2xl shadow-2xl">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-red-500 to-red-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Mobil</th>
                            <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Tanggal & Waktu</th>
                            <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Kode Tiket</th>
                            <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/80 dark:bg-gray-800/90 divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($testDrives as $td)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-car text-red-500 mr-3"></i>
                                    <span class="text-gray-900 dark:text-white font-semibold">{{ $td->car->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar text-blue-500 mr-2"></i>
                                    <span>{{ date('d/m/Y', strtotime($td->preferred_date)) }}</span>
                                </div>
                                <div class="flex items-center mt-1">
                                    <i class="fas fa-clock text-green-500 mr-2"></i>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $td->preferred_time }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded-lg text-sm font-mono">{{ $td->ticket_code }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-bold shadow-lg
                                    @if($td->status=='pending') bg-yellow-100 text-yellow-800 border border-yellow-300
                                    @elseif($td->status=='approved') bg-green-100 text-green-800 border border-green-300
                                    @elseif($td->status=='completed') bg-blue-100 text-blue-800 border border-blue-300
                                    @elseif($td->status=='rejected') bg-red-100 text-red-800 border border-red-300
                                    @else bg-gray-100 text-gray-800 border border-gray-300 @endif">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ $td->status_label }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-road text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-semibold">Belum ada riwayat test drive</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm">Mulai dengan mengajukan test drive untuk mobil impian Anda</p>
                                    <a href="{{ route('testdrive.form') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition-colors duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        Ajukan Test Drive
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Riwayat Pembelian -->
        <div class="mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-black text-green-600 mb-2">Riwayat Pembelian</h2>
                <p class="text-lg font-bold text-green-500">Lihat status dan riwayat pembelian mobil Anda</p>
            </div>
            <div class="overflow-x-auto bg-white/80 dark:bg-gray-800/90 rounded-2xl shadow-2xl">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-green-500 to-green-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Mobil</th>
                            <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Promo</th>
                            <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/80 dark:bg-gray-800/90 divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($purchases as $p)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-car text-green-500 mr-3"></i>
                                    <span class="text-gray-900 dark:text-white font-semibold">{{ $p->car->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">
                                <span class="font-bold text-green-600">Rp {{ number_format($p->total_price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($p->promo)
                                    <span class="inline-block bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-semibold border border-red-300">
                                        <i class="fas fa-tag mr-1"></i>
                                        {{ $p->promo->title }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-bold shadow-lg
                                    @if($p->status=='pending') bg-yellow-100 text-yellow-800 border border-yellow-300
                                    @elseif($p->status=='approved') bg-green-100 text-green-800 border border-green-300
                                    @elseif($p->status=='completed') bg-blue-100 text-blue-800 border border-blue-300
                                    @elseif($p->status=='rejected') bg-red-100 text-red-800 border border-red-300
                                    @else bg-gray-100 text-gray-800 border border-gray-300 @endif">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-shopping-cart text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-semibold">Belum ada riwayat pembelian</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm">Mulai dengan membeli mobil impian Anda</p>
                                    <a href="{{ route('cars.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors duration-200">
                                        <i class="fas fa-car mr-2"></i>
                                        Lihat Mobil
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Kontak Tim (Butuh Bantuan) -->
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-white mb-4">Butuh Bantuan? Hubungi Tim Kami</h2>
            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg shadow-lg text-lg transition-all duration-200">
                <i class="fab fa-whatsapp mr-2"></i> Chat WhatsApp
            </a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.promo-swiper', {
        loop: {{ $promos->count() > 3 ? 'true' : 'false' }},
        slidesPerView: 1,
        breakpoints: {
            768: { slidesPerView: 1 },
            1024: { slidesPerView: 3 },
        },
        spaceBetween: 24,
        navigation: {
            nextEl: '.promo-next',
            prevEl: '.promo-prev',
        },
    });
    new Swiper('.event-swiper', {
        loop: {{ $events->count() > 3 ? 'true' : 'false' }},
        slidesPerView: 1,
        breakpoints: {
            768: { slidesPerView: 1 },
            1024: { slidesPerView: 3 },
        },
        spaceBetween: 24,
        navigation: {
            nextEl: '.event-next',
            prevEl: '.event-prev',
        },
    });
    new Swiper('.news-swiper', {
        loop: {{ $news->count() > 3 ? 'true' : 'false' }},
        slidesPerView: 1,
        breakpoints: {
            768: { slidesPerView: 1 },
            1024: { slidesPerView: 3 },
        },
        spaceBetween: 24,
        navigation: {
            nextEl: '.news-next',
            prevEl: '.news-prev',
        },
    });
});
</script>
@endsection
