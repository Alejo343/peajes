{{-- TABLA --}}
<div class="relative overflow-x-auto mt-6 rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Fecha
                </th>
                <th scope="col" class="px-6 py-3">
                    Nuevo consecutivo
                </th>
                <th scope="col" class="px-6 py-3">
                    Acción
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $row['date'] }}</td>
                    <td class="px-6 py-4">{{ $row['consecutive'] }}</td>
                    <td class="px-6 py-4">
                        <button
                            class="fill-form text-gray-900 bg-violet-400 hover:bg-violet-500 focus:ring-4
                                    focus:bg-violet-600 rounded-lg text-sm px-4 py-2 focus:outline-none">
                            <x-svg-icon name="icon-copy" class="w-4 h-4 text-black" aria-hidden="true" />
                        </button>
                        <button onclick="openModal()"
                            class="text-gray-900 bg-violet-400 hover:bg-violet-500 focus:ring-4
                                    focus:bg-violet-600 rounded-lg text-sm px-4 py-2 focus:outline-none">
                            <x-svg-icon name="icon-save" class="w-4 h-4 text-black" aria-hidden="true" />
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
