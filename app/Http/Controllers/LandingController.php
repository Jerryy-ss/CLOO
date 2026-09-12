<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $books = Book::all();

        return view('public.home', [
            'title' => 'Pustaka Digital',
            'books' => array_slice($books, 0, 5),
            'bookCount' => count($books),
            'memberCount' => count(Member::all()),
        ]);
    }
}
