{{-- Props = "parameter" yang bisa dikirim saat komponen dipanggil --}}
@props([
    'label',              // teks label, wajib
    'name',               // nama input, wajib (juga dipakai sebagai id)
    'type' => 'text',     // jenis input, default text
    'hint' => null,       // teks bantuan kecil di bawah input (opsional)
    'value' => null,
])

<div>
    <label for="{{ $name }}" class="mb-1 block text-sm font-medium text-silver">
        {{ $label }}
    </label>

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        {{-- old() mengisi ulang nilai sebelumnya kalau validasi gagal.
             Password sengaja tidak diisi ulang demi keamanan. --}}
        @if ($type !== 'password') value="{{ old($name, $value) }}" @endif
        {{-- $attributes = atribut lain yang dikirim (required, autofocus, placeholder, dll.)
             merge() menggabungkannya dengan class bawaan di bawah --}}
        {{ $attributes->merge([
            'class' => 'block w-full rounded-lg border-charcoal-line bg-charcoal-light text-ivory
                        placeholder:text-silver/40 focus:border-gold focus:ring-gold',
        ]) }}
    >

    @if ($hint)
        <p class="mt-1 text-xs text-silver/70">{{ $hint }}</p>
    @endif

    {{-- Tampilkan pesan error validasi khusus untuk input ini --}}
    @error($name)
        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
    @enderror
</div>