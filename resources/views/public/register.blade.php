@extends('layouts.app')
@section('content')
<div class="auth-page"><div class="auth-card">
    <a class="brand" href="{{ route('home') }}"><span class="logo">▣</span><span><span class="brand-title">Pustaka Digital</span><span class="brand-sub">Perpustakaan Umum Kota</span></span></a>
    <h1 style="margin-top:32px">Daftar Anggota</h1><p>Buat akun anggota baru.</p>
    @if($errors->any())<div class="notice">{{ $errors->first() }}</div>@endif
    <form action="{{ route('register.store') }}" method="POST">@csrf
        <div class="field"><label>Nama Lengkap</label><input name="nama" value="{{ old('nama') }}" required></div>
        <div class="field"><label>Username</label><input name="username" value="{{ old('username') }}" required></div>
        <div class="field"><label>Email</label><input name="email" type="email" value="{{ old('email') }}" required></div>
        <div class="field"><label>No. Telepon</label><input name="no_telp" value="{{ old('no_telp') }}" required></div>
        <div class="field"><label>Password</label><input name="password" type="password" required></div>
        <div class="field"><label>Konfirmasi Password</label><input name="password_confirmation" type="password" required></div>
        <button class="btn btn-primary full">Daftar Anggota</button>
    </form>
</div></div>
@endsection
