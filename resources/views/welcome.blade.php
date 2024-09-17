<!doctype html>
<html class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>Peajes App</title>

    <!-- Styles & js -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen bg-gray-800 text-gray-100">
        <div class="p-6 space-y-8">
            <header class="container flex items-center justify-between h-16 px-4 mx-auto rounded bg-gray-900">
                <a rel="noopener noreferrer" aria-label="Homepage">
                    <img src="{{ asset('icon.png') }}" alt="Icono" width="24" height="24">
                </a>

                <div class="items-center space-x-8 lg:flex">
                    @auth
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                        <a href="#" class="px-4 py-2 rounded-md bg-violet-400 text-gray-900"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-md bg-violet-400 text-gray-900">Login</a>
                    @endauth
                </div>
            </header>

            <main>
                <div class="container mx-auto space-y-16">
                    {{-- titulo --}}
                    <section>
                        <h2 class="text-5xl font-bold lg:text-center text-gray-50">Construye el peaje</h2>
                    </section>

                    <section class="grid gap-6 text-center lg:grid-cols-2 xl:grid-cols-5">

                        <div class="w-full p-6 rounded-md xl:col-span-2 bg-gray-900">
                            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data"
                                class="spinner-form self-stretch space-y-3">
                                @csrf
                                <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Ubicación
                                </h3>
                                <ul class="grid grid-cols-3 w-full gap-5 items-center">
                                    <x-option-toll id="cencar" name="option-toll" value="Cencar" label="Cencar" />
                                    <x-option-toll id="cerrito" name="option-toll" value="Cerrito" label="Cerrito" />
                                    <x-option-toll id="rozo" name="option-toll" value="Rozo" label="Rozo" />
                                    <x-option-toll id="Betania_T-B" name="option-toll" value="Betania_T-B"
                                        label="Betania T-B" />
                                </ul>

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
                                        <label for="date"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                <x-svg-icon name="icon-datePicker"
                                                    class="w-4 h-4 text-gray-500 dark:text-gray-400"
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
                                        <label for="time"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                                <x-svg-icon name="icon-time"
                                                    class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                    aria-hidden="true" />
                                            </div>
                                            <input type="time" id="time" name="time"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                value="00:00" required />
                                        </div>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full py-2 font-semibold rounded bg-violet-400 text-gray-900">Descargar
                                </button>
                            </form>
                        </div>

                        @auth
                            {{-- --FORMULARIO PARA CAMBAR EL VALOR DEL PEAJE-- --}}
                            <div class="w-full p-4 rounded-md xl:col-span-1 bg-gray-900">
                                <form action="{{ route('updateValue') }}" method="POST"
                                    class="spinner-form self-center space-y-3">
                                    @csrf
                                    @method('PUT')

                                    @foreach ($values as $index => $value)
                                        <div>
                                            <label for="value{{ $index + 1 }}}"
                                                class="mb-2 block">{{ $value->name }}:</label>
                                            <input type="number" id="{{ $value->name }}"
                                                name="values[{{ $value->id }}]" value="{{ $value->value }}"
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
                                            <svg class="spinner hidden ml-2 animate-spin h-5 w-5 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>

                                    @include('components.alert')
                                </form>
                            </div>

                            <div class="w-full p-4 rounded-md xl:col-span-2 bg-gray-900">
                                @include('partials.formTable')
                            </div>
                        @else
                            <div class="w-full p-4 rounded-md xl:col-span-3 bg-gray-900 ">
                                @include('partials.formTable')
                            </div>
                        @endauth

                        @include('partials.modal')

                    </section>
                </div>
            </main>

            <footer>
                <div class="container flex justify-between p-6 mx-auto lg:p-8 bg-gray-900">
                    <a rel="noopener noreferrer" href="#" class="font-bold"></a>
                    <div class="flex space-x-2">
                        <a rel="noopener noreferrer" href="#" class="font-bold">DavidG</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

<script>
    // Spinner de botones
    document.querySelectorAll('.spinner-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            const button = form.querySelector('.submit-button');
            const buttonText = button.querySelector('.button-text');
            const spinner = button.querySelector('.spinner');

            // Cambiar texto a spinner
            buttonText.classList.add('hidden');
            spinner.classList.remove('hidden');

            // Deshabilitar el botón para evitar múltiples envíos
            button.disabled = true;
        });
    })

    //Manejo del envio del formulario de sumar
    document.getElementById('dataForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const date = new Date(document.getElementById('dateAdd').value);
        const consecutive = parseInt(document.getElementById('consecutiveAdd').value, 10);

        if (isNaN(consecutive) || !date) {
            alert("Por favor, ingrese un consecutivo válido y una fecha.");
            return;
        }

        const data = [];
        const length = consecutive.toString().length;

        for (let i = 0; i < 15; i++) {
            const newDate = new Date(date);
            newDate.setDate(date.getDate() + i);
            const newConsecutive = (consecutive + 845 * i).toString().padStart(length, '0');
            data.push({
                date: newDate.toISOString().split('T')[0],
                consecutive: newConsecutive
            });
        }
        console.log(data);

        const tbody = document.getElementById('resultsTable').querySelector('tbody');
        tbody.innerHTML = data.map(item => `
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
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
            </tr>
        `).join('');
    });

    function fillForm(date, consecutive) {
        document.getElementById('date').value = date;
        document.getElementById('consecutive').value = consecutive;
    }

    //manejo de modal
    function openModal(date, consecutive) {
        document.getElementById('myModal').classList.remove('hidden');
        document.getElementById('id-save-consecutive').value = consecutive;
        document.getElementById('id-save-date').value = date;
    }

    function closeModal() {
        document.getElementById('myModal').classList.add('hidden');
    }
</script>

</html>
