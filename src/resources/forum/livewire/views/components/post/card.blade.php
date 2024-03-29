<div id="post-{{ $post->sequence }}" class="post-card my-4" x-data="postCard" data-post="{{ $post->id }}" {{ $selectable ? 'x-on:change=onPostChanged' : '' }}>
    <div class="bg-white shadow-md rounded-lg flex flex-col sm:flex-row items-stretch" {{ $post->trashed() ? 'opacity-75' : '' }}" :class="classes">
        @if ($showAuthorPane)
            <div class="flex max-w-full sm:max-w-40 lg:max-w-full lg:w-56 px-6 py-4 sm:py-6 border-b sm:border-b-0 sm:border-r border-slate-200">
                <div class="grow text-lg font-medium truncate">
                    {{ $post->authorName }} weeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee
                </div>
                <div>
                    @if (! isset($single) || ! $single)
                        <a href="{{ Forum::route('thread.show', $post) }}">#{{ $post->sequence }}</a>
                    @endif
                </div>
            </div>
        @endif
        <div class="grow p-6">
            @if (isset($post->parent))
                <livewire:forum::components.post.quote :post="$post->parent" />
            @endif

            {!! Forum::render($post->content) !!}

            <div class="flex mt-4">
                <div class="grow text-slate-500">
                    <livewire:forum::components.timestamp :carbon="$post->created_at" />
                    @if ($post->hasBeenUpdated())
                        ({{ trans('forum::general.last_updated') }} <livewire:forum::components.timestamp :carbon="$post->updated_at" />)
                    @endif
                </div>
                @if (!isset($single) || !$single)
                    <div>
                        @if (!$post->trashed())
                            <a href="{{ Forum::route('post.show', $post) }}" class="font-medium">
                                {{ trans('forum::general.permalink') }}
                            </a>
                            @if ($post->sequence != 1)
                                @can ('deletePosts', $post->thread)
                                    @can ('delete', $post)

                                    @endcan
                                @endcan
                            @endif
                            @can ('edit', $post)
                                <a href="{{ Forum::route('post.edit', $post) }}" class="font-medium ml-2">
                                    {{ trans('forum::general.edit') }}
                                </a>
                            @endcan
                            @can ('reply', $post->thread)
                                <a href="{{ Forum::route('thread.reply', $post->thread) }}?parent_id={{ $post->id }}" class="font-medium ml-2">
                                    {{ trans('forum::general.reply') }}
                                </a>
                            @endcan
                        @else
                            @can ('restorePosts', $post->thread)
                                @can ('restore', $post)

                                @endcan
                            @endcan
                        @endif
                        @if ($selectable)
                            @can ('deletePosts', $post->thread)
                                @can ('delete', $post)
                                    <div class="inline-block ml-4" style="margin-bottom: -2rem;">
                                        <x-forum::form.input-checkbox
                                            id=""
                                            :value="$post->id"
                                            @change="onChanged" />
                                    </div>
                                @endcan
                            @endcan
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


@script
<script>
Alpine.data('postCard', () => {
    return {
        classes: 'outline-none',
        onChanged(event) {
            event.stopPropagation();

            if (event.target.checked) {
                this.classes = 'outline outline-blue-500';
            } else {
                this.classes = 'outline-none';
            }

            $dispatch('change', { isSelected: event.target.checked, id: event.target.value });
        }
    }
});
</script>
@endscript
