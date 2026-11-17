<x-guest-layout>
    <h1 class="font-serif text-2xl text-ivory">Masuk</h1>
    <p class="mt-1 text-sm text-silver">Selamat datang kembali di Lucky Store.</p>

    {{-- Pesan sukses, misalnya setelah reset password --}}
    @if (session('status'))
        <div class="mt-4 rounded-lg border border-gold/40 bg-gold/10 px-3 py-2 text-sm text-gold-light">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
        @csrf

        <x-field label="Email" name="email" type="email" required autofocus autocomplete="username" />
        <x-field label="Password" name="password" type="password" required autocomplete="current-password" />

        <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2 text-sm text-silver">
                <input type="checkbox" name="remember"
                       class="rounded border-charcoal-line bg-charcoal-light text-gold focus:ring-gold">
                Ingat saya
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-gold hover:text-gold-light">
                    Lupa password?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-gold-button>Masuk</x-gold-button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-silver">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-medium text-gold hover:text-gold-light">Daftar</a>
    </p>
</x-guest-layout>