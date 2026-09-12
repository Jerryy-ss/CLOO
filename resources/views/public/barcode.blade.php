@extends('layouts.app')
@section('content')
@include('components.header')
<div class="auth-page"><div class="auth-card" style="max-width:620px;text-align:center"><div class="eyebrow">Reservasi Disetujui</div><h1 class="serif">Barcode Peminjaman</h1><p>{{ $loan['nama_buku'] }} · {{ $loan['nama_peminjam'] }}</p><svg id="barcode" style="max-width:100%;margin:20px 0"></svg><div class="code"><span>KODE UNIK:</span><b>{{ $loan['kode_barcode'] }}</b></div><p>Tunjukkan barcode ini kepada petugas saat mengambil buku.</p><a class="btn btn-outline" href="{{ route('history') }}">Kembali ke Riwayat</a></div></div>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script><script>JsBarcode('#barcode','{{ $loan['kode_barcode'] }}',{format:'CODE128',displayValue:true,lineColor:'#111827',width:2,height:90});</script>
@endsection
