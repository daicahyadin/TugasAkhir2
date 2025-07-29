<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PT. Makassar Raya Motor Cabang Kendari - Rajanya DAIHATSU di Indonesia Timur</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- SwiperJS CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    </head>
    <body class="bg-gradient-to-br from-red-50 via-white to-red-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg border-b-4 border-red-500 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center h-20 justify-between w-full">
                    <!-- Logo & Brand -->
                    <div class="flex items-center gap-3 min-w-0 flex-1">
                        <img src="/logo/mrm.png" alt="Logo MRM" class="w-10 h-10 rounded-xl object-contain bg-white shadow-2xl ring-2 ring-red-200">
                        <span class="text-base sm:text-lg md:text-xl lg:text-2xl font-extrabold tracking-wide text-red-600 whitespace-nowrap overflow-hidden text-ellipsis" title="MRM Kendari">
                            MRM Kendari
                        </span>
                    </div>
                    <!-- Hamburger (Mobile, tampil di < md) -->
                    <div class="flex items-center md:hidden">
                        <button id="mobile-menu-button" class="text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 p-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Navigation Links (Desktop) -->
                    <div class="hidden md:flex flex-1 justify-center">
                        <div class="flex items-center gap-x-6">
                            <a href="#home" class="nav-link font-bold text-base px-2 py-2 text-gray-800 border-b-2 border-transparent whitespace-nowrap hover:text-red-500 hover:border-red-400 transition-all duration-200">Beranda</a>
                            <a href="#cars" class="nav-link font-bold text-base px-2 py-2 text-gray-800 border-b-2 border-transparent whitespace-nowrap hover:text-red-500 hover:border-red-400 transition-all duration-200">Mobil</a>
                            <a href="#promo" class="nav-link font-bold text-base px-2 py-2 text-gray-800 border-b-2 border-transparent whitespace-nowrap hover:text-red-500 hover:border-red-400 transition-all duration-200">Promo & Event</a>
                            <a href="#outlet" class="nav-link font-bold text-base px-2 py-2 text-gray-800 border-b-2 border-transparent whitespace-nowrap hover:text-red-500 hover:border-red-400 transition-all duration-200">Outlet Kami</a>
                            <a href="#about" class="nav-link font-bold text-base px-2 py-2 text-gray-800 border-b-2 border-transparent whitespace-nowrap hover:text-red-500 hover:border-red-400 transition-all duration-200">Tentang</a>
                            <a href="#contact" class="nav-link font-bold text-base px-2 py-2 text-gray-800 border-b-2 border-transparent whitespace-nowrap hover:text-red-500 hover:border-red-400 transition-all duration-200">Kontak</a>
                        </div>
                    </div>
                    <!-- Auth Buttons (Desktop) -->
                    <div class="hidden md:flex items-center gap-2 ml-6">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white font-bold text-base rounded-lg shadow-lg hover:from-red-600 hover:to-red-700 transition-all duration-200">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center px-5 py-2 border-2 border-red-500 text-red-600 font-bold text-base rounded-lg bg-white hover:bg-red-50 transition-all duration-200">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white font-bold text-base rounded-lg shadow-lg hover:from-red-600 hover:to-red-700 transition-all duration-200">Daftar</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
                <!-- Mobile Menu (hidden by default) -->
                <div id="mobile-menu" class="md:hidden hidden flex-col space-y-2 mt-2 pb-4">
                    <a href="#home" class="block font-bold text-base px-4 py-2 text-red-600 border-l-4 border-red-600 hover:text-red-500 hover:border-red-400 transition-all duration-200">Beranda</a>
                    <a href="#cars" class="block font-bold text-base px-4 py-2 text-gray-800 border-l-4 border-transparent hover:text-red-500 hover:border-red-400 transition-all duration-200">Mobil</a>
                    <a href="#promo" class="block font-bold text-base px-4 py-2 text-gray-800 border-l-4 border-transparent hover:text-red-500 hover:border-red-400 transition-all duration-200">Promo & Event</a>
                    <a href="#outlet" class="block font-bold text-base px-4 py-2 text-gray-800 border-l-4 border-transparent hover:text-red-500 hover:border-red-400 transition-all duration-200">Outlet Kami</a>
                    <a href="#about" class="block font-bold text-base px-4 py-2 text-gray-800 border-l-4 border-transparent hover:text-red-500 hover:border-red-400 transition-all duration-200">Tentang</a>
                    <a href="#contact" class="block font-bold text-base px-4 py-2 text-gray-800 border-l-4 border-transparent hover:text-red-500 hover:border-red-400 transition-all duration-200">Kontak</a>
                    <div class="flex flex-col space-y-2 mt-2">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-5 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white font-bold text-base rounded-lg shadow-lg hover:from-red-600 hover:to-red-700 transition-all duration-200">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2 border-2 border-red-500 text-red-600 font-bold text-base rounded-lg bg-white hover:bg-red-50 transition-all duration-200">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white font-bold text-base rounded-lg shadow-lg hover:from-red-600 hover:to-red-700 transition-all duration-200">Daftar</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>
        <script>
            // Hamburger menu toggle
            document.addEventListener('DOMContentLoaded', function () {
                const btn = document.getElementById('mobile-menu-button');
                const menu = document.getElementById('mobile-menu');
                btn.addEventListener('click', function () {
                    menu.classList.toggle('hidden');
                });

                // Highlight active nav-link based on hash
                function setActiveNavLink() {
                    const hash = window.location.hash || '#home';
                    document.querySelectorAll('.nav-link').forEach(link => {
                        if (link.getAttribute('href') === hash) {
                            link.classList.add('bg-red-100', 'text-red-600', 'border-red-600', 'rounded');
                            link.classList.remove('text-gray-800', 'border-transparent');
                        } else {
                            link.classList.remove('bg-red-100', 'text-red-600', 'border-red-600', 'rounded');
                            link.classList.add('text-gray-800', 'border-transparent');
                        }
                    });
                }
                setActiveNavLink();
                window.addEventListener('hashchange', setActiveNavLink);
            });
        </script>

        <!-- Hero Section -->
        <section id="home" class="relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left">
                        <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                            Temukan Mobil
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-red-600">
                                Impian Anda
                            </span>
                        </h1>
                        <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                            Platform terpercaya untuk membeli mobil DAIHATSU dengan proses yang mudah, aman, dan transparan.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="#cars" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg transform hover:scale-105">
                                <i class="fas fa-car mr-2"></i>
                                Lihat Mobil
                            </a>
                            <a href="#about" class="inline-flex items-center px-8 py-4 border-2 border-red-500 text-red-600 dark:text-red-400 font-semibold rounded-xl hover:bg-red-500 hover:text-white transition-all duration-200">
                                <i class="fas fa-info-circle mr-2"></i>
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-3xl p-8 shadow-2xl">
                            <div class="bg-white rounded-2xl p-6">
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div class="bg-red-50 rounded-xl p-4">
                                        <i class="fas fa-car text-3xl text-red-600 mb-2"></i>
                                        <p class="font-bold text-gray-900">100+</p>
                                        <p class="text-sm text-gray-600">Mobil Tersedia</p>
                                    </div>
                                    <div class="bg-blue-50 rounded-xl p-4">
                                        <i class="fas fa-users text-3xl text-blue-600 mb-2"></i>
                                        <p class="font-bold text-gray-900">500+</p>
                                        <p class="text-sm text-gray-600">Pelanggan Puas</p>
                                    </div>
                                    <div class="bg-green-50 rounded-xl p-4">
                                        <i class="fas fa-star text-3xl text-green-600 mb-2"></i>
                                        <p class="font-bold text-gray-900">4.8</p>
                                        <p class="text-sm text-gray-600">Rating</p>
                                    </div>
                                    <div class="bg-purple-50 rounded-xl p-4">
                                        <i class="fas fa-shield-alt text-3xl text-purple-600 mb-2"></i>
                                        <p class="font-bold text-gray-900">100%</p>
                                        <p class="text-sm text-gray-600">Terpercaya</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Promo, Event, News Section (Slider, 3 kolom sejajar) -->
        <section id="promo" class="py-12 bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Promo, Event & News Terbaru</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400">Dapatkan info terbaru dari kami!</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- PROMO SLIDER -->
                    <div>
                        <h3 class="text-xl font-bold text-red-600 mb-4 flex items-center justify-center"><i class="fas fa-tags mr-2"></i>Promo</h3>
                        <div class="flex items-center justify-center space-x-2">
                            <button class="promo-prev bg-red-500 hover:bg-red-700 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all duration-200 border-4 border-white focus:outline-none"><i class="fas fa-chevron-left"></i></button>
                            <div class="swiper promo-swiper w-full max-w-xs md:max-w-sm lg:max-w-md xl:max-w-lg">
                                <div class="swiper-wrapper">
                                    @forelse($promos as $promo)
                                    <div class="swiper-slide">
                                        <div class="relative group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col transform transition duration-300 hover:scale-105 hover:shadow-2xl animate-fade-in">
                                            @if($promo->image)
                                            <img src="{{ asset('storage/' . $promo->image) }}" alt="Poster Promo" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                            @endif
                                            <div class="p-4 flex-1 flex flex-col">
                                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $promo->title }}</h4>
                                                <p class="text-gray-700 dark:text-gray-300 text-sm mb-2 flex-1">{{ Str::limit($promo->description, 60) }}</p>
                                                <div class="flex items-center justify-between mt-2">
                                                    <span class="inline-block bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold animate-pulse">Diskon {{ $promo->discount_percentage }}%</span>
                                                    <span class="text-xs text-gray-500">{{ date('d M Y', strtotime($promo->start_date)) }} - {{ date('d M Y', strtotime($promo->end_date)) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="swiper-slide text-gray-400 text-center">Belum ada promo</div>
                                    @endforelse
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <button class="promo-next bg-red-500 hover:bg-red-700 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all duration-200 border-4 border-white focus:outline-none"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                    <!-- EVENT SLIDER -->
                    <div>
                        <h3 class="text-xl font-bold text-blue-600 mb-4 flex items-center justify-center"><i class="fas fa-calendar-alt mr-2"></i>Event</h3>
                        <div class="flex items-center justify-center space-x-2">
                            <button class="event-prev bg-blue-500 hover:bg-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all duration-200 border-4 border-white focus:outline-none"><i class="fas fa-chevron-left"></i></button>
                            <div class="swiper event-swiper w-full max-w-xs md:max-w-sm lg:max-w-md xl:max-w-lg">
                                <div class="swiper-wrapper">
                                    @forelse($events as $event)
                                    <div class="swiper-slide">
                                        <div class="relative group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col transform transition duration-300 hover:scale-105 hover:shadow-2xl animate-fade-in">
                                            @if($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}" alt="Poster Event" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                            @endif
                                            <div class="p-4 flex-1 flex flex-col">
                                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $event->title }}</h4>
                                                <p class="text-gray-700 dark:text-gray-300 text-sm mb-2 flex-1">{{ Str::limit($event->description, 60) }}</p>
                                                <div class="flex items-center justify-between mt-2">
                                                    <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold animate-pulse">Event</span>
                                                    <span class="text-xs text-gray-500">{{ date('d M Y', strtotime($event->start_date)) }} - {{ date('d M Y', strtotime($event->end_date)) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="swiper-slide text-gray-400 text-center">Belum ada event</div>
                                    @endforelse
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <button class="event-next bg-blue-500 hover:bg-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all duration-200 border-4 border-white focus:outline-none"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                    <!-- NEWS SLIDER -->
                    <div>
                        <h3 class="text-xl font-bold text-green-600 mb-4 flex items-center justify-center"><i class="fas fa-bullhorn mr-2"></i>News</h3>
                        <div class="flex items-center justify-center space-x-2">
                            <button class="news-prev bg-green-500 hover:bg-green-700 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all duration-200 border-4 border-white focus:outline-none"><i class="fas fa-chevron-left"></i></button>
                            <div class="swiper news-swiper w-full max-w-xs md:max-w-sm lg:max-w-md xl:max-w-lg">
                                <div class="swiper-wrapper">
                                    @forelse($news as $item)
                                    <div class="swiper-slide">
                                        <div class="relative group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col transform transition duration-300 hover:scale-105 hover:shadow-2xl animate-fade-in">
                                            @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Poster News" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                            @endif
                                            <div class="p-4 flex-1 flex flex-col">
                                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $item->title }}</h4>
                                                <p class="text-gray-700 dark:text-gray-300 text-sm mb-2 flex-1">{{ Str::limit($item->description, 60) }}</p>
                                                <div class="flex items-center justify-between mt-2">
                                                    <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold animate-pulse">News</span>
                                                    <span class="text-xs text-gray-500">{{ date('d M Y', strtotime($item->start_date)) }} - {{ date('d M Y', strtotime($item->end_date)) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="swiper-slide text-gray-400 text-center">Belum ada news</div>
                                    @endforelse
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <button class="news-next bg-green-500 hover:bg-green-700 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all duration-200 border-4 border-white focus:outline-none"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new Swiper('.promo-swiper', {
                    loop: true,
                    autoplay: { delay: 3500, disableOnInteraction: false },
                    pagination: { el: '.promo-swiper .swiper-pagination', clickable: true },
                    navigation: { nextEl: '.promo-next', prevEl: '.promo-prev' },
                });
                new Swiper('.event-swiper', {
                    loop: true,
                    autoplay: { delay: 3500, disableOnInteraction: false },
                    pagination: { el: '.event-swiper .swiper-pagination', clickable: true },
                    navigation: { nextEl: '.event-next', prevEl: '.event-prev' },
                });
                new Swiper('.news-swiper', {
                    loop: true,
                    autoplay: { delay: 3500, disableOnInteraction: false },
                    pagination: { el: '.news-swiper .swiper-pagination', clickable: true },
                    navigation: { nextEl: '.news-next', prevEl: '.news-prev' },
                });
            });
        </script>

        <!-- Daftar Mobil Section -->
        @if(isset($cars) && $cars->count())
        <section id="cars" class="py-12 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Daftar Mobil Tersedia</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400">Pilih mobil impian Anda dan lakukan pembelian dengan mudah!</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($cars as $car)
                    <div class="relative group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col transform transition duration-300 hover:scale-105 hover:shadow-2xl">
                        @if($car->stock == 0)
                        <div class="absolute top-0 right-0 bg-gray-400 text-white text-xs font-bold px-3 py-1 rounded-bl-xl z-10 animate-pulse">Stok Habis</div>
                        @endif
                        @if($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" alt="Gambar Mobil" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                        @endif
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $car->name }}</h3>
                            <p class="text-gray-700 dark:text-gray-300 mb-2">Tipe: {{ $car->type }}</p>
                            <p class="text-gray-700 dark:text-gray-300 mb-2">Harga: Rp {{ number_format($car->price, 0, ',', '.') }}</p>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">Stok: <span class="font-bold {{ $car->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $car->stock }}</span></p>
                            <div class="mt-auto flex flex-col gap-2">
                                @auth
                                    @if(auth()->user()->hasRole('customer'))
                                        <a href="{{ route('beli.form', $car->id) }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full text-center transition-all duration-200 shadow-lg">Beli</a>
                                        <a href="{{ route('testdrive.form', $car->id) }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full text-center transition-all duration-200 shadow-lg">Booking Test Drive</a>
                                    @else
                                        <span class="inline-block bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded w-full text-center cursor-not-allowed">Login sebagai customer untuk aksi</span>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full text-center transition-all duration-200 shadow-lg">Login untuk Beli</a>
                                    <a href="{{ route('login') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full text-center transition-all duration-200 shadow-lg">Login untuk Test Drive</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Features Section -->
        <section class="py-20 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Mengapa Memilih PT. Makassar Raya Motor Cabang Kendari?
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-400">
                        Kami menyediakan layanan terbaik untuk kebutuhan mobil SAHABAT
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-8 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-2xl">
                        <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-search text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Pencarian Mudah</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Temukan mobil yang sesuai dengan kebutuhan dan budget SAHABAT dengan mudah
                        </p>
                    </div>

                    <div class="text-center p-8 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl">
                        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-shield-alt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Transaksi Aman</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Proses transaksi yang aman dan terpercaya dengan sistem yang terjamin
                        </p>
                    </div>

                    <div class="text-center p-8 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-headset text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Layanan 24/7</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Dukungan pelanggan yang siap membantu SAHABAT kapan saja
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-20 bg-gradient-to-br from-red-50 to-red-100 dark:from-gray-900 dark:to-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">
                            Tentang PT. Makassar Raya Motor Cabang Kendari
                        </h2>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                            PT. Makassar Raya Motor Cabang Kendari adalah platform terdepan dalam industri otomotif yang menghubungkan pembeli dan penjual mobil dengan cara yang inovatif dan terpercaya.
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">Verifikasi mobil berkualitas tinggi</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">Proses transaksi yang transparan</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">Dukungan pelanggan yang responsif</span>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-xl">
                            <div class="text-center">
                                <i class="fas fa-car text-6xl text-red-500 mb-4"></i>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                    Bergabunglah Sekarang
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">
                                    Dapatkan akses ke ribuan mobil berkualitas dan layanan terbaik
                                </p>
                                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Daftar Gratis
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-20 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Hubungi Kami
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-400">
                        Siap membantu Anda dengan pertanyaan dan kebutuhan
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-phone text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Telepon</h3>
                        <p class="text-gray-600 dark:text-gray-400">+62 812-3456-7890</p>
                    </div>

                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Email</h3>
                        <p class="text-gray-600 dark:text-gray-400">daihatsumrm@gmail.com</p>
                    </div>

                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-map-marker-alt text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Alamat</h3>
                        <p class="text-gray-600 dark:text-gray-400">Jl. Mayjend.S.Parman,Kemaraya,Kota Kendari, Sulawesi Tenggara</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <img src="/logo/mrm.png" alt="Logo MRM" class="w-8 h-8 object-contain rounded-lg">
                            <span class="text-xl font-bold">PT. Makassar Raya Motor Cabang Kendari</span>
                        </div>
                        <p class="text-gray-400">
                            Platform terpercaya untuk membeli dan menjual mobil dengan proses yang mudah dan aman.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Layanan</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-red-400 transition-colors">Jual Mobil</a></li>
                            <li><a href="#" class="hover:text-red-400 transition-colors">Beli Mobil</a></li>
                            <li><a href="#" class="hover:text-red-400 transition-colors">Test Drive</a></li>
                            <li><a href="#" class="hover:text-red-400 transition-colors">Financing</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Perusahaan</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-red-400 transition-colors">Tentang Kami</a></li>
                            <li><a href="#" class="hover:text-red-400 transition-colors">Karir</a></li>
                            <li><a href="#" class="hover:text-red-400 transition-colors">Blog</a></li>
                            <li><a href="#" class="hover:text-red-400 transition-colors">Press</a></li>
                    </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Ikuti Kami</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; 2025 PT. Makassar Raya Motor Cabang Kendari. All rights reserved.</p>
                </div>
        </div>
        </footer>
    </body>
</html>
