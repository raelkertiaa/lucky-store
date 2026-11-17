<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Token keamanan, dibutuhkan saat kirim data lewat JavaScript nanti --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    {{-- Memuat CSS (Tailwind) dan JS hasil build Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-onyx font-sans text-ivory antialiased">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-10">

        {{-- Logo, bisa diklik untuk kembali ke beranda --}}
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo-luckystore-dark.png') }}" alt="Lucky Store" class="h-20 w-auto">
        </a>
        <p class="mt-3 font-serif italic text-gold-light">Parfum Berkualitas, Harga Bersahabat</p>

        {{-- Kartu tempat form --}}
        <div class="mt-8 w-full max-w-md rounded-2xl border border-charcoal-line bg-charcoal p-6 sm:p-8">
            {{ $slot }}
        </div>

        <p class="mt-6 text-xs text-silver/60">&copy; {{ date('Y') }} Lucky Official Store</p>
    </div>
</body>
</html>