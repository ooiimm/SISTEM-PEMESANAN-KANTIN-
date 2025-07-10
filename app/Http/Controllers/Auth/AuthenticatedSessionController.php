<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // INI ADALAH BARIS KUNCINYA
        // Secara paksa mengarahkan ke halaman login setelah logout.
        return redirect()->route('login'); 
    }

    public function loginAsGuest()
    {
        // Cari user tamu berdasarkan NIM unik yang kita buat di seeder
        $guest = User::where('nim', 'guest_user_account')->first();

        // Jika user tamu tidak ditemukan, kembali ke login dengan pesan error
        if (!$guest) {
            return redirect()->route('login')->with('error', 'Fitur Guest tidak tersedia saat ini.');
        }

        // Loginkan user tamu tersebut secara otomatis
        Auth::login($guest);

        // Regenerasi session untuk keamanan
        request()->session()->regenerate();

        // Arahkan ke dashboard
        return redirect()->intended(route('dashboard', absolute: false));
    }
}

