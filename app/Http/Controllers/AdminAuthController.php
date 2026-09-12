<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('public.admin-login', ['title' => 'Masuk Petugas']);
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $officer = Officer::findByLogin($data['login']);

        if (! $officer || ! Hash::check($data['password'], $officer['password'] ?? '')) {
            return back()->withInput($request->only('login'))
                ->with('error', 'Akun petugas tidak ditemukan atau password salah.');
        }

        $request->session()->regenerate();
        $request->session()->put('auth.admin', [
            'id' => $officer['_id'],
            'nama' => $officer['nama'] ?? 'Petugas',
            'username' => $officer['username'] ?? '',
            'email' => $officer['email'] ?? '',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Login petugas berhasil.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('auth.admin');

        return redirect()->route('admin.login')->with('success', 'Anda telah keluar dari panel petugas.');
    }
}
