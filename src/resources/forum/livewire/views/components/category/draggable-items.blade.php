@foreach ($categories as $category)
    <li data-id="{{ $category->id }}">
        {{ $category->title }}
        @if (count($category->children) > 0)
            <ol data-id="{{ $category->id }}">
                @include ('forum::components.category.draggable-items', ['categories' => $category->children])
            </ol>
        @endif
    </li>
@endforeach
