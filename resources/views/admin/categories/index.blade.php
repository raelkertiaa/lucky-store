<x-layouts.admin title="Kategori Aroma">
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-gray-500">Kelompok aroma untuk filter di katalog.</p>
        <a href="{{ route('admin.categories.create') }}"
           class="rounded-lg bg-gold px-4 py-2 text-sm font-semibold text-gold-ink hover:bg-gold-light">
            + Tambah kategori
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3 text-center">Jumlah produk</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                {{-- @forelse = @foreach + @empty (tampil jika data kosong) --}}
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $category->description ?: '—' }}</td>
                        <td class="px-4 py-3 text-center">{{ $category->products_count }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="font-medium text-gold-dark hover:underline">Edit</a>

                            {{-- Hapus harus lewat form DELETE, bukan link biasa --}}
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline"
                                  onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="ml-3 font-medium text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>