<x-guest-layout>
    <h1 class="font-serif text-2xl text-ivory">Buat akun</h1>
    <p class="mt-1 text-sm text-silver">Daftar untuk memesan parfum dan memantau pesananmu.</p>

    {{-- action: ke URL /register dengan method POST (didefinisikan di routes/auth.php) --}}
    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        {{-- @csrf: token anti-pemalsuan form. WAJIB di setiap form POST,
             tanpa ini Laravel menolak dengan error 419 --}}
        @csrf

        <x-field label="Nama lengkap" name="name" required autofocus autocomplete="name" />

        <x-field label="Email" name="email" type="email" required autocomplete="email"
                 hint="Notifikasi pesanan dikirim ke email ini." />

        <x-field label="No. WhatsApp" name="phone" type="tel" required inputmode="numeric"
                 placeholder="0812xxxxxxxx" autocomplete="tel"
                 hint="Untuk notifikasi status pesanan via WhatsApp." />

        <x-field label="Password" name="password" type="password" required autocomplete="new-password" />

        <x-field label="Ulangi password" name="password_confirmation" type="password" required autocomplete="new-password" />

        <div class="pt-2">
            <x-gold-button>Daftar</x-gold-button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-silver">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-medium text-gold hover:text-gold-light">Masuk</a>
    </p>
</x-guest-layout>