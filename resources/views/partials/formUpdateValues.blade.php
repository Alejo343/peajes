<form action="{{ route('updateValue') }}" method="POST" class="spinner-form self-center space-y-3">
    @csrf
    @method('PUT')

    @foreach ($values as $index => $value)
        <div>
            <label for="value{{ $index + 1 }}}" class="mb-2 block">{{ $value->name }}:</label>
            <input type="number" id="{{ $value->name }}" name="values[{{ $value->id }}]" value="{{ $value->value }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="000009999" required>
        </div>
    @endforeach

    <div class="pt-6">
        <button type="submit"
            class="submit-button w-full py-2 font-semibold rounded bg-violet-400 text-gray-900 flex items-center justify-center">
            <span class="button-text">Actualizar</span>
            <svg class="spinner hidden ml-2 animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z">
                </path>
            </svg>
        </button>
    </div>

    @include('components.alert')
</form>
