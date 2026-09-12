<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Tampilkan halaman utama (landing page) Pustaka Digital.
     *
     * Catatan: data di bawah ini masih statis mengikuti desain Figma.
     * Pada implementasi nyata, ganti dengan query ke model Book, Category,
     * dan Testimonial (mis. Book::latest()->take(5)->get()).
     */
    public function index(): View
    {
        $navItems = [
            ['label' => 'Beranda', 'url' => route('home'), 'active' => true],
            ['label' => 'Katalog', 'url' => route('katalog.index'), 'active' => false],
            ['label' => 'Pemesanan', 'url' => route('pemesanan.index'), 'active' => false],
            ['label' => 'Riwayat Peminjaman', 'url' => route('riwayat.index'), 'active' => false],
        ];

        $stats = [
            ['value' => '24.5k+', 'label' => 'Koleksi Buku Aktif'],
            ['value' => '12.8k+', 'label' => 'Anggota Aktif'],
            ['value' => '99.4%', 'label' => 'Tingkat Kepuasan'],
        ];

        $steps = [
            [
                'icon' => 'user.svg',
                'title' => 'Daftar Akun',
                'description' => 'Buat akun keanggotaan Pustaka Digital secara daring hanya dalam 3 menit.',
            ],
            [
                'icon' => 'search.svg',
                'title' => 'Cari Buku',
                'description' => 'Telusuri katalog terintegrasi untuk menemukan buku fiksi atau ilmiah pilihan Anda.',
            ],
            [
                'icon' => 'calendar.svg',
                'title' => 'Reservasi Buku',
                'description' => 'Pesan buku secara online dan tentukan tanggal pengambilan di konter.',
            ],
            [
                'icon' => 'book.svg',
                'title' => 'Ambil di Perpustakaan',
                'description' => 'Tunjukkan kode unik reservasi ke petugas dan buku siap dibawa pulang.',
            ],
        ];

        $newBooks = [
            ['cover' => 'laskar-pelangi.jpg', 'status' => 'Tersedia', 'genre' => 'Fiksi', 'title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'stock' => 5],
            ['cover' => 'sejarah-nusantara.jpg', 'status' => 'Tersedia', 'genre' => 'Sejarah', 'title' => 'Sejarah Nusantara Modern', 'author' => 'Prof. Dr. Sartono', 'stock' => 2],
            ['cover' => 'fisika-quantum.jpg', 'status' => 'Dipinjam', 'genre' => 'Sains', 'title' => 'Fisika Quantum Semesta', 'author' => 'Dr. Richard Feynman', 'stock' => 0],
            ['cover' => 'arsitektur-kode.jpg', 'status' => 'Tersedia', 'genre' => 'Teknologi', 'title' => 'Arsitektur Kode & Data', 'author' => 'Martin Fowler', 'stock' => 4],
            ['cover' => 'bumi-manusia.jpg', 'status' => 'Tersedia', 'genre' => 'Fiksi', 'title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'stock' => 3],
        ];

        $categories = [
            ['slug' => 'fiksi', 'name' => 'Fiksi', 'count' => '8.4k', 'image' => 'fiksi.jpg'],
            ['slug' => 'sains', 'name' => 'Sains', 'count' => '4.2k', 'image' => 'sains.jpg'],
            ['slug' => 'teknologi', 'name' => 'Teknologi', 'count' => '3.9k', 'image' => 'teknologi.jpg'],
            ['slug' => 'sejarah', 'name' => 'Sejarah', 'count' => '5.1k', 'image' => 'sejarah.jpg'],
            ['slug' => 'sastra', 'name' => 'Sastra', 'count' => '2.8k', 'image' => 'sastra.jpg'],
            ['slug' => 'biografi', 'name' => 'Biografi', 'count' => '1.9k', 'image' => 'biografi.jpg'],
        ];

        $popularBooks = [
            ['cover' => 'laskar-pelangi-2.jpg', 'status' => 'Tersedia', 'genre' => 'Fiksi', 'title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'stock' => 5],
            ['cover' => 'sejarah-nusantara-2.jpg', 'status' => 'Tersedia', 'genre' => 'Sejarah', 'title' => 'Sejarah Nusantara Modern', 'author' => 'Prof. Dr. Sartono', 'stock' => 2],
            ['cover' => 'bumi-manusia-2.jpg', 'status' => 'Tersedia', 'genre' => 'Fiksi', 'title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'stock' => 3],
            ['cover' => 'arsitektur-kode-2.jpg', 'status' => 'Tersedia', 'genre' => 'Teknologi', 'title' => 'Arsitektur Kode & Data', 'author' => 'Martin Fowler', 'stock' => 4],
            ['cover' => 'laskar-pelangi-3.jpg', 'status' => 'Tersedia', 'genre' => 'Fiksi', 'title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'stock' => 5],
        ];

        $testimonials = [
            [
                'quote' => 'Pemesanan online lewat Pustaka Digital sangat menghemat waktu. Kode unik langsung aktif dan tidak perlu antre lama di loket.',
                'name' => 'Rian Prasetya',
                'role' => 'Mahasiswa Informatika',
                'avatar' => 'rian.jpg',
            ],
            [
                'quote' => 'Koleksi buku sejarah dan sains sangat melimpah dan selalu diperbarui. Suasana perpustakaan fisiknya pun semakin modern dan nyaman.',
                'name' => 'Dr. Farah Amalia',
                'role' => 'Dosen & Peneliti',
                'avatar' => 'farah.jpg',
            ],
            [
                'quote' => 'Sistem pengembaliannya sangat transparan. Riwayat peminjaman tercatat rapi sehingga saya terhindar dari denda terlambat.',
                'name' => 'Budi Santoso',
                'role' => 'Pecinta Sastra Klasik',
                'avatar' => 'budi.jpg',
            ],
        ];

        $footerColumns = [
            [
                'title' => 'Layanan',
                'items' => ['Katalog Digital', 'Reservasi Buku', 'Ruang Diskusi', 'Keanggotaan'],
            ],
            [
                'title' => 'Kontak & Jam',
                'items' => [
                    'Senin - Sabtu: 08:00 - 20:00',
                    'Minggu: Tutup',
                    'Jl. Pemuda No. 45, Kota Pintar',
                    'support@pustakadigital.go.id',
                ],
            ],
            [
                'title' => 'Ikuti Kami',
                'items' => ['Instagram', 'Twitter / X', 'YouTube', 'Facebook'],
            ],
        ];

        return view('landing', compact(
            'navItems',
            'stats',
            'steps',
            'newBooks',
            'categories',
            'popularBooks',
            'testimonials',
            'footerColumns'
        ));
    }
}
