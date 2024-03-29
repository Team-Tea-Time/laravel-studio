<div x-data="thread">
    @include ('forum::components.loading-overlay')
    @include ('forum::components.breadcrumbs')

    <h1 class="mb-0" style="color: {{ $thread->category->color }}">{{ $thread->title }}</h1>

    <div class="flex items-center mt-4 mb-6">
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

        @if (count($selectablePostIds) > 0)
            <div style="margin-bottom: -.6rem;">
                <x-forum::form.input-checkbox
                    id="toggle-all"
                    value=""
                    :label="trans('forum::posts.select_all')"
                    x-model="toggledAll"
                    @click="toggleAll" />
            </div>
        @endif
    </div>

    <div class="flex flex-col lg:flex-row items-center">
        <div class="grow">
            <div class="inline-flex">
                @if (Gate::allows('deleteThreads', $thread->category) && Gate::allows('delete', $thread))
                    @if ($thread->trashed())
                        <x-forum::group-button
                            intent="danger"
                            size="small"
                            icon="trash-mini"
                            href="#"
                            :label="trans('forum::general.perma_delete')"
                            @click.prevent="permaDelete" />
                    @else
                        <x-forum::group-button
                            intent="danger"
                            size="small"
                            icon="trash-mini"
                            href="#"
                            :label="trans('forum::general.delete')"
                            @click.prevent="delete" />
                    @endif
                @endif
                @if ($thread->trashed() && Gate::allows('restoreThreads', $thread->category) && Gate::allows('restore', $thread))
                    <x-forum::group-button
                        intent="secondary"
                        size="small"
                        icon="arrow-path-mini"
                        :label="trans('forum::general.restore')"
                        @click.prevent="restore" />
                @endif
                @if (!$thread->trashed())
                    @can ('lockThreads', $thread->category)
                        @if ($thread->locked)
                            <x-forum::group-button
                                intent="secondary"
                                size="small"
                                icon="lock-open-mini"
                                :label="trans('forum::threads.unlock')"
                                @click.prevent="unlock" />
                        @else
                            <x-forum::group-button
                                intent="secondary"
                                size="small"
                                icon="lock-closed-mini"
                                :label="trans('forum::threads.lock')"
                                @click.prevent="lock" />
                        @endif
                    @endcan
                    @can ('pinThreads', $thread->category)
                        @if ($thread->pinned)
                            <x-forum::group-button
                                intent="secondary"
                                size="small"
                                icon="arrow-down-mini"
                                :label="trans('forum::threads.unpin')"
                                @click.prevent="unpin" />
                        @else
                            <x-forum::group-button
                                intent="secondary"
                                size="small"
                                icon="arrow-up-mini"
                                :label="trans('forum::threads.pin')"
                                @click.prevent="pin" />
                        @endif
                    @endcan
                    @can ('rename', $thread)
                        <x-forum::group-button
                            intent="secondary"
                            size="small"
                            icon="pencil-mini"
                            :label="trans('forum::general.rename')"
                            @click.prevent="rename" />
                    @endcan
                    @can ('moveThreadsFrom', $thread->category)
                        <x-forum::group-button
                            intent="secondary"
                            size="small"
                            icon="arrow-right-mini"
                            :label="trans('forum::general.move')"
                            @click.prevent="move" />
                    @endcan
                @endif
            </div>
        </div>
        @if (!$thread->trashed())
            @can ('reply', $thread)
                <div class="mt-4 lg:mt-0">
                    <x-forum::link-button
                        intent="secondary"
                        href="#quick-reply"
                        :label="trans('forum::general.quick_reply')" />

                    <x-forum::link-button
                        intent="primary"
                        :href="Forum::route('thread.reply', $thread)"
                        :label="trans('forum::general.reply')" />
                </div>
            @endcan
        @endif
    </div>

    <div>
        @foreach ($posts as $post)
            <livewire:forum::components.post.card
                :$post
                :key="$post->id . $updateKey"
                :selectable="in_array($post->id, $selectablePostIds)" />
        @endforeach
    </div>

    {{ $posts->links('forum::components.pagination') }}

    @if (!$thread->trashed() && Gate::allows('reply', $thread))
        <h2 id="quick-reply">{{ trans('forum::general.quick_reply') }}</h2>

        <div class="bg-white rounded-md shadow-md p-6 mt-4">
            <x-forum::form.input-textarea wire:model="content" />

            <div class="text-right mt-6">
                <x-forum::button :label="trans('forum::general.reply')" @click="reply" />
            </div>
        </div>
    @endif
</div>

@script
<script>
Alpine.data('thread', () => {
    return {
        toggledAll: false,
        selectedPosts: [],
        reset() {
            this.toggledAll = false;
            this.selectedPosts = [];
        },
        onPostChanged(event) {
            if (event.detail.isSelected) {
                this.selectedPosts.push(event.detail.id);
            } else {
                this.selectedPosts.splice(this.selectedPosts.indexOf(event.detail.id), 1);
            }
        },
        onPageChanged(event) {
            this.reset();
        },
        async reply(event) {
            const result = await $wire.reply();
            if (result === null) return;
            if (result.type == 'success') this.reset();
            $dispatch('alert', result);
        },
        toggleAll(event) {
            this.toggledAll = !this.toggledAll;
            const checkboxes = document.querySelectorAll('[data-post] input[type=checkbox]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.toggledAll;
                checkbox.dispatchEvent(new Event('change'));
            });
        }
    }
});
</script>
@endscript
