<nav x-data="{ open: false }" class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm border-b border-red-200 dark:border-red-800 shadow-lg sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->check() ? (auth()->user()->hasRole('admin') ? route('admin.dashboard') : (auth()->user()->hasRole('superadmin') ? route('superadmin.dashboard') : route('dashboard'))) : route('welcome') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-car text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">PT. Makassar Raya Motor Cabang Kendari</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->user()->hasRole('customer'))
                        <!-- Customer Navigation -->
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center space-x-2">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>{{ __('Dashboard') }}</span>
                        </x-nav-link>
                        
                        <x-nav-link href="{{ route('cars.index') }}" :active="request()->routeIs('cars.*')" class="flex items-center space-x-2">
                            <i class="fas fa-car"></i>
                            <span>Lihat Mobil</span>
                        </x-nav-link>
                        
                        <x-nav-link href="{{ route('testdrive.form') }}" :active="request()->routeIs('testdrive.*')" class="flex items-center space-x-2">
                            <i class="fas fa-road"></i>
                            <span>Test Drive</span>
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                        <!-- Admin Navigation -->
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="flex items-center space-x-2">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>{{ __('Dashboard Admin') }}</span>
                        </x-nav-link>
                        
                        <x-nav-link href="{{ route('admin.cars.index') }}" :active="request()->routeIs('admin.cars.*')" class="flex items-center space-x-2">
                            <i class="fas fa-car"></i>
                            <span>Kelola Mobil</span>
                        </x-nav-link>
                        
                        <x-nav-link href="{{ route('admin.promos.index') }}" :active="request()->routeIs('admin.promos.*')" class="flex items-center space-x-2">
                            <i class="fas fa-tag"></i>
                            <span>Kelola Promo</span>
                        </x-nav-link>
                        
                        <x-nav-link href="{{ route('admin.testdrives.index') }}" :active="request()->routeIs('admin.testdrives.*')" class="flex items-center space-x-2">
                            <i class="fas fa-road"></i>
                            <span>Test Drive</span>
                        </x-nav-link>
                        
                        <x-nav-link href="{{ route('admin.purchases.index') }}" :active="request()->routeIs('admin.purchases.*')" class="flex items-center space-x-2">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Pembelian</span>
                        </x-nav-link>
                        
                        <x-nav-link href="{{ route('admin.reports.index') }}" :active="request()->routeIs('admin.reports.*')" class="flex items-center space-x-2">
                            <i class="fas fa-chart-bar"></i>
                            <span>Laporan</span>
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->hasRole('superadmin'))
                        <!-- Super Admin Navigation -->
                        <x-nav-link :href="route('superadmin.dashboard')" :active="request()->routeIs('superadmin.dashboard')" class="flex items-center space-x-2">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>{{ __('Dashboard Super Admin') }}</span>
                        </x-nav-link>
                        
                        <x-nav-link href="{{ route('superadmin.users.index') }}" :active="request()->routeIs('superadmin.users.*')" class="flex items-center space-x-2">
                            <i class="fas fa-users"></i>
                            <span>Kelola User</span>
                        </x-nav-link>
                        
                        <x-nav-link href="{{ route('superadmin.reports.index') }}" :active="request()->routeIs('superadmin.reports.*')" class="flex items-center space-x-2">
                            <i class="fas fa-chart-bar"></i>
                            <span>Laporan</span>
                        </x-nav-link>
                        
                        <x-nav-link href="{{ route('superadmin.stnk.status') }}" :active="request()->routeIs('superadmin.stnk.*')" class="flex items-center space-x-2">
                            <i class="fas fa-file-alt"></i>
                            <span>Status STNK</span>
                        </x-nav-link>
                    @endif
                </div>
                @endauth
            </div>

            <!-- Settings Dropdown -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white/50 dark:bg-gray-700/50 hover:bg-red-50 dark:hover:bg-gray-600 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-xs"></i>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @auth
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2">
                            <i class="fas fa-user-edit"></i>
                            <span>{{ __('Profile') }}</span>
                        </x-dropdown-link>
                        @endauth

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="flex items-center space-x-2 text-red-600 hover:text-red-800">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>{{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @else
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Register
                </a>
            </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-gray-900 focus:outline-none focus:bg-red-50 dark:focus:bg-gray-900 focus:text-red-600 dark:focus:text-red-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        @auth
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->hasRole('customer'))
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center space-x-2">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>{{ __('Dashboard') }}</span>
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('cars.index') }}" :active="request()->routeIs('cars.*')" class="flex items-center space-x-2">
                    <i class="fas fa-car"></i>
                    <span>Lihat Mobil</span>
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('testdrive.form') }}" :active="request()->routeIs('testdrive.*')" class="flex items-center space-x-2">
                    <i class="fas fa-road"></i>
                    <span>Test Drive</span>
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole('admin'))
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="flex items-center space-x-2">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>{{ __('Dashboard Admin') }}</span>
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('admin.cars.index') }}" :active="request()->routeIs('admin.cars.*')" class="flex items-center space-x-2">
                    <i class="fas fa-car"></i>
                    <span>Kelola Mobil</span>
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('admin.promos.index') }}" :active="request()->routeIs('admin.promos.*')" class="flex items-center space-x-2">
                    <i class="fas fa-tag"></i>
                    <span>Kelola Promo</span>
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('admin.testdrives.index') }}" :active="request()->routeIs('admin.testdrives.*')" class="flex items-center space-x-2">
                    <i class="fas fa-road"></i>
                    <span>Test Drive</span>
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('admin.purchases.index') }}" :active="request()->routeIs('admin.purchases.*')" class="flex items-center space-x-2">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pembelian</span>
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('admin.reports.index') }}" :active="request()->routeIs('admin.reports.*')" class="flex items-center space-x-2">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole('superadmin'))
                <x-responsive-nav-link :href="route('superadmin.dashboard')" :active="request()->routeIs('superadmin.dashboard')" class="flex items-center space-x-2">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>{{ __('Dashboard Super Admin') }}</span>
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('superadmin.users.index') }}" :active="request()->routeIs('superadmin.users.*')" class="flex items-center space-x-2">
                    <i class="fas fa-users"></i>
                    <span>Kelola User</span>
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('superadmin.reports.index') }}" :active="request()->routeIs('superadmin.reports.*')" class="flex items-center space-x-2">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </x-responsive-nav-link>
                
                <x-responsive-nav-link href="{{ route('superadmin.stnk.status') }}" :active="request()->routeIs('superadmin.stnk.*')" class="flex items-center space-x-2">
                    <i class="fas fa-file-alt"></i>
                    <span>Status STNK</span>
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-red-200 dark:border-red-800">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @auth
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center space-x-2">
                    <i class="fas fa-user-edit"></i>
                    <span>{{ __('Profile') }}</span>
                </x-responsive-nav-link>
                @endauth

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="flex items-center space-x-2 text-red-600 hover:text-red-800">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>{{ __('Log Out') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('login') }}" class="flex items-center space-x-2">
                <i class="fas fa-sign-in-alt"></i>
                <span>Login</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('register') }}" class="flex items-center space-x-2">
                <i class="fas fa-user-plus"></i>
                <span>Register</span>
            </x-responsive-nav-link>
        </div>
        @endauth
    </div>
</nav>
