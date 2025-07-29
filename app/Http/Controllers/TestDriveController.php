<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestDrive;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TestDriveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['form']);
        $this->middleware('role:admin')->only(['index', 'show', 'destroy', 'updateStatus']);
    }

    // Tampilkan form test drive
    public function form()
    {
        $cars = Car::where('stock', '>', 0)->get();
        return view('testdrives.form', compact('cars'));
    }

    // Proses penyimpanan form test drive
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'test_drive_date' => 'required|date|after_or_equal:today',
            'test_drive_time' => 'required',
            'message' => 'nullable|string|max:1000'
        ]);

        // Check if user already has a pending test drive for this car
        $existingTestDrive = TestDrive::where('user_id', Auth::id())
            ->where('car_id', $request->car_id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingTestDrive) {
            return redirect()->back()->with('error', 'Anda sudah memiliki test drive yang pending untuk mobil ini!');
        }

        // Check if car is available
        $car = Car::find($request->car_id);
        if ($car->stock <= 0) {
            return redirect()->back()->with('error', 'Mobil tidak tersedia untuk test drive!');
        }

        $code = 'TD' . now()->format('YmdHis') . Auth::id();

        $testDrive = TestDrive::create([
            'user_id' => Auth::id(),
            'car_id' => $request->car_id,
            'phone' => $request->phone,
            'preferred_date' => $request->test_drive_date,
            'preferred_time' => $request->test_drive_time,
            'notes' => $request->message,
            'ticket_code' => $code,
            'status' => 'pending'
        ]);

        // Send notification email to admin
        try {
            $admins = \App\Models\User::role('admin')->get();
            foreach ($admins as $admin) {
                Mail::send('emails.new-test-drive', ['testDrive' => $testDrive], function($message) use ($admin, $testDrive) {
                    $message->to($admin->email, $admin->name)
                            ->subject('Test Drive Baru - PT. Makassar Raya Motor Cabang Kendari');
                });
            }
        } catch (\Exception $e) {
            // Log error but don't fail the test drive creation
        }

        // Get car name for session
        $car = Car::find($request->car_id);
        
        return redirect()->route('testdrive.success')->with([
            'code' => $code,
            'phone' => $request->phone,
            'car_name' => $car->name,
            'test_drive_date' => $request->test_drive_date,
            'test_drive_time' => $request->test_drive_time,
            'message' => $request->message
        ]);
    }

    // Halaman sukses test drive
    public function success()
    {
        $code = session('code');
        return view('testdrives.success', compact('code'));
    }

    // Tampilkan daftar test drive (untuk admin)
    public function index(Request $request)
    {
        $query = TestDrive::with('user', 'car');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('preferred_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('preferred_date', '<=', $request->end_date);
        }

        // Search by user name or ticket code
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $testdrives = $query->latest()->paginate(15);

        // Statistics
        $totalTestDrives = TestDrive::count();
        $pendingTestDrives = TestDrive::where('status', 'pending')->count();
        $approvedTestDrives = TestDrive::where('status', 'approved')->count();
        $completedTestDrives = TestDrive::where('status', 'completed')->count();
        $rejectedTestDrives = TestDrive::where('status', 'rejected')->count();

        return view('admin.testdrives.index', compact(
            'testdrives',
            'totalTestDrives',
            'pendingTestDrives',
            'approvedTestDrives',
            'completedTestDrives',
            'rejectedTestDrives'
        ));
    }

    // Detail test drive (untuk admin)
    public function show(TestDrive $testDrive)
    {
        return view('admin.testdrives.show', compact('testDrive'));
    }

    // Update status test drive (untuk admin)
    public function updateStatus(Request $request, TestDrive $testDrive)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,completed,rejected',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $oldStatus = $testDrive->status;
        $newStatus = $request->status;

        $testDrive->update([
            'status' => $newStatus,
            'admin_notes' => $request->admin_notes,
            'processed_at' => now(),
            'processed_by' => auth()->id()
        ]);

        // Send notification email to customer
        try {
            Mail::send('emails.test-drive-status-update', ['testDrive' => $testDrive], function($message) use ($testDrive) {
                $message->to($testDrive->user->email, $testDrive->user->name)
                        ->subject('Update Status Test Drive - PT. Makassar Raya Motor Cabang Kendari');
            });
        } catch (\Exception $e) {
            // Log error but don't fail the status update
        }

        $statusText = [
            'pending' => 'pending',
            'approved' => 'disetujui',
            'completed' => 'selesai',
            'rejected' => 'ditolak'
        ];

        return redirect()->back()->with('success', "Status test drive berhasil diubah menjadi {$statusText[$newStatus]}!");
    }

    // Hapus test drive (untuk admin)
    public function destroy(TestDrive $testDrive)
    {
        $testDrive->delete();
        return redirect()->route('admin.testdrives.index')->with('success', 'Test drive berhasil dihapus!');
    }

    // Get test drive statistics for dashboard
    public function getStats()
    {
        $stats = [
            'total' => TestDrive::count(),
            'pending' => TestDrive::where('status', 'pending')->count(),
            'approved' => TestDrive::where('status', 'approved')->count(),
            'completed' => TestDrive::where('status', 'completed')->count(),
            'rejected' => TestDrive::where('status', 'rejected')->count(),
            'today' => TestDrive::whereDate('created_at', today())->count(),
            'this_week' => TestDrive::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => TestDrive::whereMonth('created_at', now()->month)->count()
        ];

        return response()->json($stats);
    }
}
