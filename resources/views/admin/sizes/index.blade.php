<x-layouts.admin title="Ukuran & Harga">
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-gray-500">Harga berlaku untuk semua aroma (flat per ukuran botol).</p>
        <a href="{{ route('admin.sizes.create') }}"
           class="rounded-lg bg-gold px-4 py-2 text-sm font-semibold text-gold-ink hover:bg-gold-light">+ Tambah ukuran</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3">Ukuran</th>
                    <th class="px-4 py-3 text-right">Harga jual</th>
                    <th class="px-4 py-3 text-right">Harga modal</th>
                    <th class="px-4 py-3 text-right">Margin</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($sizes as $size)
                    @php
                        $margin = $size->price - $size->cost_price;
                        $percent = $size->price > 0 ? round($margin / $size->price * 100) : 0;
                    @endphp
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $size->size_label }}</td>
                        <td class="px-4 py-3 text-right">{{ rupiah($size->price) }}</td>
                        <td class="px-4 py-3 text-right text-gray-500">{{ rupiah($size->cost_price) }}</td>
                        <td class="px-4 py-3 text-right">
                            <span class="font-medium text-green-700">{{ rupiah($margin) }}</span>
                            <span class="text-xs text-gray-400">({{ $percent }}%)</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if ($size->is_active)
                                <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">Aktif</span>
                            @else
                                <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-500">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.sizes.edit', $size) }}" class="font-medium text-gold-dark hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.sizes.destroy', $size) }}" class="inline"
                                  onsubmit="return confirm('Hapus ukuran {{ $size->size_label }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="ml-3 font-medium text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada ukuran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>