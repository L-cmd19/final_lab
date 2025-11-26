<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan tampilan registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Menangani permintaan pendaftaran yang masuk.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:buyer,seller'], // Validasi role wajib dipilih
        ]);

        // 2. Tentukan Status Seller
        // Jika role adalah 'seller', statusnya 'pending'. Jika buyer, null (atau approved, terserah logika Anda)
        $sellerStatus = ($request->role === 'seller') ? 'pending' : null;

        // 3. Buat User Baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,           // Simpan peran
            'seller_status' => $sellerStatus,   // Simpan status
        ]);

        // 4. Trigger Event Terdaftar
        event(new Registered($user));

        // 5. Login Otomatis
        Auth::login($user);

        // 6. Redirect Berdasarkan Peran
        if ($user->role === 'seller') {
            // Seller diarahkan ke halaman "Menunggu Persetujuan"
            return redirect()->route('seller.pending');
        }

        // Buyer diarahkan ke Homepage
        return redirect(route('home', absolute: false));
    }
}