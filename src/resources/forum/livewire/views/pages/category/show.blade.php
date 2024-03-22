<div>
    @include('forum::components.breadcrumbs')

    <h1 class="mb-0" style="color: {{ $category->color }}">{{ $category->title }}</h1>
    <h2 class="mt-0 text-slate-500">{{ $category->description }}</h2>

    <div class="my-4">
        <livewire:components.button
            href="{{ Forum::route('thread.create', $category) }}"
            label="{{ trans('forum::threads.new_thread') }}" />
    </div>
</div>
