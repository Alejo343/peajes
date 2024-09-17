<div class="relative overflow-x-auto rounded-lg">
    <table id="resultsTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Fecha
                </th>
                <th scope="col" class="px-6 py-3">
                    Nombre
                </th>
                <th scope="col" class="px-6 py-3">
                    consecutivo
                </th>
                <th scope="col" class="px-6 py-3">
                    Eliminar
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consecutives as $consecutive)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $consecutive->date }}</td>
                    <td class="px-6 py-4">{{ $consecutive->name }}</td>
                    <td class="px-6 py-4">{{ $consecutive->code }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('destroyConsecutive', $consecutive->id) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de eliminar este registro?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="fill-form text-gray-900 bg-violet-400 hover:bg-violet-500 focus:ring-4 focus:bg-violet-600 rounded-lg text-sm px-4 py-2 focus:outline-none">
                                <x-svg-icon name="icon-delete" class="w-4 h-4 text-black" aria-hidden="true" />
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            {{-- <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">${item.date}</td>
                <td class="px-6 py-4">${item.consecutive}</td>
                <td class="px-6 py-4">
                    <button class="fill-form text-gray-900 bg-violet-400 hover:bg-violet-500 focus:ring-4 focus:bg-violet-600 rounded-lg text-sm px-4 py-2 focus:outline-none"
                        onclick="fillForm('${item.date}', '${item.consecutive}')">
                        <x-svg-icon name="icon-copy" class="w-4 h-4 text-black" aria-hidden="true" />
                    </button>
                    <button class="text-gray-900 bg-violet-400 hover:bg-violet-500 focus:ring-4 focus:bg-violet-600 rounded-lg text-sm px-4 py-2 focus:outline-none"
                        onclick="openModal('${item.date}', '${item.consecutive}')">
                        <x-svg-icon name="icon-save" class="w-4 h-4 text-black" aria-hidden="true" />
                    </button>
                </td>
            </tr> --}}
        </tbody>
    </table>
</div>
