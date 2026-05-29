@props(['disabled' => false])

<input
    @disabled($disabled)

    {{ $attributes->merge([
        'class' =>
            'border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-gray-900 text-lg py-3 px-4 bg-white'
    ]) }}
>