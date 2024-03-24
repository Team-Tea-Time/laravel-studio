<div class="my-4">
    <div class="bg-white shadow-md rounded-lg flex items-stretch">
        <div class="min-w-48 p-6 border-r border-slate-200">
            <div class="text-lg font-medium">
                {{ $post->authorName }}
            </div>
            <div class="text-slate-500">
                @include ('forum::components.timestamp', ['carbon' => $post->created_at])
                @if ($post->hasBeenUpdated())
                    ({{ trans('forum::general.last_updated') }} @include ('forum::components.timestamp', ['carbon' => $post->updated_at]))
                @endif
            </div>
        </div>
        <div class="grow p-6">
            {!! Forum::render($post->content) !!}
        </div>
    </div>
</div>
