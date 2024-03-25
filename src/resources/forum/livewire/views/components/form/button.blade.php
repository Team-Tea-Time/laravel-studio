<button type="submit" class="inline-block min-w-36 rounded-full px-4 py-2 font-medium text-lg text-center text-white hover:text-white bg-blue-600 hover:bg-blue-500" {{ $attributes ?? '' }}>
    @if (isset($icon))
        @include ("forum::components.icons.{$icon}")
    @endif
    {{ $label }}
</button>
