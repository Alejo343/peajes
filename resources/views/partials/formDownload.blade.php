<form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data"
    class="spinner-form self-stretch space-y-3">
    @csrf
    <label for="consecutive" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ubicación</label>
    {{-- <ul class="grid grid-cols-3 w-full gap-5 items-center"> --}}
    <ul class="flex space-x-4 items-center">
        <x-option-toll id="cencar" name="option-toll" value="Cencar" label="Cencar" />
        <x-option-toll id="cerrito" name="option-toll" value="Cerrito" label="Cerrito" />
        <x-option-toll id="rozo" name="option-toll" value="Rozo" label="Rozo" />
        {{-- <div id="div_Betania" class=""> --}}
        {{-- <x-option-toll id="Betania" name="option-toll" value="Betania" label="Betania" /> --}}
        {{-- </div> --}}
    </ul>
    {{-- <div id="additional-option" class="hidden mt-4"> --}}
    <ul class="flex space-x-4 items-center">
        <x-option-toll id="Betania_Tulua_Buga" name="option-toll" value="Betania_Tulua_Buga"
            label="Betania: Tulua - Buga" />
        <x-option-toll id="Betania_Buga_Tulua" name="option-toll" value="Betania_Buga_Tulua"
            label="Betania: Buga - Tulua" />
    </ul>
    {{-- </div> --}}

    <div>
        <label for="consecutive"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Concecutivo</label>
        <input type="number" id="consecutive" name="consecutive"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="000009999" value="" required />
    </div>

    <div class="flex flex-wrap gap-6">
        <div class="flex-1">
            <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <x-svg-icon name="icon-datePicker" class="w-4 h-4 text-gray-500 dark:text-gray-400"
                        aria-hidden="true" />
                </div>
                <input datepicker id="date" type="date" name="date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                        focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="" required>
            </div>
        </div>

        <div class="flex-1">
            <label for="time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora</label>
            <div class="relative">
                <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                    <x-svg-icon name="icon-time" class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" />
                </div>
                <input type="time" id="time" name="time"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="00:00" required />
            </div>
        </div>
    </div>

    <button type="submit" class="w-full py-2 font-semibold rounded bg-violet-400 text-gray-900">Descargar
    </button>
</form>

<script></script>
