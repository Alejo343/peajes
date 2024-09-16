<!-- Modal -->
<div id="myModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
    <div class="flex flex-col max-w-md gap-2 p-6 rounded-md shadow-md text-gray-100 bg-gray-900">
        <h2 class="text-xl font-semibold leading-tight tracking-wide">Elije el nombre</h2>
        <form action="{{ route('saveConsecutive') }}" method="POST" enctype="multipart/form-data"
            class="spinner-form self-stretch space-y-3">
            @csrf

            <p class="flex-1 text-gray-400">Con que nombre deseas guardar el consecutivo?
            </p>

            <div>
                <input type="text" id="name" name="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nombre" required />
            </div>

            <div class="flex flex-col justify-center gap-3 mt-6 sm:flex-row">
                <button type="button" class="px-6 py-2 rounded-sm shadow-s" onclick="closeModal()">Cancelar</button>
                <button type="submit"
                    class="px-6 py-2 rounded-sm shadow-sm bg-violet-400 text-gray-900">Guardar</button>
            </div>
        </form>
    </div>
</div>
