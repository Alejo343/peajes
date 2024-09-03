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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 32 32"
                        class="w-6 h-6 text-violet-400">
                        <path
                            d="M27.912 7.289l-10.324-5.961c-0.455-0.268-1.002-0.425-1.588-0.425s-1.133 0.158-1.604 0.433l0.015-0.008-10.324 5.961c-0.955 0.561-1.586 1.582-1.588 2.75v11.922c0.002 1.168 0.635 2.189 1.574 2.742l0.016 0.008 10.322 5.961c0.455 0.267 1.004 0.425 1.59 0.425 0.584 0 1.131-0.158 1.602-0.433l-0.014 0.008 10.322-5.961c0.955-0.561 1.586-1.582 1.588-2.75v-11.922c-0.002-1.168-0.633-2.189-1.573-2.742zM27.383 21.961c0 0.389-0.211 0.73-0.526 0.914l-0.004 0.002-10.324 5.961c-0.152 0.088-0.334 0.142-0.53 0.142s-0.377-0.053-0.535-0.145l0.005 0.002-10.324-5.961c-0.319-0.186-0.529-0.527-0.529-0.916v-11.922c0-0.389 0.211-0.73 0.526-0.914l0.004-0.002 10.324-5.961c0.152-0.090 0.334-0.143 0.53-0.143s0.377 0.053 0.535 0.144l-0.006-0.002 10.324 5.961c0.319 0.185 0.529 0.527 0.529 0.916z">
                        </path>
                        <path
                            d="M22.094 19.451h-0.758c-0.188 0-0.363 0.049-0.515 0.135l0.006-0.004-4.574 2.512-5.282-3.049v-6.082l5.282-3.051 4.576 2.504c0.146 0.082 0.323 0.131 0.508 0.131h0.758c0.293 0 0.529-0.239 0.529-0.531v-0.716c0-0.2-0.11-0.373-0.271-0.463l-0.004-0.002-5.078-2.777c-0.293-0.164-0.645-0.26-1.015-0.26-0.39 0-0.756 0.106-1.070 0.289l0.010-0.006-5.281 3.049c-0.636 0.375-1.056 1.055-1.059 1.834v6.082c0 0.779 0.422 1.461 1.049 1.828l0.009 0.006 5.281 3.049c0.305 0.178 0.67 0.284 1.061 0.284 0.373 0 0.723-0.098 1.027-0.265l-0.012 0.006 5.080-2.787c0.166-0.091 0.276-0.265 0.276-0.465v-0.716c0-0.293-0.238-0.529-0.529-0.529z">
                        </path>
                    </svg>
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
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                </svg>
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
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                        clip-rule="evenodd" />
                                                </svg>
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
