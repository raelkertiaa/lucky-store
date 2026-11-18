<x-guest-layout>
    <h1 class="font-serif text-2xl text-ivory">Lupa password</h1>
    <p class="mt-1 text-sm text-silver">
        Masukkan email akunmu. Kami akan mengirim link untuk membuat password baru.
    </p>

    {{-- Muncul setelah link berhasil dikirim --}}
    @if (session('status'))
        <div class="mt-4 rounded-lg border border-gold/40 bg-gold/10 px-3 py-2 text-sm text-gold-light">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
        @csrf

        <x-field label="Email" name="email" type="email" required autofocus autocomplete="email" />

        <div class="pt-2">
            <x-gold-button>Kirim link reset</x-gold-button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-silver">
        Ingat password?
        <a href="{{ route('login') }}" class="font-medium text-gold hover:text-gold-light">Kembali masuk</a>
    </p>
</x-guest-layout>