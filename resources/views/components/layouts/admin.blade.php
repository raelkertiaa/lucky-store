@props(['title' => 'Dashboard'])

@php
    // Daftar menu sidebar: [label, nama route, ikon (path SVG Heroicons)]
    // Route yang belum dibuat otomatis tampil abu-abu "segera" (tidak error).
    $menu = [
        'Utama' => [
            ['Dashboard', 'admin.dashboard', 'M3 12l9-9 9 9M5 10v10h14V10'],
            ['Pesanan', 'admin.orders.index', 'M9 5h6M9 3h6a2 2 0 012 2v14a2 2 0 01-2 2H9a2 2 0 01-2-2V5a2 2 0 012-2zM9 12h6M9 16h4'],
            ['Rekap Belanja', 'admin.recap', 'M3 3h18v4H3zM5 7v13h14V7M9 11h6'],
        ],
        'Katalog' => [
            ['Produk', 'admin.products.index', 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['Stok', 'admin.stocks.index', 'M4 6h16M4 12h16M4 18h10'],
            ['Kategori', 'admin.categories.index', 'M7 7h.01M7 3h5l9 9-7 7-9-9V3z'],
            ['Ukuran & Harga', 'admin.sizes.index', 'M12 8c-2.2 0-4 .9-4 2s1.8 2 4 2 4 .9 4 2-1.8 2-4 2m0-8V6m0 10v2'],
        ],
        'Lainnya' => [
            ['Laporan', 'admin.reports', 'M9 19V13M13 19V9M17 19V5M5 19h14'],
            ['Pelanggan', 'admin.customers', 'M17 20h5v-2a4 4 0 00-5-3.9M9 20H2v-2a4 4 0 015-3.9m6-4.1a4 4 0 11-8 0 4 4 0 018 0z'],
            ['Pengaturan Toko', 'admin.settings.edit', 'M10.3 4.3a1.7 1.7 0 013.4 0 1.7 1.7 0 002.6 1.1 1.7 1.7 0 012.4 2.4 1.7 1.7 0 001.1 2.6 1.7 1.7 0 010 3.4 1.7 1.7 0 00-1.1 2.6 1.7 1.7 0 01-2.4 2.4 1.7 1.7 0 00-2.6 1.1 1.7 1.7 0 01-3.4 0 1.7 1.7 0 00-2.6-1.1 1.7 1.7 0 01-2.4-2.4 1.7 1.7 0 00-1.1-2.6 1.7 1.7 0 010-3.4 1.7 1.7 0 001.1-2.6 1.7 1.7 0 012.4-2.4 1.7 1.7 0 002.6-1.1zM15 12a3 3 0 11-6 0 3 3 0 016 0z'],
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} · Admin {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- x-data: state Alpine.js. sidebarOpen dipakai untuk buka-tutup sidebar di HP --}}
<body class="bg-gray-50 font-sans text-gray-800 antialiased" x-data="{ sidebarOpen: false }">

    {{-- Latar gelap saat sidebar terbuka di HP (klik untuk menutup) --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-black/40 lg:hidden"></div>

    {{-- ===== SIDEBAR ===== --}}
    <aside class="fixed inset-y-0 left-0 z-40 w-64 transform bg-onyx transition-transform lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <div class="flex h-16 items-center gap-3 border-b border-charcoal-line px-5">
            <img src="{{ asset('images/logo-icon.png') }}" alt="" class="h-8 w-auto">
            <div>
                <p class="font-serif text-lg leading-none text-ivory">Lucky<span class="text-gold">store</span></p>
                <p class="text-[11px] text-silver">Panel Admin</p>
            </div>
        </div>

        <nav class="h-[calc(100vh-4rem)] overflow-y-auto px-3 py-4">
            @foreach ($menu as $group => $items)
                <p class="mb-1 mt-4 px-3 text-[11px] font-semibold uppercase tracking-wider text-silver/60 first:mt-0">
                    {{ $group }}
                </p>

                @foreach ($items as [$label, $route, $icon])
                    @php
                        $exists = Route::has($route);
                        // Menu aktif jika route sekarang = route menu atau turunannya (mis. admin.products.edit)
                        $base = str($route)->beforeLast('.')->append('.*')->toString();
                        $active = $exists && (request()->routeIs($route) || request()->routeIs($base) && $base !== 'admin.*');
                    @endphp

                    @if ($exists)
                        <a href="{{ route($route) }}"
                           class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm transition
                                  {{ $active ? 'bg-gold text-gold-ink font-semibold' : 'text-silver hover:bg-charcoal hover:text-ivory' }}">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
                            </svg>
                            {{ $label }}
                        </a>
                    @else
                        <span class="flex cursor-not-allowed items-center gap-3 rounded-lg px-3 py-2 text-sm text-silver/40">
                            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
                            </svg>
                            {{ $label }}
                            <span class="ml-auto text-[10px]">segera</span>
                        </span>
                    @endif
                @endforeach
            @endforeach
        </nav>
    </aside>

    {{-- ===== AREA KONTEN ===== --}}
    <div class="lg:pl-64">

        {{-- Topbar --}}
        <header class="sticky top-0 z-20 flex h-16 items-center gap-4 border-b border-gray-200 bg-white px-4 sm:px-6">
            {{-- Tombol hamburger, hanya tampil di layar kecil --}}
            <button @click="sidebarOpen = true" class="rounded-md p-2 text-gray-600 hover:bg-gray-100 lg:hidden" aria-label="Buka menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <h1 class="text-lg font-semibold text-gray-900">{{ $title }}</h1>

            {{-- Menu akun (dropdown Alpine) --}}
            <div class="relative ml-auto" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm hover:bg-gray-100">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gold text-sm font-semibold text-gold-ink">
                        {{ str(auth()->user()->name)->substr(0, 1)->upper() }}
                    </span>
                    <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                </button>
                <div x-show="open" x-cloak @click.outside="open = false"
                     class="absolute right-0 mt-2 w-48 rounded-lg border border-gray-200 bg-white py-1 shadow-lg">
                    <a href="{{ route('home') }}" target="_blank" class="block px-4 py-2 text-sm hover:bg-gray-50">Lihat toko</a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-50">Keluar</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="p-4 sm:p-6">
            {{-- Pesan sukses/gagal setelah simpan, hapus, dll. --}}
            @if (session('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>