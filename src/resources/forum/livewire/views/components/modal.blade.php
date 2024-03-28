<div class="fixed top-0 right-0 bottom-0 left-0 bg-white/40 z-50" {{ $attributes }}>
    <div class="grid h-screen justify-items-center items-center" {!! !empty($onClose) ? "@click.self=\"{$onClose}\"" : '' !!}>
        <div class="min-w-96 bg-white shadow-lg rounded-md">
            <div class="flex border-b border-slate-300 p-6 pb-4">
                <div class="grow">
                    <h2>{{ $heading }}</h2>
                </div>
                @if (!empty($onClose))
                    <div class="pl-4 pt-1">
                        <a href="#" class="" @click="{{ $onClose }}">
                            @include ('forum::components.icons.x-mark')
                        </a>
                    </div>
                @endif
            </div>
            <div class="p-6 pt-4 mt-2">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
