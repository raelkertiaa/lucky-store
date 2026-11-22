@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'hint' => null,
    'prefix' => null,   // teks di depan input, misal "Rp"
])

<div>
    <label for="{{ $name }}" class="mb-1 block text-sm font-medium text-gray-700">{{ $label }}</label>

    <div class="flex rounded-lg shadow-sm">
        @if ($prefix)
            <span class="inline-flex items-center rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">
                {{ $prefix }}
            </span>
        @endif

        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
               value="{{ old($name, $value) }}"
               {{ $attributes->merge([
                   'class' => 'block w-full border-gray-300 text-sm focus:border-gold focus:ring-gold '
                       . ($prefix ? 'rounded-r-lg' : 'rounded-lg')
                       . ($errors->has($name) ? ' border-red-400' : ''),
               ]) }}>
    </div>

    @if ($hint)
        <p class="mt-1 text-xs text-gray-500">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>