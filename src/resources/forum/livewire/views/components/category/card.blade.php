<div class="my-4">
    <div class="bg-white shadow-md rounded-lg p-4 flex items-center justify-items-center">
        <div class="self-stretch">
            <div class="w-3 h-full rounded-full mr-4" style="background-color: {{ $category->color }}"></div>
        </div>
        <div class="flex-1">
            <h2>
                <a href="{{ $category->route }}" style="color: {{ $category->color }}">{{ $category->title }}</a>
            </h2>
            <h3 class="text-slate-600">{{ $category->description }}</h3>
        </div>
        <div class="flex-1 text-center text-base">
            @if ($category->accepts_threads)
                <livewire:forum::components.pill
                    icon="chat-bubbles-mini"
                    :text="trans_choice('forum::threads.thread', 2) . ': ' . $category->thread_count" />
                <livewire:forum::components.pill
                    icon="chat-bubble-text-mini"
                    :text="trans_choice('forum::posts.post', 2) . ': ' . $category->post_count" />
            @endif
        </div>
        <div class="flex-1 text-right">
            @if ($category->accepts_threads)
                @if ($category->newestThread)
                    <div>
                        <a href="{{ $category->newestThread->route }}">{{ $category->newestThread->title }}</a>
                        @include ('forum::components.timestamp', ['carbon' => $category->newestThread->created_at])
                    </div>
                @endif
                @if ($category->latestActiveThread && $category->latestActiveThread->reply_count > 1)
                    <div>
                        <a href="{{ $category->latestActiveThread->lastPost->route }}">Re: {{ $category->latestActiveThread->title }}</a>
                        @include ('forum::components.timestamp', ['carbon' => $category->latestActiveThread->lastPost->created_at])
                    </div>
                @endif
            @endif
        </div>
    </div>

    @if (count($category->children) > 0)
        @foreach ($category->children as $subcategory)
            <div class="flex mt-4">
                <div class="min-w-24 self-center text-center text-slate-300">
                    @include ('forum::components.icons.subcategory', ['size' => '12'])
                </div>
                <div class="grow flex items-center justify-items-center bg-white shadow-md rounded-lg p-4">
                    <div class="flex-1">
                        <h3>
                            <a href="{{ $subcategory->route }}" style="color: {{ $subcategory->color }}">{{ $subcategory->title }}</a>
                        </h3>
                        <h3 class="text-slate-600 text-base">{{ $subcategory->description }}</h3>
                    </div>
                    <div class="flex-1 text-center text-base">
                        @if ($subcategory->accepts_threads)
                            <livewire:forum::components.pill
                                icon="chat-bubbles-mini"
                                :text="trans_choice('forum::threads.thread', 2) . ': ' . $subcategory->thread_count" />
                            <livewire:forum::components.pill
                                icon="chat-bubble-text-mini"
                                :text="trans_choice('forum::posts.post', 2) . ': ' . $subcategory->post_count" />
                        @endif
                    </div>
                    <div class="flex-1 text-right">
                        @if ($subcategory->accepts_threads)
                            @if ($subcategory->newestThread)
                                <div>
                                    <a href="{{ $subcategory->newestThread->route }}">{{ $subcategory->newestThread->title }}</a>
                                    @include ('forum::components.timestamp', ['carbon' => $subcategory->newestThread->created_at])
                                </div>
                            @endif
                            @if ($subcategory->latestActiveThread && $subcategory->latestActiveThread->reply_count > 1)
                                <div>
                                    <a href="{{ $subcategory->latestActiveThread->lastPost->route }}">Re: {{ $subcategory->latestActiveThread->title }}</a>
                                    @include ('forum::components.timestamp', ['carbon' => $subcategory->latestActiveThread->lastPost->created_at])
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
