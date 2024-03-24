@php
$colorClasses = match ($type) {
    'info', null => 'text-blue-900 bg-blue-400',
    'error' => 'text-red-900 bg-red-400',
    'success' => 'text-green-900 bg-green-400',
    'warning' => 'text-orange-900 bg-orange-400'
}
@endphp

<div class="rounded-md my-4 p-4 text-lg font-medium {{ $colorClasses }}">
    <div>
        {!! $message !!}
    </div>
</div>
