<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            @if (isset($thread))
                {{ $thread->title }} —
            @endif
            @if (isset($category))
                {{ $category->title }} —
            @endif
            {{ trans('forum::general.home_title') }}
        </title>

        @vite(['resources/forum/livewire/css/forum.css', 'resources/forum/livewire/js/forum.js'])
    </head>
    <body class="forum bg-slate-200">
        <div class="bg-white shadow-md border-b border-slate-100">
            <div class="container mx-auto p-4 flex flex-row">
                <div class="text-xl mr-6 font-bold">
                    {{ config('app.name') }}
                </div>
                <div class="text-lg self-center">
                    <a href="/" class="mx-2">Home</a>
                    <a href="/forum" class="mx-2">Forum</a>
                    <a href="/forum/manage" class="mx-2">Manage</a>
                </div>
            </div>
        </div>

        <div class="container mx-auto p-4">
            {{ $slot }}
        </div>

        <livewire:forum::components.alerts />

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('time', {
                    now: new Date(),
                    init() {
                        setInterval(() => {
                            this.now = new Date();
                        }, 1000);
                    }
                })
            });
        </script>
    </body>
</html>
