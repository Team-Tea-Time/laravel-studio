<div id="post-{{ $post->sequence }}" class="post-card my-4" x-data="postCard" data-post="{{ $post->id }}" {{ $selectable ? 'x-on:change=onPostChanged' : '' }}>
    <div class="bg-white shadow-md rounded-lg flex items-stretch" {{ $post->trashed() ? 'opacity-75' : '' }}" :class="classes">
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
            @if ($selectable)
                @can ('deletePosts', $post->thread)
                    @can ('delete', $post)
                        <div class="inline-block float-right">
                            <x-forum::form.input-checkbox
                                id=""
                                :value="$post->id"
                                @change="onChanged" />
                        </div>
                    @endcan
                @endcan
            @endif

            {!! Forum::render($post->content) !!}

            <div class="flex mt-4">
                <div class="grow text-slate-500">
                    <livewire:forum::components.timestamp :carbon="$post->created_at" />
                    @if ($post->hasBeenUpdated())
                        ({{ trans('forum::general.last_updated') }} <livewire:forum::components.timestamp :carbon="$post->updated_at" />)
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
