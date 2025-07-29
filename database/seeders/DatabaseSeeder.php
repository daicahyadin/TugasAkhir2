<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Car;
use App\Models\Promo;
use App\Models\TestDrive;
use App\Models\Purchase;
use App\Models\Stnk;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Create permissions
        $permissions = [
            'view cars', 'create cars', 'edit cars', 'delete cars',
            'view promos', 'create promos', 'edit promos', 'delete promos',
            'view test drives', 'approve test drives', 'delete test drives',
            'view purchases', 'approve purchases', 'delete purchases',
            'view reports', 'generate reports',
            'manage users', 'view stnk status', 'update stnk status'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $superadminRole->givePermissionTo(Permission::all());
        $adminRole->givePermissionTo([
            'view cars', 'create cars', 'edit cars', 'delete cars',
            'view promos', 'create promos', 'edit promos', 'delete promos',
            'view test drives', 'approve test drives', 'delete test drives',
            'view purchases', 'approve purchases', 'delete purchases',
            'view reports', 'generate reports'
        ]);
        $customerRole->givePermissionTo(['view cars']);

        // Create Super Admin
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@mrm.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_verified' => true,
                'phone' => '081234567890',
                'address' => 'Kendari, Sulawesi Tenggara',
                'job' => 'Super Admin'
            ]
        );
        $superadmin->assignRole('superadmin');

        // Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@mrm.com'],
            [
                'name' => 'Admin MRM',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_verified' => true,
                'phone' => '081234567891',
                'address' => 'Kendari, Sulawesi Tenggara',
                'job' => 'Admin'
            ]
        );
        $admin->assignRole('admin');

        // Create sample customers
        $customers = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '081234567892',
                'address' => 'Jl. Soekarno Hatta No. 123, Kendari',
                'job' => 'Karyawan Swasta'
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '081234567893',
                'address' => 'Jl. Ahmad Yani No. 456, Kendari',
                'job' => 'Wiraswasta'
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'phone' => '081234567894',
                'address' => 'Jl. Sudirman No. 789, Kendari',
                'job' => 'PNS'
            ]
        ];

        foreach ($customers as $customerData) {
            $customer = User::firstOrCreate(
                ['email' => $customerData['email']],
                [
                    'name' => $customerData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_verified' => true,
                    'phone' => $customerData['phone'],
                    'address' => $customerData['address'],
                    'job' => $customerData['job']
                ]
            );
            $customer->assignRole('customer');
        }

        // Create sample cars
        $cars = [
            [
                'name' => 'Toyota Avanza',
                'brand' => 'Toyota',
                'model' => 'Avanza',
                'year' => 2024,
                'type' => 'MPV',
                'price' => 250000000,
                'stock' => 5,
                'description' => 'Mobil keluarga yang nyaman dan irit bahan bakar',
                'specifications' => json_encode([
                    'engine' => '1.3L VVT-i',
                    'transmission' => 'Manual 5-speed',
                    'fuel_type' => 'Bensin',
                    'seats' => 7
                ]),
                'image' => 'avanza.jpg'
            ],
            [
                'name' => 'Honda Brio',
                'brand' => 'Honda',
                'model' => 'Brio',
                'year' => 2024,
                'type' => 'City Car',
                'price' => 180000000,
                'stock' => 3,
                'description' => 'City car yang lincah dan ekonomis',
                'specifications' => json_encode([
                    'engine' => '1.2L i-VTEC',
                    'transmission' => 'CVT',
                    'fuel_type' => 'Bensin',
                    'seats' => 5
                ]),
                'image' => 'brio.jpg'
            ],
            [
                'name' => 'Suzuki Ertiga',
                'brand' => 'Suzuki',
                'model' => 'Ertiga',
                'year' => 2024,
                'type' => 'MPV',
                'price' => 220000000,
                'stock' => 4,
                'description' => 'MPV yang nyaman untuk keluarga',
                'specifications' => json_encode([
                    'engine' => '1.5L K15B',
                    'transmission' => 'Manual 5-speed',
                    'fuel_type' => 'Bensin',
                    'seats' => 7
                ]),
                'image' => 'ertiga.jpg'
            ]
        ];

        foreach ($cars as $carData) {
            Car::create($carData);
        }

        // Create sample promos
        $promos = [
            [
                'title' => 'Promo Akhir Tahun',
                'description' => 'Diskon besar untuk pembelian mobil di akhir tahun',
                'discount_percentage' => 10,
                'minimum_purchase' => 200000000,
                'maximum_discount' => 50000000,
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
                'is_active' => true,
                'type' => 'promo'
            ],
            [
                'title' => 'Event Pameran Mobil',
                'description' => 'Pameran mobil terbesar di Kendari',
                'discount_percentage' => 5,
                'minimum_purchase' => 150000000,
                'maximum_discount' => 25000000,
                'start_date' => now()->addDays(7),
                'end_date' => now()->addDays(14),
                'is_active' => true,
                'type' => 'event'
            ],
            [
                'title' => 'Berita Terbaru',
                'description' => 'Mobil listrik akan hadir di showroom kami',
                'discount_percentage' => 0,
                'minimum_purchase' => 0,
                'maximum_discount' => 0,
                'start_date' => now(),
                'end_date' => now()->addMonths(6),
                'is_active' => true,
                'type' => 'news'
            ]
        ];

        foreach ($promos as $promoData) {
            Promo::create($promoData);
        }

        // Create sample test drives
        $testDrives = [
            [
                'user_id' => 4, // John Doe
                'car_id' => 1, // Toyota Avanza
                'preferred_date' => now()->addDays(3),
                'preferred_time' => '10:00',
                'status' => 'pending',
                'notes' => 'Ingin test drive di pagi hari',
                'ticket_code' => 'TD-' . date('Ymd') . '-001'
            ],
            [
                'user_id' => 5, // Jane Smith
                'car_id' => 2, // Honda Brio
                'preferred_date' => now()->addDays(5),
                'preferred_time' => '14:00',
                'status' => 'approved',
                'notes' => 'Test drive untuk keluarga',
                'ticket_code' => 'TD-' . date('Ymd') . '-002'
            ]
        ];

        foreach ($testDrives as $testDriveData) {
            TestDrive::create($testDriveData);
        }

        // Create sample purchases
        $purchases = [
            [
                'user_id' => 4, // John Doe
                'car_id' => 1, // Toyota Avanza
                'promo_id' => 1, // Promo Akhir Tahun
                'payment_method' => 'cash',
                'ktp_photo' => 'ktp/john_doe.jpg',
                'npwp_photo' => null,
                'team' => 'WARRIOR',
                'status' => 'approved',
                'whatsapp_number' => '081234567892',
                'original_price' => 250000000,
                'discount_amount' => 25000000,
                'total_price' => 225000000,
                'down_payment' => null,
                'loan_term' => null,
                'notes' => 'Pembelian tunai',
                'admin_notes' => 'Dokumen lengkap, disetujui',
                'ticket_code' => 'PUR-20241201-ABC123',
                'processed_at' => now()->subDays(2),
                'processed_by' => 2 // Admin
            ],
            [
                'user_id' => 5, // Jane Smith
                'car_id' => 2, // Honda Brio
                'promo_id' => null,
                'payment_method' => 'credit',
                'ktp_photo' => 'ktp/jane_smith.jpg',
                'npwp_photo' => 'npwp/jane_smith.jpg',
                'team' => 'RAIDON',
                'status' => 'pending',
                'whatsapp_number' => '081234567893',
                'original_price' => 180000000,
                'discount_amount' => 0,
                'total_price' => 180000000,
                'down_payment' => 50000000,
                'loan_term' => 36,
                'notes' => 'Pembelian kredit dengan DP 50 juta',
                'admin_notes' => null,
                'ticket_code' => 'PUR-20241201-DEF456',
                'processed_at' => null,
                'processed_by' => null
            ]
        ];

        foreach ($purchases as $purchaseData) {
            Purchase::create($purchaseData);
        }

        // Create sample STNK records
        $stnks = [
            [
                'purchase_id' => 1, // John Doe's purchase
                'status' => 'processing',
                'plate_number' => 'DB 1234 AB',
                'estimated_completion' => now()->addDays(14),
                'notes' => 'Sedang dalam proses pengurusan',
                'processed_at' => now()->subDays(1)
            ],
            [
                'purchase_id' => 2, // Jane Smith's purchase
                'status' => 'pending',
                'plate_number' => null,
                'estimated_completion' => null,
                'notes' => null,
                'processed_at' => null
            ]
        ];

        foreach ($stnks as $stnkData) {
            Stnk::create($stnkData);
        }
    }
}
