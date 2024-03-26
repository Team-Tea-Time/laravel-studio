<div x-data="category" x-on:page-changed="onPageChanged">
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
                <livewire:forum::components.button
                    href="{{ Forum::route('thread.create', $category) }}"
                    icon="pencil-outline"
                    label="{{ trans('forum::threads.new_thread') }}" />
            </div>
        @endif
    </div>

    <div class="flex justify-end">
        @include ('forum::components.form.input-checkbox', [
            'id' => 'toggle-all',
            'value' => '',
            'label' => trans('forum::threads.select_all'),
            'attributes' => 'x-model=toggledAll @click=toggleAll'
        ])
    </div>

    <div class="my-4">
        @foreach ($threads as $thread)
            <livewire:forum::components.thread.card
                :$thread
                :key="$thread->id . $updateKey"
                :selectable="in_array($thread->id, $selectableThreadIds)" />
        @endforeach
    </div>

    <div x-show="selectedThreads.length > 0" class="fixed bottom-0 right-0 z-50 bg-white shadow-md rounded-md m-4 p-6">
        <p class="font-medium">{{ trans('forum::general.with_selection') }}</p>

        @include ('forum::components.form.button', [
            'label' => 'Lock threads',
            'attributes' => '@click=lockThreads'
        ])
        @include ('forum::components.form.button', [
            'label' => 'Unlock threads',
            'attributes' => '@click=unlockThreads'
        ])
        @include ('forum::components.form.button', [
            'label' => 'Pin threads',
            'attributes' => '@click=pinThreads'
        ])
        @include ('forum::components.form.button', [
            'label' => 'Unpin threads',
            'attributes' => '@click=unpinThreads'
        ])
    </div>

    {{ $threads->links('forum::components.pagination') }}
</div>

@script
<script>
    Alpine.data('category', () => {
        return {
            toggledAll: false,
            selectedThreads: [],
            reset() {
                this.toggledAll = false;
                this.selectedThreads = [];
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
            async lockThreads(event) {
                const result = await $wire.lockThreads(this.selectedThreads);
                if (result.type == 'success') this.reset();
                $dispatch('alert', result);
            },
            async unlockThreads(event) {
                const result = await $wire.unlockThreads(this.selectedThreads);
                if (result.type == 'success') this.reset();
                $dispatch('alert', result);
            },
            async pinThreads(event) {
                const result = await $wire.pinThreads(this.selectedThreads);
                if (result.type == 'success') this.reset();
                $dispatch('alert', result);
            },
            async unpinThreads(event) {
                const result = await $wire.unpinThreads(this.selectedThreads);
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
    })
</script>
@endscript
