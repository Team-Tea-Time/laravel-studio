<div>
    @include ('forum::components.breadcrumbs')
    @include ('forum::components.alerts')

    <h1>{{ trans('forum::general.index') }}</h1>

    @foreach ($categories as $category)
        <livewire:forum::components.category.card :$category :key="$category->id" />
    @endforeach
</div>
