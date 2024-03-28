@php
$colorClasses = match ($type) {
    'primary', '', null => 'text-white bg-blue-600 hover:text-white hover:bg-blue-500',
    'secondary' => 'text-zinc-800 bg-zinc-300 opacity-70 hover:opacity-100'
};
@endphp

<a href="{{ $href }}" class="link-button inline-block min-w-36 rounded-full px-4 py-2 font-medium text-lg text-center {{ $colorClasses }}">
    @if (!empty($icon))
        @include ("forum::components.icons.{$icon}")
    @endif
    {{ $label }}
</a>
