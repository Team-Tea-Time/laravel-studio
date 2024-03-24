<div class="my-4">
    <div class="bg-white shadow-md rounded-lg p-4 flex items-center justify-items-center {{ $thread->trashed() ? 'opacity-75' : '' }}">
        <div class="grow max-w-xl">
            <a href="{{ $thread->route }}" class="block text-xl mb-2" style="color: {{ $thread->category->color }}">
                @if ($thread->pinned)
                    <livewire:forum::components.pill
                        bg-color="bg-amber-400"
                        text-color="text-amber-950"
                        margin="mr-2"
                        icon="arrow-up-circle-mini"
                        :text="trans('forum::threads.pinned')" />
                @endif
                @if ($thread->locked)
                    <livewire:forum::components.pill
                        bg-color="bg-rose-400"
                        text-color="text-rose-950"
                        margin="mr-2"
                        icon="lock-closed-mini"
                        :text="trans('forum::threads.locked')" />
                @endif
                @if ($thread->userReadStatus !== null && ! $thread->trashed())
                    <livewire:forum::components.pill
                        bg-color="bg-teal-400"
                        text-color="text-teal-950"
                        margin="mr-2"
                        icon="sparkles-mini"
                        :text="trans($thread->userReadStatus)" />
                @endif
                @if ($thread->trashed())
                    <livewire:forum::components.pill
                        bg-color="bg-zinc-400"
                        text-color="text-zinc-950"
                        margin="mr-2"
                        icon="trash-mini"
                        :text="trans('forum::general.deleted')" />
                @endif
                {{ $thread->title }}
            </a>
            {{ $thread->author->name }}
            <span class="text-slate-500">
                @include ('forum::components.timestamp', ['carbon' => $thread->created_at])
            </span>
        </div>
        <div class="grow align-center text-center">
            <livewire:forum::components.pill
                icon="chat-bubble-text-mini"
                :text="trans('forum::general.replies') . ': ' . $thread->reply_count" />
        </div>
        @if ($thread->lastPost)
            <div class="grow text-right">
                <a href="{{ Forum::route('thread.show', $thread->lastPost) }}" class="font-medium">{{ trans('forum::posts.view') }} @include ("forum::components.icons.arrow-right-mini")</a>
                <br>
                {{ $thread->lastPost->authorName }}
                <span class="text-slate-500">@include ('forum::components.timestamp', ['carbon' => $thread->lastPost->created_at])</span>
            </div>
        @endif
    </div>
</div>
