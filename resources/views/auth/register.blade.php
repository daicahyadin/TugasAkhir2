<x-guest-layout>
    <!-- Welcome Message -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            <i class="fas fa-user-plus text-blue-500 mr-2"></i>
            Daftar Akun Baru
        </h2>
        <p class="text-gray-600 dark:text-gray-400">Buat akun untuk mengakses layanan kami</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user text-gray-400"></i>
                </div>
                <x-text-input id="name" class="block mt-1 w-full pl-10" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('No HP')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-phone text-gray-400"></i>
                </div>
                <x-text-input id="phone" class="block mt-1 w-full pl-10" type="text" name="phone" :value="old('phone')" required autocomplete="phone" placeholder="Masukkan nomor HP" />
            </div>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Alamat')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                </div>
                <x-text-input id="address" class="block mt-1 w-full pl-10" type="text" name="address" :value="old('address')" required autocomplete="address" placeholder="Masukkan alamat lengkap" />
            </div>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Job -->
        <div class="mt-4">
            <x-input-label for="job" :value="__('Pekerjaan')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-briefcase text-gray-400"></i>
                </div>
                <x-text-input id="job" class="block mt-1 w-full pl-10" type="text" name="job" :value="old('job')" required autocomplete="job" placeholder="Masukkan pekerjaan" />
            </div>
            <x-input-error :messages="$errors->get('job')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <x-text-input id="email" class="block mt-1 w-full pl-10" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Masukkan email" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <x-text-input id="password" class="block mt-1 w-full pl-10"
                          type="password"
                          name="password"
                          required autocomplete="new-password" 
                          placeholder="Masukkan password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <x-text-input id="password_confirmation" class="block mt-1 w-full pl-10"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" 
                          placeholder="Konfirmasi password" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt mr-1"></i>
                {{ __('Sudah punya akun?') }}
            </a>
            <x-primary-button class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 border-0 shadow-lg">
                <i class="fas fa-user-plus mr-2"></i>
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Back to Home -->
    <div class="text-center mt-6">
        <a href="{{ route('welcome') }}" class="text-sm text-gray-500 hover:text-blue-500 dark:text-gray-400 dark:hover:text-blue-400 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali ke Beranda
        </a>
    </div>
</x-guest-layout>
