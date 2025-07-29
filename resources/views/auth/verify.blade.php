<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-4 text-center">Verifikasi Akun</h2>
        <p class="mb-4 text-center text-gray-600">Masukkan kode verifikasi yang telah dikirimkan ke email/WhatsApp Anda.</p>
        @if(session('verification_code'))
            <div class="mb-4 text-center text-sm text-green-600">
                <strong>Kode verifikasi Anda (simulasi):</strong> {{ session('verification_code') }}
            </div>
        @endif
        <form method="POST" action="{{ route('verification.process') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <div class="mb-4">
                <label for="verification_code" class="block text-sm font-medium text-gray-700">Kode Verifikasi</label>
                <input type="text" name="verification_code" id="verification_code" maxlength="6" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                @error('verification_code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Verifikasi</button>
        </form>
    </div>
</x-guest-layout> 