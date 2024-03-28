@foreach ($categories as $category)
    @if (!isset($hide) || (isset($hide) && $category->id != $hide->id))
        <option value="{{ $category->id }}">
            @for ($i = 0; $i < $category->depth; ++$i)- @endfor
            {{ $category->title }}
        </option>
    @endif

    @if ($category->children)
        @include ('forum::components.category.options', ['categories' => $category->children])
    @endif
@endforeach
