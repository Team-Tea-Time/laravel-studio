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
                            @click.prevent="confirmAction('permadelete', '{{ trans('forum::threads.confirm_perma_delete') }}')" />
                    @else
                        <x-forum::group-button
                            intent="danger"
                            size="small"
                            icon="trash-mini"
                            href="#"
                            :label="trans('forum::general.delete')"
                            @click.prevent="confirmAction('delete', '{{ trans('forum::threads.confirm_delete') }}')" />
                    @endif
                @endif
                @if ($thread->trashed() && Gate::allows('restoreThreads', $thread->category) && Gate::allows('restore', $thread))
                    <x-forum::group-button
                        intent="secondary"
                        size="small"
                        icon="arrow-path-mini"
                        :label="trans('forum::general.restore')"
                        @click.prevent="confirmAction('restore', '{{ trans('forum::threads.confirm_restore') }}')" />
                @endif
                @if (!$thread->trashed())
                    @can ('lockThreads', $thread->category)
                        @if ($thread->locked)
                            <x-forum::group-button
                                intent="secondary"
                                size="small"
                                icon="lock-open-mini"
                                :label="trans('forum::threads.unlock')"
                                @click.prevent="confirmAction('unlock', '{{ trans('forum::threads.confirm_unlock') }}')" />
                        @else
                            <x-forum::group-button
                                intent="secondary"
                                size="small"
                                icon="lock-closed-mini"
                                :label="trans('forum::threads.lock')"
                                @click.prevent="confirmAction('lock', '{{ trans('forum::threads.confirm_lock') }}')" />
                        @endif
                    @endcan
                    @can ('pinThreads', $thread->category)
                        @if ($thread->pinned)
                            <x-forum::group-button
                                intent="secondary"
                                size="small"
                                icon="arrow-down-mini"
                                :label="trans('forum::threads.unpin')"
                                @click.prevent="confirmAction('unpin', '{{ trans('forum::threads.confirm_unpin') }}')" />
                        @else
                            <x-forum::group-button
                                intent="secondary"
                                size="small"
                                icon="arrow-up-mini"
                                :label="trans('forum::threads.pin')"
                                @click.prevent="confirmAction('pin', '{{ trans('forum::threads.confirm_pin') }}')" />
                        @endif
                    @endcan
                    @can ('rename', $thread)
                        <x-forum::group-button
                            intent="secondary"
                            size="small"
                            icon="pencil-mini"
                            :label="trans('forum::general.rename')"
                            @click.prevent="confirmAction('rename', '')" />
                    @endcan
                    @can ('moveThreadsFrom', $thread->category)
                        <x-forum::group-button
                            intent="secondary"
                            size="small"
                            icon="arrow-right-mini"
                            :label="trans('forum::general.move')"
                            @click.prevent="confirmAction('move', '')" />
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
        <div id="quick-reply">
            <h2>{{ trans('forum::general.quick_reply') }}</h2>

            <div class="bg-white rounded-md shadow-md p-6 mt-4">
                <x-forum::form.input-textarea wire:model="threadReplyForm.content" />

                <div class="text-right mt-6">
                    <x-forum::button :label="trans('forum::general.reply')" @click="reply" />
                </div>
            </div>
        </div>
    @endif

    <x-forum::modal x-show="showConfirmationModal" :heading="trans('forum::general.confirm_action')" onClose="showConfirmationModal = false">
        <span x-text="confirmationModalText"></span>

        <div x-show="action == 'rename'">
            <x-forum::form.input-text
                id="title"
                :label="trans('forum::general.title')"
                wire:model="threadEditForm.title" />
        </div>

        <div x-show="action == 'move'">
            <x-forum::form.input-select
                id="destination-category"
                :label="trans('forum::general.move_to')"
                wire:model="destinationCategoryId">
                <option value="0" disabled>...</option>
                @include ('forum::components.category.options', ['categories' => $threadDestinationCategories, 'disable' => $thread->category->id])
            </x-forum::form.input-select>
        </div>

        <div class="flex mt-4">
            <div class="grow">
                <x-forum::link-button
                    intent="secondary"
                    :label="trans('forum::general.cancel')"
                    @click.prevent="showConfirmationModal = false" />
            </div>
            <div>
                <x-forum::button
                    type="submit"
                    :label="trans('forum::general.proceed')"
                    @click="commitAction" />
            </div>
        </div>
    </x-forum::modal>
</div>

@script
<script>
Alpine.data('thread', () => {
    return {
        toggledAll: false,
        selectedPosts: [],
        bulkAction: null,
        showConfirmationModal: false,
        confirmationModalText: '',
        action: null,
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
        onPageChanged() {
            this.reset();
        },
        confirmAction(action, text) {
            this.action = action;
            this.confirmationModalText = text;
            this.showConfirmationModal = true;
        },
        async commitAction() {
            let result;
            switch (this.action) {
                case 'delete':
                    result = await $wire.delete(false);
                    break;
                case 'permadelete':
                    result = await $wire.delete(true);
                    break;
                case 'restore':
                    result = await $wire.restore();
                    break;
                case 'lock':
                    result = await $wire.lock();
                    break;
                case 'unlock':
                    result = await $wire.unlock();
                    break;
                case 'pin':
                    result = await $wire.pin();
                    break;
                case 'unpin':
                    result = await $wire.unpin();
                    break;
                case 'rename':
                    result = await $wire.rename();
                    break;
                case 'move':
                    result = await $wire.move();
                    break;
            }

            if (result === null) return;
            if (result.type == 'success') this.showConfirmationModal = false;
            $dispatch('alert', result);
        },
        async reply() {
            const result = await $wire.reply();
            if (result === null) return;
            if (result.type == 'success') this.reset();
            $dispatch('alert', result);
        },
        toggleAll() {
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
