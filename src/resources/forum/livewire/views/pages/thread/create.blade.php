<div>
    @include('forum::components.breadcrumbs')

    <h1>{{ trans('forum::threads.new_thread') }} ({{ $category->title }})</h1>

    <form wire:submit="save">
        <input type="text" wire:model="title">

        <input type="text" wire:model="content">

        <button type="submit">Save</button>
    </form>
</div>
