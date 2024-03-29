<div class="my-4">
    <div class="bg-white shadow-md rounded-lg p-4 flex flex-col sm:flex-row sm:items-center sm:content-center">
        <div class="hidden sm:block self-stretch">
            <div class="w-3 h-full rounded-full mr-4" style="background-color: {{ $category->color }}"></div>
        </div>
        <div class="grow text-center sm:text-left">
            <h2>
                <a href="{{ $category->route }}" style="color: {{ $category->color }}">{{ $category->title }}</a>
            </h2>
            <h3 class="text-slate-600">{{ $category->description }}</h3>
        </div>
        <div class="text-center text-base mt-2 sm:mt-0">
            @if ($category->accepts_threads)
                <livewire:forum::components.pill
                    icon="chat-bubbles-mini"
                    :text="trans_choice('forum::threads.thread', 2) . ': ' . $category->thread_count" />
                <livewire:forum::components.pill
                    icon="chat-bubble-text-mini"
                    :text="trans_choice('forum::posts.post', 2) . ': ' . $category->post_count" />
            @endif
        </div>
        <div class="min-w-30 sm:min-w-48 lg:min-w-96 xl:w-full xl:max-w-lg text-center sm:text-right mt-2 sm:mt-0">
            @if ($category->accepts_threads)
                @if ($category->newestThread)
                    <div>
                        @include ("forum::components.icons.chat-bubbles-mini")
                        <a href="{{ $category->newestThread->route }}" class="inline-block max-w-36 md:max-w-48 lg:max-w-64 truncate align-middle">
                            {{ $category->newestThread->title }}
                        </a>
                        <span class="inline-block align-middle">
                            <livewire:forum::components.timestamp :carbon="$category->newestThread->created_at" />
                        </span>
                    </div>
                @endif
                @if ($category->latestActiveThread && $category->latestActiveThread->reply_count > 1)
                    <div>
                        @include ("forum::components.icons.chat-bubble-text-mini")
                        <a href="{{ $category->latestActiveThread->lastPost->route }}" class="inline-block max-w-36 md:max-w-48 lg:max-w-64 truncate align-middle">
                            Re: {{ $category->latestActiveThread->title }}
                        </a>
                        <span class="inline-block align-middle">
                            <livewire:forum::components.timestamp :carbon="$category->latestActiveThread->lastPost->created_at" />
                        </span>
                    </div>
                @endif
            @endif
        </div>
    </div>

    @if (count($category->children) > 0)
        @foreach ($category->children as $subcategory)
            <div class="flex mt-4">
                <div class="min-w-12 sm:min-w-24 self-center text-center text-slate-300">
                    @include ('forum::components.icons.subcategory', ['size' => '12'])
                </div>
                <div class="grow flex flex-col sm:flex-row sm:items-center sm:content-center items-center justify-items-center bg-white shadow-md rounded-lg p-4">
                    <div class="grow text-center sm:text-left">
                        <h3>
                            <a href="{{ $subcategory->route }}" style="color: {{ $subcategory->color }}">{{ $subcategory->title }}</a>
                        </h3>
                        <h3 class="text-slate-600 text-base">{{ $subcategory->description }}</h3>
                    </div>
                    <div class="text-center text-base mt-2 sm:mt-0">
                        @if ($subcategory->accepts_threads)
                            <livewire:forum::components.pill
                                icon="chat-bubbles-mini"
                                :text="trans_choice('forum::threads.thread', 2) . ': ' . $subcategory->thread_count" />
                            <livewire:forum::components.pill
                                icon="chat-bubble-text-mini"
                                :text="trans_choice('forum::posts.post', 2) . ': ' . $subcategory->post_count" />
                        @endif
                    </div>
                    <div class="min-w-30 sm:min-w-48 lg:min-w-96 xl:w-full xl:max-w-lg text-center sm:text-right mt-2 sm:mt-0">
                        @if ($subcategory->accepts_threads)
                            @if ($subcategory->newestThread)
                                <div>
                                    @include ("forum::components.icons.chat-bubbles-mini")
                                    <a href="{{ $subcategory->newestThread->route }}" class="inline-block max-w-36 md:max-w-48 lg:max-w-64 truncate align-middle">
                                        {{ $subcategory->newestThread->title }}
                                    </a>
                                    <span class="inline-block align-middle">
                                        <livewire:forum::components.timestamp :carbon="$subcategory->newestThread->created_at" />
                                    </span>
                                </div>
                            @endif
                            @if ($subcategory->latestActiveThread && $subcategory->latestActiveThread->reply_count > 1)
                                <div>
                                    @include ("forum::components.icons.chat-bubble-text-mini")
                                    <a href="{{ $subcategory->latestActiveThread->lastPost->route }}" class="inline-block max-w-36 md:max-w-48 lg:max-w-64 truncate align-middle">
                                        Re: {{ $subcategory->latestActiveThread->title }}
                                    </a>
                                    <span class="inline-block align-middle">
                                        <livewire:forum::components.timestamp :carbon="$subcategory->latestActiveThread->lastPost->created_at" />
                                    </span>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
