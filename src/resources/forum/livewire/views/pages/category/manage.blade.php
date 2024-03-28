<div x-data="manage">
    @include ('forum::components.loading-overlay')
    @include ('forum::components.breadcrumbs')

    <div class="flex justify-center items-center">
        <div class="grow max-w-screen-lg">
            <h1>{{ trans('forum::general.manage') }}</h1>

            <div class="bg-white rounded-md shadow-md my-2 p-6">
                <ol id="category-tree">
                    @include ('forum::components.category.draggable-items', ['categories' => $categories])
                </ol>

                <div class="mt-4 text-right">
                    <x-forum::button
                        id="save"
                        :label="trans('forum::general.save')"
                        x-ref="button"
                        @click="save"
                        disabled />
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
Alpine.data('manage', () => {
    return {
        nestedSort: null,
        init () {
            this.initialiseNestedSort();
        },
        initialiseNestedSort() {
            this.nestedSort = new NestedSort({
                propertyMap: {
                    id: 'id',
                    parent: 'parent_id',
                    text: 'title',
                },
                actions: {
                    onDrop: this.onDrop
                },
                el: '#category-tree',
                listItemClassNames: 'border border-slate-300 rounded-md text-lg p-4 my-2'
            });
        },
        onDrop (data) {
            $wire.categoryData = data;
            $refs.button.disabled = false;
        },
        async save () {
            const result = await $wire.save();
            $dispatch('alert', result);
            this.initialiseNestedSort();
        }
    }
});
</script>
@endscript
