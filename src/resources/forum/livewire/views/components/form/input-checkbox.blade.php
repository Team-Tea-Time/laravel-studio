<div class="flex {{ isset($reverse) && $reverse ? 'flex-row-reverse' : '' }} items-center mb-2">
    <input id="{{ $id }}" type="checkbox" value="{{ $value }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" {{ $attributes ?? '' }}>
    @if (isset($label))
        <label for="{{ $id }}" class="ms-2 font-medium text-gray-900 select-none">{{ $label }}</label>
    @endif
</div>
