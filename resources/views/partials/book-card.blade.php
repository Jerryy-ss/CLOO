{{--
    Partial: kartu buku
    Variabel yang diharapkan:
    - $book: array berisi keys: cover, status ('Tersedia'|'Dipinjam'), genre, title, author, stock, url
    - $width: kelas Tailwind untuk lebar kartu, mis. 'w-56'
    - $coverHeight: kelas Tailwind untuk tinggi cover, mis. 'h-[325px]'
--}}
<div class="bg-white border border-[#e7e2d8] flex flex-col overflow-hidden rounded-lg shadow-[0px_8px_24px_-4px_rgba(48,38,28,0.08)] shrink-0 {{ $width }}">
    <div class="relative flex {{ $coverHeight }} items-start p-4 w-full">
        <img src="{{ asset('images/covers/' . $book['cover']) }}" alt="Sampul {{ $book['title'] }}"
             class="absolute inset-0 size-full object-cover">
        <span class="relative {{ $book['status'] === 'Tersedia' ? 'bg-[#1c352d]' : 'bg-[#b83a30]' }} text-white text-[10px] font-bold px-2 py-1 rounded">
            {{ $book['status'] }}
        </span>
    </div>

    <div class="flex flex-col gap-2 p-4 w-full">
        <p class="text-[#cd6c3c] text-[11px] font-semibold uppercase">{{ $book['genre'] }}</p>
        <p class="font-serif font-bold text-[#152535] text-base truncate">{{ $book['title'] }}</p>
        <p class="text-[#6e655f] text-[13px] truncate">{{ $book['author'] }}</p>

        <div class="flex items-center justify-between pt-2 w-full">
            <p class="text-[#2c2520] text-xs">
                Stok: <span class="font-bold">{{ $book['stock'] }} Eks</span>
            </p>
            <a href="{{ $book['url'] ?? '#' }}" aria-label="Detail {{ $book['title'] }}"
               class="flex items-center justify-center size-6">
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="" class="size-4">
            </a>
        </div>
    </div>
</div>
