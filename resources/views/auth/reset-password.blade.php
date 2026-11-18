<x-guest-layout>
    <h1 class="font-serif text-2xl text-ivory">Buat password baru</h1>
    <p class="mt-1 text-sm text-silver">Masukkan password baru untuk akunmu.</p>

    <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-4">
        @csrf

        {{-- Token dari link email, dikirim tersembunyi bersama form --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email otomatis terisi dari link --}}
        <x-field label="Email" name="email" type="email" :value="$request->email"
                 required autocomplete="username" />

        <x-field label="Password baru" name="password" type="password" required autofocus autocomplete="new-password" />
        <x-field label="Ulangi password baru" name="password_confirmation" type="password" required autocomplete="new-password" />

        <div class="pt-2">
            <x-gold-button>Simpan password</x-gold-button>
        </div>
    </form>
</x-guest-layout>