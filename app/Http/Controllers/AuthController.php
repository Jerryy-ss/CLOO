<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('public.login', ['title' => 'Masuk Anggota']);
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $member = Member::findByLogin($data['login']);

        if (! $member || ! Hash::check($data['password'], $member['password'] ?? '')) {
            return back()->withInput($request->only('login'))
                ->with('error', 'Username/email atau password tidak sesuai.');
        }

        $request->session()->regenerate();
        $request->session()->put('auth.member', [
            'id' => $member['_id'],
            'nama' => $member['nama'] ?? '',
            'username' => $member['username'] ?? '',
            'email' => $member['email'] ?? '',
            'no_telp' => $member['no_telp'] ?? '',
        ]);

        return redirect()->intended(route('home'))
            ->with('success', 'Selamat datang, '.($member['nama'] ?? 'Anggota').'!');
    }

    public function showRegister(): View
    {
        return view('public.register', ['title' => 'Daftar Anggota']);
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'alpha_dash', 'min:4', 'max:40', Rule::notIn(['admin', 'petugas'])],
            'email' => ['required', 'email', 'max:120'],
            'no_telp' => ['required', 'string', 'max:25'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (Member::existsByUsername($data['username'])) {
            return back()->withInput()->with('error', 'Username sudah digunakan.');
        }

        if (Member::existsByEmail($data['email'])) {
            return back()->withInput()->with('error', 'Email sudah terdaftar.');
        }

        $member = Member::create([
            'id_nama' => 'AGT-'.strtoupper(\Illuminate\Support\Str::random(8)),
            'nama' => $data['nama'],
            'username' => $data['username'],
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password']),
            'no_telp' => $data['no_telp'],
            'role' => 'peminjam',
        ]);

        $request->session()->regenerate();
        $request->session()->put('auth.member', [
            'id' => $member['_id'],
            'nama' => $member['nama'],
            'username' => $member['username'],
            'email' => $member['email'],
            'no_telp' => $member['no_telp'],
        ]);

        return redirect()->route('home')->with('success', 'Akun berhasil dibuat.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('auth.member');

        return redirect()->route('home')->with('success', 'Anda telah keluar.');
    }
}
