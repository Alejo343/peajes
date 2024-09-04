<!doctype html>
<html class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Peajes App</title>

    <!-- Styles & js -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen bg-gray-800 text-gray-100">
        <div class="p-6 space-y-8">
            <header class="container flex items-center justify-between h-16 px-4 mx-auto rounded bg-gray-900">
                <a rel="noopener noreferrer" href="#" aria-label="Homepage">
                    <x-svg-icon name="icon-home_page" class="w-6 h-6 text-violet-400" />
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
                        <span
                            class="block mb-2 text-xs font-medium tracking-widest uppercase 
                            lg:text-center text-violet-400">Como
                            funciona</span>
                        <h2 class="text-5xl font-bold lg:text-center text-gray-50">Construye el peaje</h2>

                    </section>

                    <section class="grid gap-6 text-center lg:grid-cols-2 xl:grid-cols-5">

                        <div class="w-full p-6 rounded-md xl:col-span-2 bg-gray-900">
                            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data"
                                class="self-stretch space-y-3">
                                @csrf
                                <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Ubicación
                                </h3>
                                <ul class="grid grid-cols-3 w-full gap-6">
                                    <li>
                                        <input type="radio" id="cencar" name="option-toll" value="Cencar"
                                            class="hidden peer" required />
                                        <label for="cencar"
                                            class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border 
                                                border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 
                                                dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 
                                                hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <div class="block">
                                                <div class="w-full text-lg font-semibold">Cencar</div>
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="cerrito" name="option-toll" value="Cerrito"
                                            class="hidden peer">
                                        <label for="cerrito"
                                            class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border 
                                                border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 
                                                dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 
                                                hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <div class="block">
                                                <div class="w-full text-lg font-semibold">Cerrito</div>
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="rozo" name="option-toll" value="Rozo"
                                            class="hidden peer">
                                        <label for="rozo"
                                            class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border 
                                            border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 
                                            dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 
                                            hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <div class="block">
                                                <div class="w-full text-lg font-semibold">Rozo</div>
                                            </div>
                                        </label>
                                    </li>
                                </ul>

                                <div>
                                    <label for="consecutive"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Concecutivo</label>
                                    <input type="number" id="consecutive" name="consecutive"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="000009999" required />
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
                                                placeholder="Select date" required>
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

                                <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                                    role="alert">
                                    <x-svg-icon name="icon-info" class="flex-shrink-0 inline w-4 h-4 me-3"
                                        aria-hidden="true" />
                                    <span class="sr-only">Info</span>
                                    <div>
                                        <span class="font-medium">Creado correctamente</span>
                                    </div>
                                </div>

                                <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                    role="alert">
                                    <x-svg-icon name="icon-info" class="flex-shrink-0 inline w-4 h-4 me-3"
                                        aria-hidden="true" />
                                    <span class="sr-only">Info</span>
                                    <div>
                                        <span class="font-medium">Faltan campos por llenar</span>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @auth
                            <div class="w-full p-4 rounded-md xl:col-span-1 bg-gray-900">
                                <form action="{{ route('updateValue') }}" method="POST" class="self-center space-y-3">
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
                                            class="w-full py-2 font-semibold rounded bg-violet-400 text-gray-900">Actualizar
                                        </button>
                                    </div>
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

                    </section>
                </div>
            </main>

            <footer>
                <div class="container flex justify-between p-6 mx-auto lg:p-8 bg-gray-900">
                    <a rel="noopener noreferrer" href="#" class="font-bold"></a>
                    <div class="flex space-x-2">
                        <a rel="noopener noreferrer" href="#" class="font-bold">DavidG B)</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>
