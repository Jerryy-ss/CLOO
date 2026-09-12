<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna - Firestore</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 40px; background-color: #f9f9fb; color: #333; }
        h1 { color: #4f46e5; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .card { background: white; padding: 20px; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #4f46e5; }
        .card p { margin: 5px 0; }
    </style>
</head>
<body>

    <h1>Daftar Pengguna dari Firestore</h1>

    @if(count($users) > 0)
        <!-- Melakukan perulangan untuk menampilkan setiap data -->
        @foreach($users as $user)
            <div class="card">
                <p><strong>Nama:</strong> {{ $user['nama'] ?? 'Tidak ada nama' }}</p>
                <p><strong>Email:</strong> {{ $user['email'] ?? 'Tidak ada email' }}</p>
            </div>
        @endforeach
    @else
        <p>Belum ada data pengguna di database.</p>
    @endif

</body>
</html>
