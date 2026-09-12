<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($role === 'petugas') {
            if (! $request->session()->has('auth.admin.id')) {
                return redirect()->route('admin.login')->with('error', 'Silakan login sebagai petugas terlebih dahulu.');
            }

            return $next($request);
        }

        if ($role === 'peminjam') {
            if (! $request->session()->has('auth.member.id')) {
                return redirect()->route('login')->with('error', 'Silakan login sebagai anggota terlebih dahulu.');
            }

            return $next($request);
        }

        abort(403, 'Role tidak valid.');
    }
}
