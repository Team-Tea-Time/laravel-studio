<div>
    @include('forum::components.breadcrumbs')

    <h1>Index</h1>

    @foreach ($categories as $category)
        <livewire:components.category.card :$category :key="$category->id" />
    @endforeach
</div>
