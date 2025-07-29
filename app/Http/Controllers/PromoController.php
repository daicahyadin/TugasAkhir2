<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();
        
        // Statistics
        $totalPromos = Promo::count();
        $activePromos = Promo::where('is_active', true)->count();
        $expiredPromos = Promo::where('end_date', '<', now())->count();
        $upcomingPromos = Promo::where('start_date', '>', now())->count();
        
        return view('admin.promos.index', compact('promos', 'totalPromos', 'activePromos', 'expiredPromos', 'upcomingPromos'));
    }

    public function create()
    {
        $cars = \App\Models\Car::all();
        return view('admin.promos.create', compact('cars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'terms_conditions' => 'nullable|string',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'type' => 'required|in:promo,event,news',
            'car_id' => 'nullable|exists:cars,id',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('promos', 'public');
            $data['image'] = $imagePath;
        }

        // Set default values
        $data['is_active'] = $request->has('is_active');
        $data['created_by'] = auth()->id();

        $promo = Promo::create($data);

        // If car_id is set, update the car's promo_id
        if ($request->filled('car_id')) {
            \App\Models\Car::where('id', $request->car_id)->update(['promo_id' => $promo->id]);
        }

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil ditambahkan!');
    }

    public function show(Promo $promo)
    {
        // Get related purchases that used this promo
        $purchases = \App\Models\Purchase::where('promo_id', $promo->id)->with('user', 'car')->get();
        
        return view('admin.promos.show', compact('promo', 'purchases'));
    }

    public function edit(Promo $promo)
    {
        $cars = \App\Models\Car::all();
        return view('admin.promos.edit', compact('promo', 'cars'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'terms_conditions' => 'nullable|string',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'type' => 'required|in:promo,event,news',
            'car_id' => 'nullable|exists:cars,id',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($promo->image) {
                Storage::disk('public')->delete($promo->image);
            }
            
            $imagePath = $request->file('image')->store('promos', 'public');
            $data['image'] = $imagePath;
        }

        // Set default values
        $data['is_active'] = $request->has('is_active');
        $data['updated_by'] = auth()->id();

        $promo->update($data);

        // If car_id is set, update the car's promo_id
        if ($request->filled('car_id')) {
            \App\Models\Car::where('id', $request->car_id)->update(['promo_id' => $promo->id]);
        }

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil diperbarui!');
    }

    public function destroy(Promo $promo)
    {
        // Check if promo is being used
        $usedInPurchases = \App\Models\Purchase::where('promo_id', $promo->id)->exists();
        
        if ($usedInPurchases) {
            return redirect()->route('admin.promos.index')->with('error', 'Tidak dapat menghapus promo yang sudah digunakan dalam pembelian!');
        }

        // Delete image if exists
        if ($promo->image) {
            Storage::disk('public')->delete($promo->image);
        }

        $promo->delete();

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dihapus!');
    }

    public function toggleStatus(Promo $promo)
    {
        $promo->update([
            'is_active' => !$promo->is_active
        ]);

        $status = $promo->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Promo berhasil {$status}!");
    }

    public function getActivePromos()
    {
        $promos = Promo::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return response()->json($promos);
    }

    public function calculateDiscount(Request $request)
    {
        $request->validate([
            'promo_id' => 'required|exists:promos,id',
            'purchase_amount' => 'required|numeric|min:0'
        ]);

        $promo = Promo::findOrFail($request->promo_id);
        $purchaseAmount = $request->purchase_amount;

        // Check if promo is valid
        if (!$promo->is_active || $promo->start_date > now() || $promo->end_date < now()) {
            return response()->json(['error' => 'Promo tidak valid'], 400);
        }

        // Check minimum purchase
        if ($promo->minimum_purchase && $purchaseAmount < $promo->minimum_purchase) {
            return response()->json([
                'error' => "Minimal pembelian Rp " . number_format($promo->minimum_purchase, 0, ',', '.')
            ], 400);
        }

        // Calculate discount
        $discount = ($purchaseAmount * $promo->discount_percentage) / 100;

        // Apply maximum discount limit
        if ($promo->maximum_discount && $discount > $promo->maximum_discount) {
            $discount = $promo->maximum_discount;
        }

        $finalAmount = $purchaseAmount - $discount;

        return response()->json([
            'original_amount' => $purchaseAmount,
            'discount_amount' => $discount,
            'final_amount' => $finalAmount,
            'discount_percentage' => $promo->discount_percentage
        ]);
    }
} 