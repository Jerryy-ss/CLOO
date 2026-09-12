@extends('layouts.app')
@section('content')
<div class="auth-page"><div class="auth-card">
    <a class="brand" href="{{ route('home') }}"><span class="logo">▣</span><span><span class="brand-title">Pustaka Admin</span><span class="brand-sub">Sistem Manajemen Internal</span></span></a>
    <h1 style="margin-top:32px">Masuk Admin</h1><p>Gunakan akun petugas untuk membuka panel kendali.</p>
    @if(session('error'))<div class="notice">{{ session('error') }}</div>@endif
    <form action="{{ route('admin.login.store') }}" method="POST">@csrf
        <div class="field"><label>Email atau Username</label><input name="login" value="{{ old('login') }}" required></div>
        <div class="field"><label>Password</label><input name="password" type="password" required></div>
        <button class="btn btn-primary full">Masuk</button>
    </form>
</div></div>
@endsection
