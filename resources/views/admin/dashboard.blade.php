{{-- Memakai layout bawaan Breeze (tema terang), cocok untuk panel admin --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard Admin</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                Halo, {{ auth()->user()->name }}. Panel admin lengkap akan dibangun di Task 7.
            </div>
        </div>
    </div>
</x-app-layout>