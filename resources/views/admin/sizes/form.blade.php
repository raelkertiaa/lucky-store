@php $editing = $size->exists; @endphp

<x-layouts.admin :title="$editing ? 'Edit Ukuran' : 'Tambah Ukuran'">
    <a href="{{ route('admin.sizes.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a>

    <form method="POST"
          action="{{ $editing ? route('admin.sizes.update', $size) : route('admin.sizes.store') }}"
          class="mt-4 max-w-xl space-y-4 rounded-xl border border-gray-200 bg-white p-6">
        @csrf
        @if ($editing) @method('PUT') @endif

        <x-admin.input label="Label ukuran" name="size_label" :value="$size->size_label"
                       placeholder="30ml" required />

        <div class="grid gap-4 sm:grid-cols-2">
            {{-- (int) supaya tampil "50000", bukan "50000.00" --}}
            <x-admin.input label="Harga jual" name="price" prefix="Rp" inputmode="numeric"
                           :value="$size->price ? (int) $size->price : null" placeholder="50000" required />
            <x-admin.input label="Harga modal" name="cost_price" prefix="Rp" inputmode="numeric"
                           :value="$size->cost_price !== null ? (int) $size->cost_price : null" placeholder="35000" required
                           hint="Harga beli dari supplier. Dipakai untuk menghitung laba." />
        </div>

        <x-admin.input label="Urutan tampil" name="sort_order" type="number" min="0"
                       :value="$size->sort_order" hint="Angka kecil tampil lebih dulu." />

        <label class="flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="is_active" value="1"
                   class="rounded border-gray-300 text-gold focus:ring-gold"
                   @checked(old('is_active', $size->is_active))>
            Aktif (bisa dipilih pelanggan)
        </label>

        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ route('admin.sizes.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm hover:bg-gray-50">Batal</a>
            <button class="rounded-lg bg-gold px-4 py-2 text-sm font-semibold text-gold-ink hover:bg-gold-light">
                {{ $editing ? 'Simpan perubahan' : 'Simpan' }}
            </button>
        </div>
    </form>
</x-layouts.admin>