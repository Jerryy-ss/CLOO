@extends('layouts.app')
@section('content')
<div class="auth-page"><div class="auth-card">
    <a class="brand" href="{{ route('home') }}"><span class="logo">▣</span><span><span class="brand-title">Pustaka Digital</span><span class="brand-sub">Perpustakaan Umum Kota</span></span></a>
    <h1 style="margin-top:32px">Masuk</h1><p>Masuk ke akun anggota Anda.</p>
    @if(session('error'))<div class="notice">{{ session('error') }}</div>@endif
    <form action="{{ route('login.store') }}" method="POST">@csrf
        <div class="field"><label>Email atau Username</label><input name="login" value="{{ old('login') }}" required placeholder="nama@email.com"></div>
        <div class="field"><label>Password</label><input name="password" type="password" required placeholder="••••••••"></div>
        <button class="btn btn-primary full">Masuk</button>
    </form>
    <p style="margin-top:18px">Belum punya akun? <a href="{{ route('register') }}">Daftar Anggota</a></p>
</div></div>
@endsection
