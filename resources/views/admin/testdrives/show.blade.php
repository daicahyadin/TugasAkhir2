<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Test Drive') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.testdrives.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
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
                        <!-- Informasi Customer -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Customer</h3>
                                <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Nama</label>
                                        <p class="text-lg font-semibold text-gray-900">{{ $testDrive->user->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Email</label>
                                        <p class="text-lg text-gray-900">{{ $testDrive->user->email }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Nomor Telepon</label>
                                        <p class="text-lg text-gray-900">{{ $testDrive->phone }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Alamat</label>
                                        <p class="text-lg text-gray-900">Showroom AutoDealer, Jl. Sudirman No. 123</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Mobil</h3>
                                <div class="bg-blue-50 p-4 rounded-lg space-y-3">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Nama Mobil</label>
                                        <p class="text-lg font-semibold text-gray-900">{{ $testDrive->car->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Tipe</label>
                                        <p class="text-lg text-gray-900">{{ $testDrive->car->type }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Harga</label>
                                        <p class="text-lg font-semibold text-red-600">Rp {{ number_format($testDrive->car->price, 0, ',', '.') }}</p>
                                    </div>
                                    @if($testDrive->car->image)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Gambar Mobil</label>
                                        <img src="{{ asset('storage/' . $testDrive->car->image) }}" alt="{{ $testDrive->car->name }}" class="w-full h-32 object-cover rounded mt-2">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Test Drive -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Test Drive</h3>
                                <div class="bg-green-50 p-4 rounded-lg space-y-3">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Kode Tiket</label>
                                        <p class="text-lg font-mono font-semibold text-gray-900">{{ $testDrive->ticket_code }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Tanggal Test Drive</label>
                                        <p class="text-lg text-gray-900">{{ date('d/m/Y', strtotime($testDrive->preferred_date)) }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Waktu</label>
                                        <p class="text-lg text-gray-900">{{ $testDrive->preferred_time }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Status</label>
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                            {{ $testDrive->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($testDrive->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($testDrive->status) }}
                                        </span>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Tanggal Pengajuan</label>
                                        <p class="text-lg text-gray-900">{{ date('d/m/Y H:i', strtotime($testDrive->created_at)) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Aksi -->
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-4">Aksi</h3>
                                <div class="space-y-3">
                                    @if($testDrive->status === 'pending')
                                    <form action="{{ route('admin.testdrives.update-status', $testDrive) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline">
                                            <i class="fas fa-check mr-2"></i>Setujui Test Drive
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.testdrives.update-status', $testDrive) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline">
                                            <i class="fas fa-times mr-2"></i>Tolak Test Drive
                                        </button>
                                    </form>
                                    @else
                                    <div class="text-center py-4">
                                        <p class="text-gray-600">Test drive sudah {{ $testDrive->status === 'approved' ? 'disetujui' : ($testDrive->status === 'rejected' ? 'ditolak' : ($testDrive->status === 'completed' ? 'selesai' : 'diproses')) }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Informasi Sistem -->
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Sistem</h3>
                                <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">ID Test Drive:</span>
                                        <span class="font-medium">#{{ $testDrive->id }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Dibuat:</span>
                                        <span class="font-medium">{{ date('d/m/Y H:i', strtotime($testDrive->created_at)) }}</span>
                                    </div>
                                    @if($testDrive->updated_at != $testDrive->created_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Diupdate:</span>
                                        <span class="font-medium">{{ date('d/m/Y H:i', strtotime($testDrive->updated_at)) }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 