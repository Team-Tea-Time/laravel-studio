<a href="{{ $href }}" class="rounded px-4 py-2 font-medium text-lg text-white hover:text-white bg-blue-600 hover:bg-blue-500">
    @if (isset($icon))
        @include ("forum::components.icons.{$icon}")
    @endif
    {{ $label }}
</a>
