<div class="my-4">
    <div class="bg-white shadow-md rounded-lg p-4 flex items-center justify-items-center">
        <div>
            <a href="{{ $thread->route }}" class="block text-xl" style="color: {{ $thread->category->color }}">
                {{ $thread->title }}
            </a>
            {{ $thread->author->name }}
            <span class="text-slate-500">
                @include ('forum::components.timestamp', ['carbon' => $thread->created_at])
            </span>
        </div>
    </div>
</div>
