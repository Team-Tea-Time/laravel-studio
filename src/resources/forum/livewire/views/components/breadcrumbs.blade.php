<nav class="breadcrumbs bg-slate-300 rounded-lg p-2 my-2" aria-label="breadcrumb">
    <ol class="flex">
        <li>
            <a href="{{ url(config('forum.frontend.router.prefix')) }}" class="flex items-center">
                @include ('forum::components.icons.home-mini')
                {{ trans('forum::general.index') }}
            </a>
        </li>
        @if (isset($category) && $category)
            @include ('forum::components.breadcrumb-categories', ['category' => $category])
        @endif
        @if (isset($thread) && $thread)
            <li><a href="{{ Forum::route('thread.show', $thread) }}">{{ $thread->title }}</a></li>
        @endif
        @if (isset($breadcrumbs_append) && count($breadcrumbs_append) > 0)
            @foreach ($breadcrumbs_append as $breadcrumb)
                <li>{{ $breadcrumb }}</li>
            @endforeach
        @endif
    </ol>
</nav>
