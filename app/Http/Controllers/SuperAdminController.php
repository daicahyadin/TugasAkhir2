<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Promo;
use App\Models\TestDrive;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Stnk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        // Basic statistics
        $totalCars = Car::count();
        $totalPromos = Promo::count();
        $totalTestDrives = TestDrive::count();
        $totalPurchases = Purchase::count();
        $totalAdmins = User::role('admin')->count();
        $totalCustomers = User::role('customer')->count();

        // Recent activities
        $recentRegistrations = User::role('customer')->latest()->take(5)->get();
        $recentTestDrives = TestDrive::with('user', 'car')->latest()->take(5)->get();
        $recentPurchases = Purchase::with('user', 'car')->latest()->take(5)->get();

        // Financial statistics
        $totalRevenue = Purchase::where('status', 'completed')->sum('total_price');
        $monthlyRevenue = Purchase::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');
        $pendingRevenue = Purchase::where('status', 'pending')->sum('total_price');

        // STNK statistics
        $pendingStnk = Stnk::where('status', 'pending')->count();
        $completedStnk = Stnk::where('status', 'completed')->count();

        return view('superadmin.dashboard', compact(
            'totalCars',
            'totalPromos',
            'totalTestDrives', 
            'totalPurchases',
            'totalAdmins',
            'totalCustomers',
            'recentRegistrations',
            'recentTestDrives',
            'recentPurchases',
            'totalRevenue',
            'monthlyRevenue',
            'pendingRevenue',
            'pendingStnk',
            'completedStnk'
        ));
    }

    public function users(Request $request)
    {
        $query = User::with('roles');

        // Pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = \Spatie\Permission\Models\Role::all();

        return view('superadmin.users', compact('users', 'roles'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,customer',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'job' => 'nullable|string|max:100'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'job' => $request->job,
            'email_verified_at' => now(),
            'is_verified' => true,
        ]);

        $user->assignRole($request->role);

        // Send welcome email
        try {
            Mail::send('emails.welcome', ['user' => $user], function($message) use ($user) {
                $message->to($user->email, $user->name)
                        ->subject('Selamat Datang di PT. Makassar Raya Motor Cabang Kendari');
            });
        } catch (\Exception $e) {
            // Log error but don't fail the user creation
        }

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,customer',
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update role
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'User berhasil diupdate!');
    }

    public function destroyUser(User $user)
    {
        if ($user->hasRole('superadmin')) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus Super Admin!');
        }

        // Check if user has any related data
        $hasTestDrives = TestDrive::where('user_id', $user->id)->exists();
        $hasPurchases = Purchase::where('user_id', $user->id)->exists();

        if ($hasTestDrives || $hasPurchases) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus user yang memiliki data terkait!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }

    public function stnkStatus()
    {
        $stnks = Stnk::with('purchase.user', 'purchase.car')->latest()->get();
        
        return view('superadmin.stnk-status', compact('stnks'));
    }

    public function updateStnkStatus(Request $request, Stnk $stnk)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,rejected',
            'plate_number' => 'nullable|string|max:20',
            'estimated_completion' => 'nullable|date',
            'notes' => 'nullable|string|max:500'
        ]);

        $stnk->update([
            'status' => $request->status,
            'plate_number' => $request->plate_number,
            'estimated_completion' => $request->estimated_completion,
            'notes' => $request->notes,
            'processed_at' => now()
        ]);

        // Send notification to customer
        try {
            Mail::send('emails.stnk-status-update', ['stnk' => $stnk], function($message) use ($stnk) {
                $message->to($stnk->purchase->user->email, $stnk->purchase->user->name)
                        ->subject('Update Status STNK - PT. Makassar Raya Motor Cabang Kendari');
            });
        } catch (\Exception $e) {
            // Log error but don't fail the update
        }

        // Kirim notifikasi ke superadmin
        try {
            $superadmins = \App\Models\User::role('superadmin')->get();
            foreach ($superadmins as $superadmin) {
                Mail::send('emails.stnk-status-update', ['stnk' => $stnk], function($message) use ($superadmin, $stnk) {
                    $message->to($superadmin->email, $superadmin->name)
                            ->subject('Laporan Update Status STNK - PT. Makassar Raya Motor Cabang Kendari');
                });
            }
        } catch (\Exception $e) {
            // Log error but don't fail the update
        }

        return redirect()->back()->with('success', 'Status STNK berhasil diperbarui!');
    }

    public function systemStats()
    {
        // Monthly statistics for charts
        $monthlyStats = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyStats[$i] = [
                'test_drives' => TestDrive::whereMonth('created_at', $i)->count(),
                'purchases' => Purchase::whereMonth('created_at', $i)->count(),
                'revenue' => Purchase::whereMonth('created_at', $i)
                    ->where('status', 'completed')
                    ->sum('total_price'),
                'registrations' => User::role('customer')
                    ->whereMonth('created_at', $i)
                    ->count()
            ];
        }

        return response()->json($monthlyStats);
    }
} 