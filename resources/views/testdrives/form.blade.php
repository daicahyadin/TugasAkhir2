@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center justify-center space-x-2 mb-4">
            <i class="fas fa-road text-red-600"></i>
            <span>Formulir Test Drive</span>
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Isi formulir di bawah ini untuk mengajukan test drive</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
            <form method="POST" action="{{ route('testdrive.store') }}" class="space-y-6">
        @csrf
                
                @if(isset($car))
                <input type="hidden" name="car_id" value="{{ $car->id }}">
                @endif

                <!-- Car Selection -->
                <div>
                    <label for="car_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-car text-red-600 mr-2"></i>
                        Pilih Mobil
                    </label>
                    <select name="car_id" id="car_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" required>
                        <option value="">Pilih mobil...</option>
                        @foreach(\App\Models\Car::all() as $car)
                            <option value="{{ $car->id }}" {{ (old('car_id') == $car->id || (isset($selectedCar) && $selectedCar->id == $car->id)) ? 'selected' : '' }}>
                                {{ $car->name }} - {{ $car->type }} (Rp {{ number_format($car->price, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    @error('car_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-user text-red-600 mr-2"></i>
                        Nama Lengkap
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" 
                           placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-envelope text-red-600 mr-2"></i>
                        Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" 
                           placeholder="Masukkan email" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-phone text-red-600 mr-2"></i>
                        Nomor Telepon
                    </label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" 
                           placeholder="Masukkan nomor telepon" required>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Test Drive Date -->
                <div>
                    <label for="test_drive_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-calendar text-red-600 mr-2"></i>
                        Tanggal Test Drive
                    </label>
                    <input type="date" name="test_drive_date" id="test_drive_date" value="{{ old('test_drive_date') }}" 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" 
                           min="{{ date('Y-m-d') }}" required>
                    @error('test_drive_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Test Drive Time -->
                <div>
                    <label for="test_drive_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-clock text-red-600 mr-2"></i>
                        Waktu Test Drive
                    </label>
                    <select name="test_drive_time" id="test_drive_time" 
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" required>
                        <option value="">Pilih waktu...</option>
                        <option value="09:00" {{ old('test_drive_time') == '09:00' ? 'selected' : '' }}>09:00</option>
                        <option value="10:00" {{ old('test_drive_time') == '10:00' ? 'selected' : '' }}>10:00</option>
                        <option value="11:00" {{ old('test_drive_time') == '11:00' ? 'selected' : '' }}>11:00</option>
                        <option value="13:00" {{ old('test_drive_time') == '13:00' ? 'selected' : '' }}>13:00</option>
                        <option value="14:00" {{ old('test_drive_time') == '14:00' ? 'selected' : '' }}>14:00</option>
                        <option value="15:00" {{ old('test_drive_time') == '15:00' ? 'selected' : '' }}>15:00</option>
                        <option value="16:00" {{ old('test_drive_time') == '16:00' ? 'selected' : '' }}>16:00</option>
                    </select>
                    @error('test_drive_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-comment text-red-600 mr-2"></i>
                        Pesan (Opsional)
                    </label>
                    <textarea name="message" id="message" rows="4" 
                              class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" 
                              placeholder="Tambahkan pesan atau catatan khusus...">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold py-3 px-6 rounded-xl hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Ajukan Test Drive
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="space-y-6">
            <!-- Selected Car Info -->
            @if(isset($car))
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-car text-red-600 mr-2"></i>
                    Mobil yang Dipilih
                </h3>
                <div class="space-y-4">
                    <img src="{{ $car->image ? asset('storage/'.$car->image) : 'https://via.placeholder.com/400x300?text=No+Image' }}" 
                         alt="{{ $car->name }}" 
                         class="w-full h-48 object-cover rounded-lg">
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">{{ $car->name }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $car->type }}</p>
                        <p class="text-lg font-bold text-red-600 mt-2">Rp {{ number_format($car->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Test Drive Info -->
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Informasi Test Drive
                </h3>
                <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-clock text-blue-600 mt-1"></i>
                        <div>
                            <p class="font-medium">Durasi Test Drive</p>
                            <p>30-45 menit per sesi</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-blue-600 mt-1"></i>
                        <div>
                            <p class="font-medium">Lokasi</p>
                            <p>Showroom AutoDealer, Jl. Sudirman No. 123</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-id-card text-blue-600 mt-1"></i>
                        <div>
                            <p class="font-medium">Dokumen yang Diperlukan</p>
                            <p>KTP dan SIM yang masih berlaku</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-phone text-blue-600 mt-1"></i>
                        <div>
                            <p class="font-medium">Konfirmasi</p>
                            <p>Tim kami akan menghubungi Anda untuk konfirmasi</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-headset text-red-600 mr-2"></i>
                    Butuh Bantuan?
                </h3>
                <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-phone text-red-600"></i>
                        <span>+62 812-3456-7890</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-red-600"></i>
                        <span>testdrive@autodealer.com</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-clock text-red-600"></i>
                        <span>Senin - Jumat: 09:00 - 17:00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
