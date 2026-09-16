<header class="site-header">
    <a class="brand" href="{{ route('home') }}"><span class="logo">▣</span><span><span class="brand-title">Pustaka Digital</span> <span class="brand-sub">Perpustakaan Umum Kota</span></span></a>
    <nav class="nav">
        <a class="{{ request()->routeIs('home')?'active':'' }}" href="{{ route('home') }}">Beranda</a>
        <a class="{{ request()->routeIs('catalog') || request()->routeIs('books.show')?'active':'' }}" href="{{ route('catalog') }}">Katalog</a>
        @if(session('auth.member.id'))
            <a class="{{ request()->routeIs('history') || request()->routeIs('loan.barcode')?'active':'' }}" href="{{ route('history') }}">Riwayat Peminjaman</a>
        @endif
    </nav>
    <div class="auth">
        @if(session('auth.member.id'))
            <span>Halo, {{ session('auth.member.nama') }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">@csrf<button class="btn btn-outline" type="submit">Keluar</button></form>
        @else
            <a href="{{ route('login') }}">Masuk</a>
            <a class="btn btn-primary" href="{{ route('register') }}">Daftar Anggota</a>
        @endif
    </div>
</header>
