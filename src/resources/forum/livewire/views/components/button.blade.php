@php
$colorClasses = match ($type) {
    'primary', null => 'text-white hover:text-white bg-blue-600 hover:bg-blue-500',
    'secondary' => 'text-zinc-600 hover:text-zinc-600 bg-zinc-300 hover:bg-zinc-200'
}
@endphp

<a href="{{ $href }}" class="inline-block min-w-36 rounded-full px-4 py-2 font-medium text-lg text-center {{ $colorClasses }}">
    @if (isset($icon))
        @include ("forum::components.icons.{$icon}")
    @endif
    {{ $label }}
</a>
