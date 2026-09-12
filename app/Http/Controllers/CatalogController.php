<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $books = Book::all($request->string('q')->toString());

        return view('public.catalog', [
            'title' => 'Katalog Pustaka Digital',
            'books' => $books,
            'query' => $request->string('q')->toString(),
        ]);
    }

    public function show(string $id): View
    {
        $book = Book::find($id);

        abort_if(! $book, 404);

        return view('public.ordering', [
            'title' => 'Pemesanan '.$book['nama_buku'],
            'book' => $book,
        ]);
    }
}
