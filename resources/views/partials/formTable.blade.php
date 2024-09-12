<form action="{{ route('addConsecutive') }}" method="POST" class="spinner-form self-stretch space-y-3">
    @csrf
    <div class="flex space-x-4">
        <input type="date" id="date" name="date"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Fecha" required />
        <input type="number" id="consecutive" name="consecutive"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
            dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Consecutivo" required />
        <button type="submit"
            class="submit-button text-gray-900 bg-violet-400 hover:bg-violet-500 focus:ring-4
            focus:bg-violet-600 rounded-lg text-sm px-4 py-2 focus:outline-none">
            <span class="button-text">Aceptar</span>
            <svg class="spinner hidden ml-2 animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z">
                </path>
            </svg>
        </button>

    </div>

    @isset($data)
        @include('partials.table', ['data' => $data])
    @endisset

    @include('partials.modal')
</form>
