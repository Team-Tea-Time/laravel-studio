<div>
    @include ('forum::components.loading-overlay')
    @include ('forum::components.breadcrumbs')

    <div class="flex justify-center items-center">
        <div class="grow max-w-screen-lg">
            <h1>{{ trans('forum::threads.new_thread') }} ({{ $category->title }})</h1>

            <div class="bg-white rounded-md shadow-md my-2 p-6">
                <form wire:submit="save">
                    @include ('forum::components.form.input-text', ['model' => 'title', 'label' => trans('forum::general.title')])
                    @include ('forum::components.form.textarea', ['model' => 'content'])

                    <div class="flex mt-6">
                        <div class="grow">
                            <livewire:forum::components.button
                                href="{{ URL::previous() }}"
                                type="secondary"
                                label="{{ trans('forum::general.cancel') }}" />
                        </div>
                        <div class="grow text-right">
                            @include ('forum::components.form.button', ['label' => trans('forum::general.create')])
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
