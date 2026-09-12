<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pustaka Digital - Perpustakaan Umum Kota</title>

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CDN (ganti dengan build Vite/Tailwind milik project Anda jika sudah tersedia) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['Manrope', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-[#faf7f2]">

    {{-- ==================== HEADER ==================== --}}
    <header class="bg-white border-b border-[#e7e2d8] flex items-center justify-between px-20 h-[88px] w-full">
        <div class="flex items-center gap-3">
            <div class="bg-[#152535] flex items-center justify-center rounded-md size-10">
                <img src="{{ asset('images/icons/book-open.svg') }}" alt="logo" class="size-[22px]">
            </div>
            <div class="flex flex-col gap-0.5">
                <p class="font-serif font-bold text-[#152535] text-xl leading-none">Pustaka Digital</p>
                <p class="font-semibold text-[#6e655f] text-[10px] uppercase leading-none">Perpustakaan Umum Kota</p>
            </div>
        </div>

        <nav class="flex items-center gap-8">
            @foreach ($navItems as $item)
                <div class="flex flex-col items-center gap-1">
                    <a href="{{ $item['url'] }}"
                       class="text-sm whitespace-nowrap {{ $item['active'] ? 'font-bold text-[#152535]' : 'font-medium text-[#6e655f]' }}">
                        {{ $item['label'] }}
                    </a>
                    @if ($item['active'])
                        <span class="bg-[#cd6c3c] h-0.5 w-4"></span>
                    @endif
                </div>
            @endforeach
        </nav>

        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="font-semibold text-sm text-[#2c2520]">Masuk</a>
            <a href="{{ route('register') }}" class="bg-[#152535] text-white font-semibold text-sm px-5 py-2.5 rounded-md">
                Daftar Anggota
            </a>
        </div>
    </header>

    {{-- ==================== HERO ==================== --}}
    <section class="bg-[#faf7f2] flex items-center gap-16 px-20 py-24 w-full">
        <div class="flex-1 flex flex-col gap-8 min-w-0">
            <div class="flex flex-col gap-4 w-full">
                <span class="bg-[#cd6c3c]/10 text-[#cd6c3c] font-bold text-xs px-4 py-1.5 rounded-full inline-block w-fit">
                    Perpustakaan Umum Terakreditasi A
                </span>
                <h1 class="font-serif font-extrabold text-[#152535] text-[56px] leading-[1.15]">
                    Buka Jendela Dunia Melalui Halaman Ilmu
                </h1>
                <p class="text-[#6e655f] text-lg leading-relaxed">
                    Cari, pesan, dan pinjam puluhan ribu koleksi buku fisik maupun digital dengan praktis.
                    Menghubungkan pembaca dengan sejarah, sains, dan masa depan.
                </p>
            </div>

            <form action="{{ route('katalog.search') }}" method="GET"
                  class="bg-white border border-[#e7e2d8] flex items-center gap-3 p-2 rounded-xl w-full shadow-[0px_8px_12px_rgba(48,38,28,0.08)]">
                <div class="flex-1 flex items-center gap-3 pl-4 min-w-0">
                    <img src="{{ asset('images/icons/search.svg') }}" alt="" class="size-5">
                    <input
                        type="text"
                        name="q"
                        placeholder="Cari judul buku, penulis, atau topik sains..."
                        class="flex-1 outline-none text-[15px] text-[#6e655f] bg-transparent"
                    >
                </div>
                <button type="submit" class="bg-[#1c352d] text-white font-bold text-sm px-6 py-3.5 rounded-lg">
                    Cari Buku
                </button>
            </form>

            <div class="flex gap-10">
                @foreach ($stats as $stat)
                    <div class="flex flex-col gap-1">
                        <p class="font-serif font-bold text-[#152535] text-[32px] leading-none">{{ $stat['value'] }}</p>
                        <p class="text-[#6e655f] text-[13px]">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="w-[520px] h-[420px] rounded-2xl overflow-hidden shrink-0 shadow-[0px_8px_12px_rgba(48,38,28,0.08)]">
            <img src="{{ asset('images/hero-library.jpg') }}" alt="Interior perpustakaan" class="size-full object-cover">
        </div>
    </section>

    {{-- ==================== HOW IT WORKS ==================== --}}
    <section class="bg-white flex flex-col gap-14 px-20 py-24 w-full">
        <div class="flex flex-col items-center gap-2 text-center w-full">
            <p class="font-bold text-[#cd6c3c] text-xs uppercase">Panduan Anggota</p>
            <h2 class="font-serif font-bold text-[#152535] text-4xl">Alur Praktis Peminjaman Buku</h2>
        </div>

        <div class="flex gap-8 w-full">
            @foreach ($steps as $index => $step)
                <div class="bg-[#faf7f2] border border-[#e7e2d8] flex-1 flex flex-col gap-5 p-8 rounded-xl shadow-[0px_8px_12px_rgba(48,38,28,0.08)]">
                    <div class="flex items-center justify-between w-full">
                        <div class="bg-[#152535] flex items-center justify-center rounded-lg size-12">
                            <img src="{{ asset('images/icons/' . $step['icon']) }}" alt="" class="size-5">
                        </div>
                        <p class="font-serif font-extrabold text-2xl text-[#152535]/20">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <h3 class="font-serif font-bold text-[#152535] text-xl">{{ $step['title'] }}</h3>
                        <p class="text-[#6e655f] text-sm leading-relaxed">{{ $step['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ==================== KOLEKSI BUKU TERBARU ==================== --}}
    <section class="flex flex-col gap-10 px-20 py-24 w-full">
        <div class="flex items-end justify-between w-full">
            <div class="flex flex-col gap-2">
                <p class="font-bold text-[#cd6c3c] text-xs uppercase">Terbaru Bulan Ini</p>
                <h2 class="font-serif font-bold text-[#152535] text-4xl">Koleksi Buku Terbaru</h2>
            </div>
            <div class="flex gap-3">
                <button aria-label="Sebelumnya" class="bg-white border border-[#e7e2d8] flex items-center justify-center rounded-full size-10">
                    <img src="{{ asset('images/icons/arrow-left.svg') }}" alt="" class="size-4">
                </button>
                <button aria-label="Berikutnya" class="bg-[#152535] flex items-center justify-center rounded-full size-10">
                    <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="" class="size-4">
                </button>
            </div>
        </div>

        <div class="flex gap-6 overflow-x-auto w-full">
            @foreach ($newBooks as $book)
                @include('partials.book-card', ['book' => $book, 'width' => 'w-56', 'coverHeight' => 'h-[325px]'])
            @endforeach
        </div>
    </section>

    {{-- ==================== KATEGORI ==================== --}}
    <section class="bg-white flex flex-col gap-12 px-20 py-24 w-full">
        <div class="flex flex-col items-center gap-2 text-center w-full">
            <p class="font-bold text-[#cd6c3c] text-xs uppercase">Kategori Buku Terpopuler</p>
            <h2 class="font-serif font-bold text-[#152535] text-4xl">Telusuri Berdasarkan Kategori</h2>
        </div>

        <div class="flex gap-5 w-full">
            @foreach ($categories as $category)
                <a href="{{ route('katalog.kategori', $category['slug']) }}"
                   class="flex-1 flex flex-col justify-between h-[200px] p-6 rounded-xl relative overflow-hidden bg-cover bg-center"
                   style="background-image: linear-gradient(rgba(21,37,53,0.75), rgba(21,37,53,0.75)), url('{{ asset('images/categories/' . $category['image']) }}')">
                    <span></span>
                    <div class="flex flex-col gap-1">
                        <p class="font-serif font-bold text-white text-[22px]">{{ $category['name'] }}</p>
                        <p class="text-[#faf7f2] text-xs">{{ $category['count'] }} Buku</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ==================== PALING BANYAK DIPINJAM ==================== --}}
    <section class="flex flex-col gap-12 px-20 py-24 w-full">
        <div class="flex flex-col items-center gap-2 text-center w-full">
            <p class="font-bold text-[#cd6c3c] text-xs uppercase">Populer &amp; Edukatif</p>
            <h2 class="font-serif font-bold text-[#152535] text-4xl">Paling Banyak Dipinjam Minggu Ini</h2>
        </div>

        <div class="flex gap-6 w-full">
            @foreach ($popularBooks as $book)
                @include('partials.book-card', ['book' => $book, 'width' => 'w-60', 'coverHeight' => 'h-[342px]'])
            @endforeach
        </div>
    </section>

    {{-- ==================== TESTIMONI ==================== --}}
    <section class="bg-white flex flex-col gap-12 px-20 py-24 w-full">
        <div class="flex flex-col items-center gap-2 text-center w-full">
            <p class="font-bold text-[#cd6c3c] text-xs uppercase">Testimoni Anggota</p>
            <h2 class="font-serif font-bold text-[#152535] text-4xl">Suara Pengunjung Pustaka</h2>
        </div>

        <div class="flex gap-8 w-full">
            @foreach ($testimonials as $testimonial)
                <div class="bg-[#faf7f2] flex-1 flex flex-col gap-6 p-10 rounded-xl shadow-[0px_8px_12px_rgba(48,38,28,0.08)]">
                    <div class="flex gap-1">
                        @for ($i = 0; $i < 5; $i++)
                            <img src="{{ asset('images/icons/star.svg') }}" alt="" class="size-4">
                        @endfor
                    </div>
                    <p class="text-[#2c2520] text-[15px] leading-relaxed">&ldquo;{{ $testimonial['quote'] }}&rdquo;</p>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('images/avatars/' . $testimonial['avatar']) }}" alt="{{ $testimonial['name'] }}"
                             class="rounded-full size-12 object-cover">
                        <div class="flex flex-col gap-0.5">
                            <p class="font-serif font-bold text-[#152535] text-base">{{ $testimonial['name'] }}</p>
                            <p class="text-[#6e655f] text-xs">{{ $testimonial['role'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ==================== FOOTER ==================== --}}
    <footer class="bg-[#152535] flex flex-col gap-12 p-20 w-full">
        <div class="flex items-start justify-between w-full">
            <div class="flex flex-col gap-4 w-[360px]">
                <div class="flex items-center gap-3">
                    <div class="bg-[#cd6c3c] flex items-center justify-center rounded-md size-9">
                        <img src="{{ asset('images/icons/book-open-light.svg') }}" alt="" class="size-[18px]">
                    </div>
                    <p class="font-serif font-bold text-[#faf7f2] text-2xl">Pustaka Digital</p>
                </div>
                <p class="text-[#e7e2d8] text-sm leading-relaxed">
                    Gerbang utama menuju lautan pengetahuan digital dan fisik. Melayani kota dengan ribuan arsip literatur terkurasi.
                </p>
            </div>

            @foreach ($footerColumns as $column)
                <div class="flex flex-col gap-4 text-sm">
                    <p class="font-bold text-[#faf7f2] uppercase">{{ $column['title'] }}</p>
                    @foreach ($column['items'] as $item)
                        <p class="text-[#e7e2d8]">{{ $item }}</p>
                    @endforeach
                </div>
            @endforeach
        </div>

        <hr class="border-t border-white/10 w-full">

        <div class="flex items-center justify-between w-full text-[#e7e2d8] text-[13px]">
            <p class="opacity-60">&copy; {{ date('Y') }} Pustaka Digital Perpustakaan Umum Kota. Hak Cipta Dilindungi.</p>
            <p class="opacity-60">Kebijakan Privasi &bull; Syarat &amp; Ketentuan</p>
        </div>
    </footer>

</body>
</html>
