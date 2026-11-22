{{-- $category->exists = true jika data dari database (edit), false jika objek baru (tambah) --}}
@php $editing = $category->exists; @endphp

<x-layouts.admin :title="$editing ? 'Edit Kategori' : 'Tambah Kategori'">
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a>

    <form method="POST"
          action="{{ $editing ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
          class="mt-4 max-w-xl space-y-4 rounded-xl border border-gray-200 bg-white p-6">
        @csrf
        @if ($editing) @method('PUT') @endif

        <x-admin.input label="Nama kategori" name="name" :value="$category->name" required maxlength="50" />

        <div>
            <label for="description" class="mb-1 block text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
            <textarea id="description" name="description" rows="3"
                      class="block w-full rounded-lg border-gray-300 text-sm focus:border-gold focus:ring-gold">{{ old('description', $category->description) }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm hover:bg-gray-50">Batal</a>
            <button class="rounded-lg bg-gold px-4 py-2 text-sm font-semibold text-gold-ink hover:bg-gold-light">
                {{ $editing ? 'Simpan perubahan' : 'Simpan' }}
            </button>
        </div>
    </form>
</x-layouts.admin>