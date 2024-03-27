<a href="{{ $href }}" class="inline-block min-w-36 rounded-full px-4 py-2 font-medium text-lg text-center {{ $colorClasses }}">
    @if (isset($icon))
        @include ("forum::components.icons.{$icon}")
    @endif
    {{ $label }}
</a>
