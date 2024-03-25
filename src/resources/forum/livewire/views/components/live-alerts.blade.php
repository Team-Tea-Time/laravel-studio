<div x-data="alerts" @alert.window="onReceiveAlert" class="grid place-content-center fixed bottom-0 left-0 right-0">
    <template x-for="alert in list">
        <div class="min-w-80 max-w-96 px-6 py-4 mb-4 text-lg text-center rounded-md transition-opacity" :class="alert.classes">
            <span x-text="alert.message"></span>
        </div>
    </template>
</div>

@script
<script>
const SHOW_DURATION = 4000;
const FADE_DURATION = 300;
const TICK_INTERVAL = 250;

Alpine.data('alerts', () => {
    return {
        list: [],
        styleMap: {
            'success': 'bg-green-400 text-green-900',
            'warning': 'bg-orange-400 text-orange-900',
        },
        init() {
            setInterval(() => {
                let toRemove = [];
                for (var i = 0; i < this.list.length; ++i) {
                    this.list[i].showFor -= TICK_INTERVAL;

                    if (this.list[i].showFor <= FADE_DURATION) {
                        this.list[i].classes += 'opacity-0';
                    }

                    if (this.list[i].showFor <= 0) {
                        toRemove.push(i);
                    }
                }

                toRemove.forEach(i => this.list.splice(i, 1));
            }, TICK_INTERVAL);
        },
        onReceiveAlert(event) {
            this.list.push({
                type: event.detail.type,
                message: event.detail.message,
                showFor: SHOW_DURATION,
                classes: this.styleMap[event.detail.type] += ` ease-in-out duration-${FADE_DURATION} `
            });
        }
    }
})
</script>
@endscript
