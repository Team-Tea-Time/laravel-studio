<div>
    @include ('forum::components.loading-overlay')
    @include ('forum::components.breadcrumbs')

    <h1>{{ trans('forum::general.index') }}</h1>

    @foreach ($categories as $category)
        <livewire:forum::components.category.card :$category :key="$category->id" />
    @endforeach
</div>
