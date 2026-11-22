

<x-layouts.admin title="Dashboard">
    <div class="rounded-xl border border-gray-200 bg-white p-6">
        <p class="text-gray-600">Halo, <span class="font-semibold text-gray-900">{{ auth()->user()->name }}</span>.</p>
        <p class="mt-1 text-sm text-gray-500">Ringkasan</p>
    </div>
</x-layouts.admin>