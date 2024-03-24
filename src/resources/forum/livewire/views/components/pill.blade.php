<span class="inline-block
    rounded-full
    text-base
    align-middle
    {{ $bgColor ?? 'bg-zinc-300' }}
    {{ $textColor ?? 'text-zinc-600' }}
    {{ $padding ?? 'px-2' }}
    {{ $margin ?? 'mx-2' }}">
    @if (isset($icon))
        @include ("forum::components.icons.{$icon}")
    @endif
    {{ $text }}
</span>
