<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Promo;
use App\Models\TestDrive;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Basic statistics
        $totalCars = Car::count();
        $totalPromos = Promo::count();
        $totalTestDrives = TestDrive::count();
        $totalPurchases = Purchase::count();
        $pendingTestDrives = TestDrive::where('status', 'pending')->count();
        $pendingPurchases = Purchase::where('status', 'pending')->count();
        $totalCustomers = User::role('customer')->count();

        // Recent activities
        $recentTestDrives = TestDrive::with('user', 'car')->latest()->take(5)->get();
        $recentPurchases = Purchase::with('user', 'car')->latest()->take(5)->get();
        $recentCars = Car::latest()->take(5)->get();

        // Monthly statistics
        $monthlyTestDrives = TestDrive::whereMonth('created_at', now()->month)->count();
        $monthlyPurchases = Purchase::whereMonth('created_at', now()->month)->count();
        $monthlyRevenue = Purchase::whereMonth('created_at', now()->month)
            ->where('status', 'completed')
            ->sum('total_price');

        return view('admin.dashboard', compact(
            'totalCars',
            'totalPromos', 
            'totalTestDrives',
            'totalPurchases',
            'pendingTestDrives',
            'pendingPurchases',
            'totalCustomers',
            'recentTestDrives',
            'recentPurchases',
            'recentCars',
            'monthlyTestDrives',
            'monthlyPurchases',
            'monthlyRevenue'
        ));
    }

    public function carStats()
    {
        $carsByType = Car::selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->get();

        $carsByBrand = Car::selectRaw('brand, count(*) as count')
            ->groupBy('brand')
            ->get();

        return response()->json([
            'byType' => $carsByType,
            'byBrand' => $carsByBrand
        ]);
    }

    public function salesStats()
    {
        $monthlySales = Purchase::where('status', 'completed')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(total_price) as revenue')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->get();

        return response()->json($monthlySales);
    }
} 