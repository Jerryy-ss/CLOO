<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $books = Book::all();
        $members = Member::all();
        $loans = Loan::all();

        return view('admin.dashboard', [
            'title' => 'Dashboard Admin',
            'bookCount' => count($books),
            'memberCount' => count($members),
            'pendingCount' => count(array_filter($loans, fn ($l) => ($l['status'] ?? '') === 'menunggu')),
            'borrowedCount' => count(array_filter($loans, fn ($l) => ($l['status'] ?? '') === 'dipinjam')),
        ]);
    }

    public function members(): View
    {
        return view('admin.members', [
            'title' => 'Anggota',
            'members' => Member::all(),
        ]);
    }
}
