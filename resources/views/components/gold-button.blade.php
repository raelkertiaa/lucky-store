{{-- $slot = isi di antara <x-gold-button> ... </x-gold-button>, misalnya teks "Daftar" --}}
<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex w-full justify-center rounded-lg bg-gold px-4 py-2.5 font-semibold
                text-gold-ink transition hover:bg-gold-light active:bg-gold-dark
                focus:outline-none focus:ring-2 focus:ring-gold-light focus:ring-offset-2 focus:ring-offset-charcoal',
]) }}>
    {{ $slot }}
</button>