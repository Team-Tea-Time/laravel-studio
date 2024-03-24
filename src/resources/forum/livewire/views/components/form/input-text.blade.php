<div class="mb-4">
    <label for="{{ $model }}" class="block mb-2 font-medium text-gray-900">{{ $label }}</label>
    <input type="{{ $type ?? 'text' }}" id="{{ $model }}" class="w-full p-2.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block" placeholder="{{ $placeholder ?? '' }}" {{ isset($required) && $required ? 'required' : '' }} wire:model="{{ $model }}" />

    @include ('forum::components.form.error')
</div>