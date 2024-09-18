<div class="flex-1">
    @props(['id', 'name', 'value', 'label'])
    <li>
        <input type="radio" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
            class="hidden peer" required />
        <label for="{{ $id }}"
            class="w-full flex items-center justify-center p-4 border rounded-lg cursor-pointer
                text-gray-50 dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500
                peer-checked:border-blue-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
            <div class="text-lg font-semibold">{{ $label }}</div>
        </label>
    </li>
</div>
