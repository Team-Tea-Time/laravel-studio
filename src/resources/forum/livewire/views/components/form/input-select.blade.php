<div {!! isset($xShow) && !empty($xShow) ? "x-show=\"{$xShow}\"" : "" !!} class="mb-4">
    <label for="{{ $id }}" class="block mb-2 font-medium text-gray-900">{{ $label }}</label>
    <select
        id="{{ $id }}"
        class="w-full p-2.5 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block"
        {{ $attributes }}>
        {{ $slot }}
    </select>

    @include ('forum::components.form.error')
</div>
