@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center justify-center space-x-2 mb-4">
            <i class="fas fa-shopping-cart text-red-600"></i>
            <span>Formulir Pembelian</span>
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Lengkapi formulir di bawah ini untuk melanjutkan pembelian</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
            <form method="POST" action="{{ route('beli.store') }}" class="space-y-6" enctype="multipart/form-data">
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

                <!-- Buyer Name -->
                <div>
                    <label for="buyer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-user text-red-600 mr-2"></i>
                        Nama Pembeli
                    </label>
                    <input type="text" name="buyer_name" id="buyer_name" value="{{ old('buyer_name') }}" 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" 
                           placeholder="Masukkan nama lengkap pembeli" required>
                    @error('buyer_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buyer Email -->
                <div>
                    <label for="buyer_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-envelope text-red-600 mr-2"></i>
                        Email Pembeli
                    </label>
                    <input type="email" name="buyer_email" id="buyer_email" value="{{ old('buyer_email') }}" 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" 
                           placeholder="Masukkan email pembeli" required>
                    @error('buyer_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buyer Phone -->
                <div>
                    <label for="buyer_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-phone text-red-600 mr-2"></i>
                        Nomor Telepon
                    </label>
                    <input type="tel" name="buyer_phone" id="buyer_phone" value="{{ old('buyer_phone') }}" 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" 
                           placeholder="Masukkan nomor telepon" required>
                    @error('buyer_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purchase Date -->
                <div>
                    <label for="purchase_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-calendar text-red-600 mr-2"></i>
                        Tanggal Pembelian
                    </label>
                    <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" 
                           required>
                    @error('purchase_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-credit-card text-red-600 mr-2"></i>
                        Metode Pembayaran
                    </label>
                    <select name="payment_method" id="payment_method" 
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" required>
                        <option value="">Pilih metode pembayaran...</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                        <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>Kredit</option>
                    </select>
                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Team Selection -->
                <div>
                    <label for="team" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-users text-red-600 mr-2"></i>
                        Pilih Tim Pelayanan
                    </label>
                    <select name="team" id="team" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" required>
                        <option value="">Pilih tim...</option>
                        <option value="WARRIOR" {{ old('team') == 'WARRIOR' ? 'selected' : '' }}>TIM WARRIOR</option>
                        <option value="RAIDON" {{ old('team') == 'RAIDON' ? 'selected' : '' }}>TIM RAIDON</option>
                        <option value="KSYOW" {{ old('team') == 'KSYOW' ? 'selected' : '' }}>TIM KSYOW</option>
                        <option value="ANDUONOHU" {{ old('team') == 'ANDUONOHU' ? 'selected' : '' }}>TIM ANDUONOHU</option>
                        <option value="KONSEL" {{ old('team') == 'KONSEL' ? 'selected' : '' }}>TIM KONSEL</option>
                        <option value="UNAHA" {{ old('team') == 'UNAHA' ? 'selected' : '' }}>TIM UNAHA</option>
                    </select>
                    @error('team')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- WhatsApp Number -->
                <div>
                    <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fab fa-whatsapp text-green-500 mr-2"></i>
                        Nomor WhatsApp
                    </label>
                    <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number') }}" 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" 
                           placeholder="Masukkan nomor WhatsApp aktif" required>
                    @error('whatsapp_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- KTP Photo Upload -->
                <div>
                    <label for="ktp_photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-id-card text-red-600 mr-2"></i>
                        Upload Foto KTP
                    </label>
                    <input type="file" name="ktp_photo" id="ktp_photo"
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm"
                           accept="image/jpeg,image/png,image/jpg" required>
                    @error('ktp_photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-comment text-red-600 mr-2"></i>
                        Catatan (Opsional)
                    </label>
                    <textarea name="notes" id="notes" rows="4" 
                              class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm" 
                              placeholder="Tambahkan catatan atau instruksi khusus...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold py-3 px-6 rounded-xl hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-lg">
                        <i class="fas fa-check mr-2"></i>
                        Konfirmasi Pembelian
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

            <!-- Purchase Info -->
            <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-info-circle text-green-600 mr-2"></i>
                    Informasi Pembelian
                </h3>
                <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-shield-alt text-green-600 mt-1"></i>
                        <div>
                            <p class="font-medium">Transaksi Aman</p>
                            <p>Semua transaksi dilindungi dan terjamin keamanannya</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-clock text-green-600 mt-1"></i>
                        <div>
                            <p class="font-medium">Proses Cepat</p>
                            <p>Pembelian akan diproses dalam 1-2 hari kerja</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-file-contract text-green-600 mt-1"></i>
                        <div>
                            <p class="font-medium">Dokumen Lengkap</p>
                            <p>BPKB, STNK, dan dokumen lainnya akan diserahkan</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-truck text-green-600 mt-1"></i>
                        <div>
                            <p class="font-medium">Pengiriman</p>
                            <p>Mobil akan diantar ke alamat yang ditentukan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-credit-card text-red-600 mr-2"></i>
                    Metode Pembayaran
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <i class="fas fa-money-bill text-green-600"></i>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Tunai</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Bayar langsung di showroom</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <i class="fas fa-credit-card text-blue-600"></i>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Kartu Kredit</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Cicilan 0% hingga 12 bulan</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <i class="fas fa-university text-purple-600"></i>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Transfer Bank</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">BCA, Mandiri, BNI, BRI</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <i class="fas fa-handshake text-orange-600"></i>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Kredit</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Konsultasi dengan tim financing</p>
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
                        <span>sales@autodealer.com</span>
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
