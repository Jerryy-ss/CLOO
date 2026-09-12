@extends('layouts.app')
@section('content')
@include('components.header')
<div class="page-head"><h1>Katalog Pustaka Digital</h1><form class="filterbar" method="GET" action="{{ route('catalog') }}"><input name="q" value="{{ request('q') }}" placeholder="Cari buku fiksi, sejarah, sains, novel..."><button class="btn btn-primary">Cari</button></form></div>
<div class="catalog-wrap"><aside class="sidebar"><h3>Kategori Buku</h3>@foreach(['Semua Buku','Fiksi & Sastra','Sejarah Nusantara','Sains & Quantum','Teknologi & Kode','Biografi Tokoh','Seni & Arsitektur'] as $cat)<a class="side-item" href="{{ route('catalog',['q'=>$cat==='Semua Buku'?'':$cat]) }}"><span>{{ $cat }}</span></a>@endforeach</aside><main class="catalog-main"><div class="toolbar"><span>Menampilkan <b>{{ count($books) }}</b> koleksi buku</span><span>{{ $query ? 'Hasil pencarian: '.e($query) : 'Semua koleksi' }}</span></div><div class="catalog-grid">
@forelse($books as $book)
    @include('components.book-card',['book'=>$book,'category'=>$book['kategori'] ?? 'Umum','title'=>$book['nama_buku'] ?? 'Buku','author'=>$book['penulis'] ?? '-','stock'=>(($book['stock_buku'] ?? 0).' Eks'),'borrowed'=>(($book['stock_buku'] ?? 0) <= 0)])
@empty
    <div class="notice">Belum ada buku yang sesuai.</div>
@endforelse
</div></main></div>
@include('components.footer')
@endsection
