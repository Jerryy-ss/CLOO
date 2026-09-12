<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Pustaka Digital' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @if(session('success'))
        <div class="notice" style="margin:16px">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="notice" style="margin:16px">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</body>
</html>
