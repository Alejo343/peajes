<div>
    @props(['id', 'name', 'value', 'label'])

    <li>
        <input type="radio" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
            class="hidden peer" required />
        <label for="{{ $id }}"
            class="flex items-center justify-center w-full p-4 text-gray-500 bg-white border 
                border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 
                dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 
                hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
            <div class="text-lg font-semibold">{{ $label }}</div>
        </label>
    </li>
</div>
