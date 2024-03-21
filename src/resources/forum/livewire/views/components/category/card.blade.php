<div class="bg-white shadow-md rounded-lg my-4 p-6 flex items-center justify-items-center">
    <div class="self-stretch">
        <div class="w-3 h-full rounded-full mr-6" style="background-color: {{ $category->color }}"></div>
    </div>
    <div class="flex-1">
        <h2>
            <a href="{{ $category->route }}" style="color: {{ $category->color }}">{{ $category->title }}</a>
        </h2>
        <h3 class="text-slate-600">{{ $category->description }}</h3>
    </div>
    <div class="flex-1 text-center text-base">
        @if ($category->accepts_threads)
            <span class="bg-zinc-300 text-zinc-600 rounded-full px-2 m-2">
                {{ trans_choice('forum::threads.thread', 2) }}: {{ $category->thread_count }}
            </span>
            <span class="bg-zinc-300 text-zinc-600 rounded-full px-2 m-2">
                {{ trans_choice('forum::posts.post', 2) }}: {{ $category->post_count }}
            </span>
        @endif
    </div>
    <div class="flex-1 text-right">
        @if ($category->accepts_threads)
            @if ($category->newestThread)
                <div>
                    <a href="{{ Forum::route('thread.show', $category->newestThread) }}">{{ $category->newestThread->title }}</a>
                    @include ('forum::components.timestamp', ['carbon' => $category->newestThread->created_at])
                </div>
            @endif
            @if ($category->latestActiveThread && $category->latestActiveThread->post_count > 1)
                <div>
                    <a href="{{ Forum::route('thread.show', $category->latestActiveThread->lastPost) }}">Re: {{ $category->latestActiveThread->title }}</a>
                    @include ('forum::components.timestamp', ['carbon' => $category->latestActiveThread->lastPost->created_at])
                </div>
            @endif
        @endif
    </div>
</div>
