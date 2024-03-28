<div x-data="category" x-on:page-changed="onPageChanged">
    @include ('forum::components.loading-overlay')
    @include ('forum::components.breadcrumbs')

    <h1 class="mb-0" style="color: {{ $category->color }}">{{ $category->title }}</h1>
    <h2 class="mt-0 text-slate-500">{{ $category->description }}</h2>

    @foreach ($category->descendants as $child)
        <livewire:forum::components.category.card :category="$child" :key="$child->id" />
    @endforeach

    <div class="flex mt-6 mb-8">
        <div class="grow">
        </div>
        @if ($category->accepts_threads)
            <div>
                <x-forum::button
                    :href="Forum::route('thread.create', $category)"
                    icon="pencil-outline"
                    :label="trans('forum::threads.new_thread')" />
            </div>
        @endif
    </div>

    @if (count($selectableThreadIds) > 0)
        <div class="flex justify-end">
            <x-forum::form.input-checkbox
                id="toggle-all"
                value=""
                :label="trans('forum::threads.select_all')"
                x-model="toggledAll"
                @click="toggleAll" />
        </div>
    @endif

    <div class="my-4">
        @foreach ($threads as $thread)
            <livewire:forum::components.thread.card
                :$thread
                :key="$thread->id . $updateKey"
                :selectable="in_array($thread->id, $selectableThreadIds)" />
        @endforeach
    </div>

    <div x-show="selectedThreads.length > 0" class="fixed bottom-0 right-0 z-40 min-w-96 bg-white shadow-md rounded-md m-4 p-6">
        <h3>{{ trans('forum::general.with_selection') }}</h3>

        <x-forum::form.input-select
            id="selected-action"
            x-model="selectedAction">
                <option value="none" disabled>{{ trans_choice('forum::general.actions', 1) }}...</option>
            @can ('deleteThreads', $category)
                <option value="delete">{{ trans('forum::general.delete') }}</option>
            @endcan
            @can ('restoreThreads', $category)
                <option value="restore">{{ trans('forum::general.restore') }}</option>
            @endcan
            @can ('moveThreadsFrom', $category)
                <option value="move">{{ trans('forum::general.move') }}</option>
            @endcan
            @can ('lockThreads', $category)
                <option value="lock">{{ trans('forum::threads.lock') }}</option>
                <option value="unlock">{{ trans('forum::threads.unlock') }}</option>
            @endcan
            @can ('pinThreads', $category)
                <option value="pin">{{ trans('forum::threads.pin') }}</option>
                <option value="unpin">{{ trans('forum::threads.unpin') }}</option>
            @endcan
        </x-forum::form.input-select>

        @if (config('forum.general.soft_deletes'))
            <x-forum::form.input-checkbox
                id="permadelete"
                value=""
                :label="trans('forum::general.perma_delete')"
                x-show="selectedAction == 'delete'"
                x-model="permadelete" />
        @endif

        <x-forum::form.input-select
            id="destination-category"
            :label="trans_choice('forum::categories.category', 1)"
            x-show="selectedAction == 'move'"
            x-model="destinationCategory">
            <option value="0" disabled>...</option>
            @include ('forum::components.category.options', ['categories' => $threadDestinationCategories, 'disable' => $category->id])
        </x-forum::form.input-select>

        <x-forum::button
            :label="trans('forum::general.proceed')"
            @click="applySelectedAction"
            :wire-confirm="trans('forum::general.generic_confirm')"
            x-bind:disabled="selectedAction == 'none' || selectedAction == 'move' && destinationCategory == 0" />
    </div>

    {{ $threads->links('forum::components.pagination') }}
</div>

@script
<script>
Alpine.data('category', () => {
    return {
        toggledAll: false,
        selectedThreads: [],
        selectedAction: 'none',
        permadelete: false,
        destinationCategory: 0,
        confirmMessage: "{{ trans('forum::general.generic_confirm') }}",
        reset() {
            this.toggledAll = false;
            this.selectedThreads = [];
            this.permadelete = false;
            this.destinationCategory = 0;
        },
        onThreadChanged(event) {
            if (event.detail.isSelected) {
                this.selectedThreads.push(event.detail.id);
            } else {
                this.selectedThreads.splice(this.selectedThreads.indexOf(event.detail.id), 1);
            }
        },
        onPageChanged(event) {
            this.reset();
        },
        async applySelectedAction() {
            if (this.selectedAction == null || this.selectedThreads.length == 0) {
                return;
            }

            let result;
            switch (this.selectedAction) {
                case 'delete':
                    if (!confirm(this.confirmMessage)) return;
                    result = await $wire.deleteThreads(this.selectedThreads, this.permadelete);
                    break;
                case 'restore':
                    result = await $wire.restoreThreads(this.selectedThreads);
                    break;
                case 'move':
                    result = await $wire.moveThreads(this.selectedThreads, this.destinationCategory);
                    break;
                case 'lock':
                    result = await $wire.lockThreads(this.selectedThreads);
                    break;
                case 'unlock':
                    result = await $wire.unlockThreads(this.selectedThreads);
                    break;
                case 'pin':
                    result = await $wire.pinThreads(this.selectedThreads);
                    break;
                case 'unpin':
                    result = await $wire.unpinThreads(this.selectedThreads);
                    break;
            }

            if (result.type == 'success') this.reset();
            $dispatch('alert', result);
        },
        toggleAll(event) {
            this.toggledAll = !this.toggledAll;
            const checkboxes = document.querySelectorAll('[data-thread] input[type=checkbox]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.toggledAll;
                checkbox.dispatchEvent(new Event('change'));
            });
        }
    }
});
</script>
@endscript
