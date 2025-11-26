<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SellerVerificationController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if ($user->role !== 'admin') {
                abort(403, 'Akses ditolak.');
            }
        }

        $pendingSellers = User::where('role', 'seller')
                              ->where('seller_status', 'pending')
                              ->with('store')
                              ->latest()
                              ->paginate(10);
        
        return view('admin.verification.index', compact('pendingSellers'));
    }

    public function update(Request $request, User $user)
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $loggedInUser = Auth::user();
            if ($loggedInUser->role !== 'admin') {
                abort(403, 'Akses ditolak.');
            }
        }
        
        if ($user->role !== 'seller') {
            return back()->with('error', 'Pengguna ini bukan Seller.');
        }
        
        $request->validate([
            'status' => ['required', Rule::in(['approved', 'rejected'])],
        ]);
        
        $user->seller_status = $request->status;
        $user->save();
                   
        return redirect()->route('admin.verification.index')->with('success', 'Status Seller berhasil diperbarui.');
    }
}