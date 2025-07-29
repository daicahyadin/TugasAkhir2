<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\TestDrive;
use App\Models\Purchase;
use App\Models\Promo;
use App\Models\Car;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Dashboard customer: test drive, pembelian, promo aktif
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();
        
        // Redirect based on user role
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($user->hasRole('superadmin')) {
            return redirect()->route('superadmin.dashboard');
        }
        
        // Customer dashboard
        $testDrives = TestDrive::where('user_id', $user->id)->with('car')->latest()->get();
        $purchases = Purchase::where('user_id', $user->id)->with('car', 'promo')->latest()->get();
        $promos = Promo::where('type', 'promo')->where('is_active', true)->where('start_date', '<=', now())->where('end_date', '>=', now())->latest()->take(3)->get();
        $events = Promo::where('type', 'event')->where('is_active', true)->where('start_date', '<=', now())->where('end_date', '>=', now())->latest()->take(3)->get();
        $news = Promo::where('type', 'news')->where('is_active', true)->where('start_date', '<=', now())->where('end_date', '>=', now())->latest()->take(3)->get();
        $cars = Car::where('stock', '>', 0)->latest()->get();
        return view('dashboard', compact('testDrives', 'purchases', 'promos', 'events', 'news', 'cars'));
    }
}
