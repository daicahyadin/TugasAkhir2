<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Promo;
use App\Models\TestDrive;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Stnk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $testDrives = TestDrive::with('user', 'car')->latest()->get();
        $purchases = Purchase::with('user', 'car')->latest()->get();
        
        // Statistics for dashboard
        $totalTestDrives = TestDrive::count();
        $totalPurchases = Purchase::count();
        $pendingTestDrives = TestDrive::where('status', 'pending')->count();
        $pendingPurchases = Purchase::where('status', 'pending')->count();
        $completedPurchases = Purchase::where('status', 'completed')->count();
        $totalRevenue = Purchase::where('status', 'completed')->sum('total_price');
        
        // Monthly statistics
        $monthlyStats = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyStats[$i] = [
                'test_drives' => TestDrive::whereMonth('created_at', $i)->count(),
                'purchases' => Purchase::whereMonth('created_at', $i)->count(),
                'revenue' => Purchase::whereMonth('created_at', $i)
                    ->where('status', 'completed')
                    ->sum('total_price')
            ];
        }
        
        return view('admin.reports.index', compact(
            'testDrives', 
            'purchases',
            'totalTestDrives',
            'totalPurchases',
            'pendingTestDrives',
            'pendingPurchases',
            'completedPurchases',
            'totalRevenue',
            'monthlyStats'
        ));
    }

    public function download(Request $request)
    {
        $type = $request->get('type', 'all');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $status = $request->get('status');

        $query = null;
        $title = '';

        switch ($type) {
            case 'testdrives':
                $query = TestDrive::with('user', 'car');
                $title = 'Laporan Test Drive';
                break;
            case 'purchases':
                $query = Purchase::with('user', 'car');
                $title = 'Laporan Pembelian';
                break;
            case 'cars':
                $query = Car::query();
                $title = 'Laporan Mobil';
                break;
            case 'promos':
                $query = Promo::query();
                $title = 'Laporan Promo';
                break;
            case 'all':
            default:
                $testDrives = TestDrive::with('user', 'car')->get();
                $purchases = Purchase::with('user', 'car')->get();
                $cars = Car::all();
                $promos = Promo::all();
                $title = 'Laporan Lengkap';
                break;
        }

        if ($query) {
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
            
            if ($status && in_array($type, ['testdrives', 'purchases'])) {
                $query->where('status', $status);
            }
        }

        if ($type !== 'all') {
            $data = $query->get();
        } else {
            $data = [
                'testDrives' => $testDrives,
                'purchases' => $purchases,
                'cars' => $cars,
                'promos' => $promos
            ];
        }

        $pdf = PDF::loadView('admin.reports.pdf', compact('data', 'title', 'type', 'startDate', 'endDate', 'status'));
        
        return $pdf->download("laporan-{$type}-" . date('Y-m-d') . '.pdf');
    }

    public function sendToSuperAdmin(Request $request)
    {
        $request->validate([
            'type' => 'required|in:testdrives,purchases,all',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string|max:500'
        ]);

        $type = $request->type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $notes = $request->notes;

        $data = [];
        $title = 'Laporan Admin MRM';

        switch ($type) {
            case 'testdrives':
                $query = TestDrive::with('user', 'car');
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
                $data = $query->get();
                break;
            case 'purchases':
                $query = Purchase::with('user', 'car');
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
                $data = $query->get();
                break;
            case 'all':
            default:
                $testDrives = TestDrive::with('user', 'car')->get();
                $purchases = Purchase::with('user', 'car')->get();
                $data = [
                    'testDrives' => $testDrives,
                    'purchases' => $purchases
                ];
                break;
        }

        $pdf = PDF::loadView('admin.reports.pdf', [
            'data' => $data,
            'title' => $title,
            'type' => $type,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'notes' => $notes
        ]);

        // Send email to super admin
        try {
            $superAdmins = User::role('superadmin')->get();
            
            foreach ($superAdmins as $superAdmin) {
                Mail::send('emails.report-to-superadmin', [
                    'admin' => Auth::user(),
                    'superAdmin' => $superAdmin,
                    'type' => $type,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'notes' => $notes
                ], function($message) use ($superAdmin, $type, $pdf) {
                    $message->to($superAdmin->email, $superAdmin->name)
                            ->subject("Laporan {$type} dari Admin - PT. Makassar Raya Motor Cabang Kendari")
                            ->attachData($pdf->output(), "laporan-{$type}-" . date('Y-m-d') . '.pdf');
                });
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim laporan: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Laporan berhasil dikirim ke Super Admin!');
    }

    public function superAdminReports()
    {
        $testDrives = TestDrive::with('user', 'car')->latest()->get();
        $purchases = Purchase::with('user', 'car')->latest()->get();
        $customers = User::role('customer')->latest()->get();
        $admins = User::role('admin')->latest()->get();
        
        // Statistics
        $totalRevenue = Purchase::where('status', 'completed')->sum('total_price');
        $monthlyRevenue = Purchase::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');
        $totalCustomers = User::role('customer')->count();
        $totalAdmins = User::role('admin')->count();
        $pendingStnk = Stnk::where('status', 'pending')->count();
        
        return view('superadmin.reports.index', compact(
            'testDrives', 
            'purchases', 
            'customers',
            'admins',
            'totalRevenue',
            'monthlyRevenue',
            'totalCustomers',
            'totalAdmins',
            'pendingStnk'
        ));
    }

    public function superAdminDownload(Request $request)
    {
        $type = $request->get('type', 'all');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $status = $request->get('status');

        $data = [];
        $title = 'Laporan Super Admin MRM';

        switch ($type) {
            case 'testdrives':
                $query = TestDrive::with('user', 'car');
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
                if ($status) {
                    $query->where('status', $status);
                }
                $data = $query->get();
                break;
            case 'purchases':
                $query = Purchase::with('user', 'car');
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
                if ($status) {
                    $query->where('status', $status);
                }
                $data = $query->get();
                break;
            case 'customers':
                $query = User::role('customer');
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
                $data = $query->get();
                break;
            case 'admins':
                $query = User::role('admin');
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
                $data = $query->get();
                break;
            case 'stnk':
                $query = Stnk::with('purchase.user', 'purchase.car');
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
                if ($status) {
                    $query->where('status', $status);
                }
                $data = $query->get();
                break;
            case 'all':
            default:
                $testDrives = TestDrive::with('user', 'car')->get();
                $purchases = Purchase::with('user', 'car')->get();
                $customers = User::role('customer')->get();
                $admins = User::role('admin')->get();
                $stnks = Stnk::with('purchase.user', 'purchase.car')->get();
                $data = [
                    'testDrives' => $testDrives,
                    'purchases' => $purchases,
                    'customers' => $customers,
                    'admins' => $admins,
                    'stnks' => $stnks
                ];
                break;
        }

        $pdf = PDF::loadView('superadmin.reports.pdf', compact('data', 'title', 'type', 'startDate', 'endDate', 'status'));
        
        return $pdf->download("laporan-superadmin-{$type}-" . date('Y-m-d') . '.pdf');
    }

    public function getStats(Request $request)
    {
        $period = $request->get('period', 'month');
        
        switch ($period) {
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
        }

        $stats = [
            'test_drives' => TestDrive::whereBetween('created_at', [$startDate, $endDate])->count(),
            'purchases' => Purchase::whereBetween('created_at', [$startDate, $endDate])->count(),
            'revenue' => Purchase::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'completed')
                ->sum('total_price'),
            'customers' => User::role('customer')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count()
        ];

        return response()->json($stats);
    }
} 