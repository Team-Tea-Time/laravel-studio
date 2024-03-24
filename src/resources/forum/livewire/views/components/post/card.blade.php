<div class="my-4">
    <div class="bg-white shadow-md rounded-lg flex items-stretch">
        <div class="flex flex-col min-w-48 p-6 border-r border-slate-200">
            <div class="grow text-lg font-medium">
                {{ $post->authorName }}
            </div>
            <div>
                @if (! isset($single) || ! $single)
                    <a href="{{ Forum::route('thread.show', $post) }}">#{{ $post->sequence }}</a>
                @endif
            </div>
        </div>
        <div class="grow p-6">
            @if ((!isset($single) || !$single) && $post->sequence != 1)
                @can ('deletePosts', $post->thread)
                    @can ('delete', $post)
                        <div class="float-right">
                            <input type="checkbox" name="posts[]" :value="{{ $post->id }}" />
                        </div>
                    @endcan
                @endcan
            @endif

            {!! Forum::render($post->content) !!}

            <div class="flex mt-4">
                <div class="grow text-slate-500">
                    @include ('forum::components.timestamp', ['carbon' => $post->created_at])
                    @if ($post->hasBeenUpdated())
                        ({{ trans('forum::general.last_updated') }} @include ('forum::components.timestamp', ['carbon' => $post->updated_at]))
                    @endif
                </div>
                <div>
                    <a href="{{ $post->route }}" class="text-slate-500">
                        {{ trans('forum::general.permalink') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
