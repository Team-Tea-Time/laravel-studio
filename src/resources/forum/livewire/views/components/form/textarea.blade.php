<div class="mb-4">
    @if (isset($label))
        <label for="{{ $model }}" class="block mb-2 font-medium text-gray-900">{{ $label }}</label>
    @endif
    <textarea id="{{ $model }}" class="w-full min-h-48 p-2.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block" placeholder="{{ $placeholder ?? '' }}" {{ isset($required) && $required ? 'required' : '' }} wire:model="{{ $model }}"></textarea>

    @include ('forum::components.form.error')
</div>
