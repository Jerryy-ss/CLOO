<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Fine;
use App\Models\Loan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLoanController extends Controller
{
    public function requests(): View
    {
        $loans = Loan::all();

        return view('admin.requests', [
            'title' => 'Permintaan Peminjaman',
            'loans' => $loans,
        ]);
    }

    public function approve(string $id): RedirectResponse
    {
        $loan = Loan::find($id);

        if (! $loan || ($loan['status'] ?? '') !== 'menunggu') {
            return back()->with('error', 'Permintaan tidak dapat disetujui.');
        }

        $book = Book::find($loan['id_buku']);

        if (! $book || (int) ($book['stock_buku'] ?? 0) < 1) {
            return back()->with('error', 'Stok buku tidak mencukupi.');
        }

        Book::update($book['_id'], [
            'stock_buku' => (int) $book['stock_buku'] - 1,
        ]);

        Loan::update($id, [
            'status' => 'disetujui',
            'tanggal_disetujui' => now()->toIso8601String(),
            'batas_pengambilan' => now()->addDays(2)->toIso8601String(),
        ]);

        return back()->with('success', 'Permintaan disetujui. Barcode sekarang dapat digunakan peminjam.');
    }

    public function reject(string $id): RedirectResponse
    {
        $loan = Loan::find($id);

        if (! $loan || ($loan['status'] ?? '') !== 'menunggu') {
            return back()->with('error', 'Permintaan tidak dapat ditolak.');
        }

        Loan::update($id, [
            'status' => 'ditolak',
            'alasan_penolakan' => request()->input('alasan', 'Ditolak petugas.'),
        ]);

        return back()->with('success', 'Permintaan ditolak.');
    }

    public function verify(Request $request): View|RedirectResponse
    {
        $code = trim($request->input('kode_barcode', ''));

        if ($code === '') {
            return view('admin.verify', ['title' => 'Verifikasi Barcode', 'loan' => null]);
        }

        $loans = array_values(array_filter(
            Loan::all(),
            fn (array $loan) => ($loan['kode_barcode'] ?? '') === $code
        ));

        if (! $loans) {
            return view('admin.verify', [
                'title' => 'Verifikasi Barcode',
                'loan' => null,
                'error' => 'Barcode tidak ditemukan.',
            ]);
        }

        $loan = $loans[0];

        return view('admin.verify', [
            'title' => 'Verifikasi Barcode',
            'loan' => $loan,
        ]);
    }

    public function pickup(string $id): RedirectResponse
    {
        $loan = Loan::find($id);

        if (! $loan || ($loan['status'] ?? '') !== 'disetujui') {
            return back()->with('error', 'Peminjaman belum siap diambil.');
        }

        Loan::update($id, [
            'status' => 'dipinjam',
            'tanggal_peminjam' => now()->toIso8601String(),
            'tanggal_pengembalian' => now()->addDays((int) env('BORROWING_DAYS', 14))->toIso8601String(),
            'diproses_oleh' => session('auth.admin.id'),
        ]);

        return back()->with('success', 'Buku berhasil diserahkan dan status menjadi dipinjam.');
    }

    public function returnBook(string $id): RedirectResponse
    {
        $loan = Loan::find($id);

        if (! $loan || ($loan['status'] ?? '') !== 'dipinjam') {
            return back()->with('error', 'Peminjaman tidak aktif.');
        }

        $now = now();
        $due = isset($loan['tanggal_pengembalian']) ? \Carbon\Carbon::parse($loan['tanggal_pengembalian']) : $now;
        $daysLate = max(0, $due->startOfDay()->diffInDays($now->startOfDay(), false));
        $fineAmount = $daysLate * (int) env('FINE_PER_DAY', 1000);

        $book = Book::find($loan['id_buku']);
        if ($book) {
            Book::update($book['_id'], [
                'stock_buku' => (int) ($book['stock_buku'] ?? 0) + 1,
            ]);
        }

        Loan::update($id, [
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => $now->toIso8601String(),
            'denda' => $fineAmount,
        ]);

        $fine = Fine::forLoan($id);

        if ($fineAmount > 0) {
            if ($fine) {
                Fine::update($fine['_id'], [
                    'jumlah_denda' => $fineAmount,
                    'status' => 'belum_lunas',
                ]);
            } else {
                Fine::create([
                    'id_denda' => 'DND-'.strtoupper(\Illuminate\Support\Str::random(8)),
                    'id_peminjaman' => $id,
                    'id_anggota' => $loan['id_anggota'],
                    'jumlah_denda' => $fineAmount,
                    'status' => 'belum_lunas',
                ]);
            }
        }

        return back()->with('success', $fineAmount > 0
            ? 'Buku dikembalikan. Denda Rp '.number_format($fineAmount, 0, ',', '.').' tercatat.'
            : 'Buku berhasil dikembalikan tanpa denda.');
    }

    public function status(): View
    {
        return view('admin.status', [
            'title' => 'Status Buku',
            'loans' => Loan::all(),
            'books' => Book::all(),
        ]);
    }

    public function overdue(): View
    {
        $loans = array_values(array_filter(Loan::all(), function (array $loan) {
            if (($loan['status'] ?? '') !== 'dipinjam' || empty($loan['tanggal_pengembalian'])) {
                return false;
            }

            return now()->gt(\Carbon\Carbon::parse($loan['tanggal_pengembalian']));
        }));

        foreach ($loans as &$loan) {
            $due = \Carbon\Carbon::parse($loan['tanggal_pengembalian']);
            $loan['late_days'] = $due->startOfDay()->diffInDays(now()->startOfDay());
            $loan['calculated_fine'] = $loan['late_days'] * (int) env('FINE_PER_DAY', 1000);
        }

        return view('admin.overdue', [
            'title' => 'Jatuh Tempo',
            'loans' => $loans,
        ]);
    }

    public function history(): View
    {
        return view('admin.history', [
            'title' => 'Riwayat Peminjaman',
            'loans' => Loan::all(),
        ]);
    }
}
