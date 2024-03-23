<div>
    @include('forum::components.breadcrumbs')

    <h1 class="mb-0" style="color: {{ $category->color }}">{{ $category->title }}</h1>
    <h2 class="mt-0 text-slate-500">{{ $category->description }}</h2>

    <div class="mt-6 mb-8">
        @if ($category->accepts_threads)
            <livewire:components.button
                href="{{ Forum::route('thread.create', $category) }}"
                label="{{ trans('forum::threads.new_thread') }}" />
        @endif
    </div>

    <div class="my-4">
        @foreach ($threads as $thread)
            <livewire:components.thread.card :thread="$thread" />
        @endforeach
    </div>
</div>
