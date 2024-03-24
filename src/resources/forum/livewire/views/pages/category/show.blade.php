<div>
    @include('forum::components.breadcrumbs')

    <h1 class="mb-0" style="color: {{ $category->color }}">{{ $category->title }}</h1>
    <h2 class="mt-0 text-slate-500">{{ $category->description }}</h2>

    <div class="flex mt-6 mb-8">
        <div class="grow">
        </div>
        @if ($category->accepts_threads)
            <div>
                <livewire:forum::components.button
                    href="{{ Forum::route('thread.create', $category) }}"
                    icon="pencil-outline"
                    label="{{ trans('forum::threads.new_thread') }}" />
            </div>
        @endif
    </div>

    <div class="my-4">
        @foreach ($threads as $thread)
            <livewire:forum::components.thread.card :thread="$thread" />
        @endforeach
    </div>
</div>
