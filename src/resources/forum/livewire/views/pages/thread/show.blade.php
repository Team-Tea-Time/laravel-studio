<div>
    @include ('forum::components.breadcrumbs')
    @include ('forum::components.alerts')

    <h1 class="mb-0" style="color: {{ $thread->category->color }}">{{ $thread->title }}</h1>

    <div class="flex mt-4 mb-6">
        <div class="grow">
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
            @if ($thread->trashed())
                <livewire:forum::components.pill
                    bg-color="bg-zinc-400"
                    text-color="text-zinc-950"
                    margin="mr-2"
                    icon="trash-mini"
                    :text="trans('forum::general.deleted')" />
            @endif
        </div>
    </div>

    <div>
        @foreach ($posts as $post)
            <livewire:forum::components.post.card :post="$post" />
        @endforeach
    </div>

    {{ $posts->links('forum::components.pagination') }}

    @if (!$thread->trashed() && Gate::allows('reply', $thread))
        <h2>{{ trans('forum::general.quick_reply') }}</h2>

        <div class="bg-white rounded-md shadow-md p-6 mt-4">
            <form wire:submit="reply">
                @include ('forum::components.form.textarea', ['model' => 'content'])

                <div class="text-right mt-6">
                    @include ('forum::components.form.button', ['label' => trans('forum::general.reply')])
                </div>
            </form>
        </div>
    @endif
</div>
