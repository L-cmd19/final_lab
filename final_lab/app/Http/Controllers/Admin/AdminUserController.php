<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if ($user->role !== 'admin') {
                abort(403, 'Akses ditolak.');
            }
        }

        $usersQuery = User::query()->latest();

        if ($request->has('search')) {
            $usersQuery->where('name', 'like', '%' . $request->search . '%')
                       ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('role') && in_array($request->role, ['admin', 'seller', 'buyer'])) {
            $usersQuery->where('role', $request->role);
        }

        $users = $usersQuery->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if (Auth::check()) {
            /** @var \App\Models\User $loggedInUser */
            $loggedInUser = Auth::user();
            if ($loggedInUser->role !== 'admin') {
                abort(403, 'Akses ditolak.');
            }
        }

        $roles = ['admin', 'seller', 'buyer'];
        $sellerStatuses = ['pending', 'approved', 'rejected'];

        return view('admin.users.edit', compact('user', 'roles', 'sellerStatuses'));
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

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'seller', 'buyer'])],
            'seller_status' => ['nullable', Rule::in(['pending', 'approved', 'rejected'])],
        ]);
        
        $data = $request->only(['name', 'email', 'role']);

        if ($request->role === 'seller') {
            $data['seller_status'] = $request->seller_status ?? 'pending';
        } else {
            $data['seller_status'] = null;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $loggedInUser = Auth::user();
            if ($loggedInUser->role !== 'admin') {
                abort(403, 'Akses ditolak.');
            }
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Admin tidak dapat menghapus akunnya sendiri.');
        }

        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
             return back()->with('error', 'Gagal menghapus pengguna.');
        }
    }
}