<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Promo;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function __construct()
    {
        // Hanya method index dan show yang bisa diakses publik
        $this->middleware('auth')->except(['index', 'show']);
        // Method create, store, edit, update, destroy hanya untuk admin
        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource (daftar mobil).
     */
    public function index(Request $request)
    {
        $query = Car::with('promo');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by availability
        if ($request->filled('available')) {
            if ($request->available === 'in_stock') {
                $query->where('stock', '>', 0);
            } elseif ($request->available === 'out_of_stock') {
                $query->where('stock', 0);
            }
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->latest();
        }

        $cars = $query->paginate(12);
        
        // Get filter options for the view
        $types = Car::distinct()->pluck('type')->filter();
        $priceRange = [
            'min' => Car::min('price'),
            'max' => Car::max('price')
        ];

        // Get active promos for display
        $activePromos = Promo::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
        
        // Jika user adalah admin, redirect ke admin dashboard
        // if (auth()->check() && auth()->user()->hasRole('admin')) {
        //     return redirect()->route('admin.cars.index');
        // }
        
        return view('cars.index', compact('cars', 'types', 'priceRange', 'activePromos'));
    }

    /**
     * Show the form for creating a new resource (form tambah mobil).
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created resource in storage (simpan mobil baru).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . (date('Y')+1),
            'type' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'brand', 'model', 'year', 'type', 'price', 'stock', 'description']);

        // Handle main image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        Car::create($data);
        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil ditambahkan!');
    }

    /**
     * Display the specified resource (detail mobil).
     */
    public function show($id)
    {
        $car = Car::with(['testDrives', 'purchases'])->findOrFail($id);
        
        // Get related cars (same type)
        $relatedCars = Car::where('id', '!=', $car->id)
            ->where('type', $car->type)
            ->limit(4)
            ->get();

        // Get active promos
        $activePromos = Promo::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('cars.show', compact('car', 'relatedCars', 'activePromos'));
    }

    /**
     * Show the form for editing the specified resource (edit mobil).
     */
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage (update data mobil).
     */
    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        // Jika hanya update stok
        if ($request->has('stock') && count($request->all()) === 2) { // stock + _method
            $request->validate([
                'stock' => 'required|integer|min:0',
            ]);
            $car->update(['stock' => $request->stock]);
            return redirect()->back()->with('success', 'Stok mobil berhasil diupdate!');
        }

        // Update full data
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . (date('Y')+1),
            'type' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'brand', 'model', 'year', 'type', 'price', 'stock', 'description']);
        $data['updated_by'] = auth()->id();

        // Handle main image
        if ($request->hasFile('image')) {
            // Delete old image
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($data);
        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage (hapus mobil).
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        
        // Check if car has related data
        $hasTestDrives = $car->testDrives()->exists();
        $hasPurchases = $car->purchases()->exists();
        
        if ($hasTestDrives || $hasPurchases) {
            return redirect()->route('admin.cars.index')->with('error', 'Tidak dapat menghapus mobil yang memiliki data terkait!');
        }

        // Delete images
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }
        
        if ($car->images) {
            $images = json_decode($car->images, true);
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $car->delete();
        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil dihapus!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
    {
        $car = Car::findOrFail($id);
        $car->update(['is_featured' => !$car->is_featured]);
        
        $status = $car->is_featured ? 'ditampilkan' : 'disembunyikan';
        return redirect()->back()->with('success', "Mobil berhasil {$status} dari featured!");
    }

    /**
     * Get car statistics for admin dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_cars' => Car::count(),
            'available_cars' => Car::where('stock', '>', 0)->count(),
            'out_of_stock' => Car::where('stock', 0)->count(),
            'featured_cars' => Car::where('is_featured', true)->count(),
            'total_value' => Car::sum(\DB::raw('price * stock'))
        ];

        return response()->json($stats);
    }

    /**
     * Search cars for AJAX requests
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $cars = Car::where('name', 'like', "%{$query}%")
            ->orWhere('type', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'type', 'price', 'image']);

        return response()->json($cars);
    }
}
