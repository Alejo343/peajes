<!-- Modal -->
<div id="myModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
    <div class="flex flex-col max-w-md gap-2 p-6 rounded-md shadow-md dark:bg-gray-50 dark:text-gray-800">
        <h2 class="text-xl font-semibold leading-tight tracking-wide">Todavia no </h2>
        {{-- <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data" --}}
        <form action="" method="POST" enctype="multipart/form-data" class="spinner-form self-stretch space-y-3">
            @csrf

            <p class="flex-1 dark:text-gray-600">No esta habilitado todavia mor
            </p>
            <p class="flex-1 dark:text-gray-600">No sea golosa
            </p>


            {{-- <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del
                    consecutivo</label>
                <input type="number" id="name" name="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nombre" required />
            </div> --}}

            <div class="flex flex-col justify-center gap-3 mt-6 sm:flex-row">
                <button type="button" class="px-6 py-2 rounded-sm shadow-sm dark:bg-violet-600 dark:text-gray-50"
                    onclick="closeModal()">Ya lo se</button>
                {{-- <button class="px-6 py-2 rounded-sm shadow-sm dark:bg-violet-600 dark:text-gray-50">Guardar</button> --}}
            </div>
        </form>
    </div>
</div>
