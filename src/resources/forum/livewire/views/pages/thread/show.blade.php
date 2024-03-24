<div>
    @include ('forum::components.breadcrumbs')
    @include ('forum::components.alerts')

    <h1 class="mb-0" style="color: {{ $thread->category->color }}">{{ $thread->title }}</h1>

    <div class="flex mt-6 mb-8">
        <div class="grow">
        </div>
    </div>

    <div class="my-4">
        @foreach ($thread->posts as $post)
            <livewire:forum::components.post.card :post="$post" />
        @endforeach
    </div>

    <h2>{{ trans('forum::general.quick_reply') }}</h2>

    <div class="bg-white rounded-md shadow-md p-6 mt-4">
        <form wire:submit="reply">
            @include ('forum::components.form.textarea', ['model' => 'content'])

            <div class="text-right mt-6">
                @include ('forum::components.form.button', ['label' => trans('forum::general.reply')])
            </div>
        </form>
    </div>
</div>
