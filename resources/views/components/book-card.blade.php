@props(['image'=>'cover1.png','category'=>'Fiksi','title'=>'Laskar Pelangi','author'=>'Andrea Hirata','stock'=>'5 Eks','borrowed'=>false,'book'=>null])
@php
    $coverMap = [
        'cover1.png'=>'https://www.figma.com/api/mcp/asset/d8e3df12-e09c-4e36-86cb-002c2c0346aa.png',
        'cover2.png'=>'https://www.figma.com/api/mcp/asset/59c36a57-0450-4eb8-b3c4-b94dbae307ef.png',
        'cover3.png'=>'https://www.figma.com/api/mcp/asset/676e2136-2b8a-4905-b1dd-b66ed9ddcea2.png',
        'cover4.png'=>'https://www.figma.com/api/mcp/asset/5df50d84-a81b-4dab-be84-41be82a351c0.png',
        'cover5.png'=>'https://www.figma.com/api/mcp/asset/c3276292-ed4f-46ba-9cb2-be33081d0667.png',
    ];
    $href = $book && isset($book['_id']) ? route('books.show', $book['_id']) : '#';
@endphp
<article class="book-card">
    <a href="{{ $href }}" style="text-decoration:none;color:inherit;display:block">
        <div class="cover"><img src="{{ $book['cover_url'] ?? ($coverMap[$image] ?? $image) }}" alt="{{ $book['nama_buku'] ?? $title }}"><span class="badge {{ $borrowed || (($book['stock_buku'] ?? null) === 0) ? 'red':'' }}">{{ $borrowed || (($book['stock_buku'] ?? null) === 0) ? 'Dipinjam':'Tersedia' }}</span></div>
        <div class="book-info"><div class="category">{{ $book['kategori'] ?? $category }}</div><div class="book-title">{{ $book['nama_buku'] ?? $title }}</div><div class="author">{{ $book['penulis'] ?? $author }}</div><div class="book-foot"><span>Stok: <b>{{ $book ? (($book['stock_buku'] ?? 0).' Eks') : $stock }}</b></span><span>→</span></div></div>
    </a>
</article>
