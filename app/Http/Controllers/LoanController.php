<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Fine;
use App\Models\Loan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id_buku' => ['required', 'string'],
            'tanggal_pengambilan' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $memberId = session('auth.member.id');
        $book = Book::find($data['id_buku']);

        if (! $memberId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (! $book) {
            return back()->with('error', 'Buku tidak ditemukan.');
        }

        if ((int) ($book['stock_buku'] ?? 0) < 1) {
            return back()->with('error', 'Stok buku sedang habis.');
        }

        if (Loan::activeForMemberBook($memberId, $book['_id'])) {
            return back()->with('error', 'Anda sudah memiliki pemesanan aktif untuk buku ini.');
        }

        Loan::create([
            'id_peminjaman' => 'PJM-'.strtoupper(\Illuminate\Support\Str::random(8)),
            'id_anggota' => $memberId,
            'id_peminjam' => $memberId,
            'id_buku' => $book['_id'],
            'nama_peminjam' => session('auth.member.nama'),
            'nama_buku' => $book['nama_buku'] ?? '',
            'tanggal_pesan' => now()->toIso8601String(),
            'tanggal_pengambilan' => $data['tanggal_pengambilan'],
            'tanggal_peminjam' => null,
            'tanggal_pengembalian' => null,
            'tanggal_dikembalikan' => null,
            'status' => 'menunggu',
            'kode_barcode' => 'PST-'.strtoupper(\Illuminate\Support\Str::random(10)),
            'denda' => 0,
        ]);

        return redirect()->route('history')->with('success', 'Pemesanan berhasil dikirim. Tunggu persetujuan petugas.');
    }

    public function history(): View
    {
        $loans = Loan::forMember(session('auth.member.id'));
        usort($loans, fn ($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));

        foreach ($loans as &$loan) {
            $loan['fine'] = Fine::forLoan($loan['_id']);
        }

        return view('public.history', [
            'title' => 'Riwayat Peminjaman',
            'loans' => $loans,
        ]);
    }

    public function barcode(string $id): View|RedirectResponse
    {
        $loan = Loan::find($id);

        abort_if(! $loan || ($loan['id_anggota'] ?? '') !== session('auth.member.id'), 404);

        if (($loan['status'] ?? '') !== 'disetujui') {
            return redirect()->route('history')->with('error', 'Barcode baru dapat digunakan setelah pemesanan disetujui petugas.');
        }

        return view('public.barcode', [
            'title' => 'Barcode Peminjaman',
            'loan' => $loan,
        ]);
    }
}
