<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Car;
use App\Models\Promo;
use App\Models\Stnk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
        $this->middleware('role:admin')->only(['index', 'show', 'destroy', 'updateStatus']);
    }

    // Tampilkan form pembelian mobil
    public function form(Car $car)
    {
        // Get active promos
        $activePromos = Promo::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('purchase.form', compact('car', 'activePromos'));
    }

    // Proses dan simpan pembelian mobil
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'payment_method' => 'required|in:cash,credit',
            'ktp_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'npwp_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'team' => 'required|in:WARRIOR,RAIDON,KSYOW,ANDUONOHU,KONSEL,UNAHA',
            'whatsapp_number' => 'required|string|max:20',
            'promo_id' => 'nullable|exists:promos,id',
            'down_payment' => 'nullable|numeric|min:0',
            'loan_term' => 'nullable|integer|min:12|max:60',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Check if car is available
        $car = Car::find($request->car_id);
        if ($car->stock <= 0) {
            return redirect()->back()->with('error', 'Mobil tidak tersedia untuk pembelian!');
        }

        // Calculate total price
        $totalPrice = $car->price;
        $discountAmount = 0;
        $promoId = null;

        // Apply promo if selected
        if ($request->filled('promo_id')) {
            $promo = Promo::find($request->promo_id);
            
            if ($promo && $promo->is_active && 
                $promo->start_date <= now() && 
                $promo->end_date >= now()) {
                
                // Check minimum purchase
                if (!$promo->minimum_purchase || $totalPrice >= $promo->minimum_purchase) {
                    $discountAmount = ($totalPrice * $promo->discount_percentage) / 100;
                    
                    // Apply maximum discount limit
                    if ($promo->maximum_discount && $discountAmount > $promo->maximum_discount) {
                        $discountAmount = $promo->maximum_discount;
                    }
                    
                    $totalPrice -= $discountAmount;
                    $promoId = $promo->id;
                }
            }
        }

        // Handle file uploads
        $ktp = $request->file('ktp_photo')->store('ktp', 'public');
        $npwp = $request->file('npwp_photo') ? $request->file('npwp_photo')->store('npwp', 'public') : null;

        $purchase = Purchase::create([
            'user_id' => Auth::id(),
            'car_id' => $request->car_id,
            'promo_id' => $promoId,
            'payment_method' => $request->payment_method,
            'ktp_photo' => $ktp,
            'npwp_photo' => $npwp,
            'team' => $request->team,
            'status' => 'pending',
            'whatsapp_number' => $request->whatsapp_number,
            'down_payment' => $request->down_payment,
            'loan_term' => $request->loan_term,
            'notes' => $request->notes,
            'original_price' => $car->price,
            'discount_amount' => $discountAmount,
            'total_price' => $totalPrice,
            'ticket_code' => Purchase::generateTicketCode()
        ]);

        // Create STNK record
        Stnk::create([
            'purchase_id' => $purchase->id,
            'status' => 'pending',
            'requested_at' => now()
        ]);

        // Send notification email to admin
        try {
            $admins = \App\Models\User::role('admin')->get();
            foreach ($admins as $admin) {
                Mail::send('emails.new-purchase', ['purchase' => $purchase], function($message) use ($admin, $purchase) {
                    $message->to($admin->email, $admin->name)
                            ->subject('Pembelian Baru - PT. Makassar Raya Motor Cabang Kendari');
                });
            }
            // Send notification email to superadmin
            $superadmins = \App\Models\User::role('superadmin')->get();
            foreach ($superadmins as $superadmin) {
                Mail::send('emails.report-to-superadmin', ['purchase' => $purchase], function($message) use ($superadmin, $purchase) {
                    $message->to($superadmin->email, $superadmin->name)
                            ->subject('Laporan Pembelian Baru - PT. Makassar Raya Motor Cabang Kendari');
                });
            }
        } catch (\Exception $e) {
            // Log error but don't fail the purchase creation
        }

        // Setelah proses pembelian selesai
        return redirect()->route('beli.success')->with('success', 'Pengajuan pembelian Anda telah terkirim. Silakan tunggu konfirmasi dari admin.');
    }

    // Tampilkan daftar pembelian (untuk admin)
    public function index(Request $request)
    {
        $query = Purchase::with('user', 'car', 'promo');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by team
        if ($request->filled('team')) {
            $query->where('team', $request->team);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('created_at', '<=', $request->end_date);
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

        $purchases = $query->latest()->paginate(15);

        // Statistics
        $totalPurchases = Purchase::count();
        $pendingPurchases = Purchase::where('status', 'pending')->count();
        $approvedPurchases = Purchase::where('status', 'approved')->count();
        $completedPurchases = Purchase::where('status', 'completed')->count();
        $cancelledPurchases = Purchase::where('status', 'cancelled')->count();
        $totalRevenue = Purchase::where('status', 'completed')->sum('total_price');

        return view('admin.purchases.index', compact(
            'purchases',
            'totalPurchases',
            'pendingPurchases',
            'approvedPurchases',
            'completedPurchases',
            'cancelledPurchases',
            'totalRevenue'
        ));
    }

    // Detail pembelian (untuk admin)
    public function show(Purchase $purchase)
    {
        return view('admin.purchases.show', compact('purchase'));
    }

    // Update status pembelian (untuk admin)
    public function updateStatus(Request $request, Purchase $purchase)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,completed,cancelled',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $oldStatus = $purchase->status;
        $newStatus = $request->status;

        $purchase->update([
            'status' => $newStatus,
            'admin_notes' => $request->admin_notes,
            'processed_at' => now(),
            'processed_by' => auth()->id()
        ]);

        // Update car stock if completed
        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            $purchase->car->decrement('stock');
        } elseif ($oldStatus === 'completed' && $newStatus !== 'completed') {
            $purchase->car->increment('stock');
        }

        // Update STNK status
        if ($stnk = $purchase->stnk) {
            if ($newStatus === 'approved') {
                $stnk->update(['status' => 'processing']);
            } elseif ($newStatus === 'completed') {
                $stnk->update(['status' => 'completed']);
            } elseif ($newStatus === 'cancelled') {
                $stnk->update(['status' => 'cancelled']);
            }
        }

        // Send notification email to customer
        try {
            Mail::send('emails.purchase-status-update', ['purchase' => $purchase], function($message) use ($purchase) {
                $message->to($purchase->user->email, $purchase->user->name)
                        ->subject('Update Status Pembelian - PT. Makassar Raya Motor Cabang Kendari');
            });
        } catch (\Exception $e) {
            // Log error but don't fail the status update
        }

        // Kirim notifikasi ke superadmin jika status approved atau completed
        if (in_array($newStatus, ['approved', 'completed'])) {
            try {
                $superadmins = \App\Models\User::role('superadmin')->get();
                foreach ($superadmins as $superadmin) {
                    Mail::send('emails.report-to-superadmin', ['purchase' => $purchase], function($message) use ($superadmin, $purchase) {
                        $message->to($superadmin->email, $superadmin->name)
                                ->subject('Laporan Penjualan Baru - PT. Makassar Raya Motor Cabang Kendari');
                    });
                }
            } catch (\Exception $e) {
                // Log error but don't fail the status update
            }
        }

        $statusText = [
            'pending' => 'pending',
            'approved' => 'disetujui',
            'completed' => 'selesai',
            'cancelled' => 'dibatalkan'
        ];

        return redirect()->back()->with('success', "Status pembelian berhasil diubah menjadi {$statusText[$newStatus]}!");
    }

    // Hapus pembelian (untuk admin)
    public function destroy(Purchase $purchase)
    {
        // Delete associated files
        if ($purchase->ktp_photo) {
            Storage::disk('public')->delete($purchase->ktp_photo);
        }
        if ($purchase->npwp_photo) {
            Storage::disk('public')->delete($purchase->npwp_photo);
        }

        // Restore car stock if purchase was completed
        if ($purchase->status === 'completed') {
            $purchase->car->increment('stock');
        }

        $purchase->delete();
        return redirect()->route('admin.purchases.index')->with('success', 'Pembelian berhasil dihapus!');
    }

    // Get purchase statistics for dashboard
    public function getStats()
    {
        $stats = [
            'total' => Purchase::count(),
            'pending' => Purchase::where('status', 'pending')->count(),
            'approved' => Purchase::where('status', 'approved')->count(),
            'completed' => Purchase::where('status', 'completed')->count(),
            'cancelled' => Purchase::where('status', 'cancelled')->count(),
            'total_revenue' => Purchase::where('status', 'completed')->sum('total_price'),
            'today' => Purchase::whereDate('created_at', today())->count(),
            'this_week' => Purchase::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => Purchase::whereMonth('created_at', now()->month)->count()
        ];

        return response()->json($stats);
    }

    // Calculate monthly payments for credit purchases
    public function calculateMonthlyPayment(Request $request)
    {
        $request->validate([
            'car_price' => 'required|numeric|min:0',
            'down_payment' => 'required|numeric|min:0',
            'loan_term' => 'required|integer|min:12|max:60',
            'interest_rate' => 'required|numeric|min:0|max:100'
        ]);

        $carPrice = $request->car_price;
        $downPayment = $request->down_payment;
        $loanTerm = $request->loan_term;
        $interestRate = $request->interest_rate / 100;

        $loanAmount = $carPrice - $downPayment;
        $monthlyInterest = $interestRate / 12;
        $totalPayments = $loanTerm;

        if ($monthlyInterest > 0) {
            $monthlyPayment = $loanAmount * ($monthlyInterest * pow(1 + $monthlyInterest, $totalPayments)) / (pow(1 + $monthlyInterest, $totalPayments) - 1);
        } else {
            $monthlyPayment = $loanAmount / $totalPayments;
        }

        $totalPayment = $monthlyPayment * $totalPayments;
        $totalInterest = $totalPayment - $loanAmount;

        return response()->json([
            'loan_amount' => $loanAmount,
            'monthly_payment' => $monthlyPayment,
            'total_payment' => $totalPayment,
            'total_interest' => $totalInterest
        ]);
    }
}

