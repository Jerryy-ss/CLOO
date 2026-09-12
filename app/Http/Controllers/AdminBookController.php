<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBookController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.books', [
            'title' => 'Kelola Buku',
            'books' => Book::all($request->string('q')->toString()),
        ]);
    }

    public function create(): View
    {
        return view('admin.book-form', [
            'title' => 'Tambah Buku',
            'book' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        Book::create([
            'id_buku' => 'BKU-'.strtoupper(\Illuminate\Support\Str::random(8)),
            ...$data,
        ]);

        return redirect()->route('admin.books')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(string $id): View
    {
        $book = Book::find($id);
        abort_if(! $book, 404);

        return view('admin.book-form', [
            'title' => 'Edit Buku',
            'book' => $book,
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        abort_if(! Book::find($id), 404);

        Book::update($id, $this->validated($request));

        return redirect()->route('admin.books')->with('success', 'Detail buku berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        abort_if(! Book::find($id), 404);

        Book::delete($id);

        return back()->with('success', 'Buku berhasil dihapus dari katalog.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama_buku' => ['required', 'string', 'max:200'],
            'penulis' => ['nullable', 'string', 'max:150'],
            'kategori' => ['nullable', 'string', 'max:80'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'stock_buku' => ['required', 'integer', 'min:0'],
            'cover_url' => ['nullable', 'url', 'max:1000'],
        ]);
    }
}
