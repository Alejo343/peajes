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
                    <section>
                        <h2 class="text-5xl font-bold lg:text-center text-gray-50">Construye el peaje</h2>
                    </section>

                    <section class="grid gap-6 text-center lg:grid-cols-2 xl:grid-cols-5">
                        <div class="w-full p-6 rounded-md xl:col-span-2 bg-gray-900">
                            <h4 class="text-2xl font-bold dark:text-white mb-1">Generar peaje</h3>
                                @include('partials.formDownload')
                        </div>

                        @auth
                            <div class="w-full p-4 rounded-md xl:col-span-1 bg-gray-900">
                                @include('partials.formUpdateValues')
                            </div>

                            <div class="w-full p-4 rounded-md xl:col-span-2 bg-gray-900">
                                @include('partials.formGenConsecutives')
                            </div>
                        @else
                            <div class="w-full p-4 rounded-md xl:col-span-3 bg-gray-900 ">
                                <h4 class="text-2xl font-bold dark:text-white mb-1">Generar consecutivos</h4>
                                @include('partials.formGenConsecutives')
                            </div>
                        @endauth

                        @include('partials.modal')

                        <div class="w-full p-6 rounded-md xl:col-span-2 bg-gray-900">
                            <h4 class="text-2xl font-bold dark:text-white mb-1">Distancias entre peajes</h4>
                        </div>

                        <div class="w-full p-4 rounded-md xl:col-span-3 bg-gray-900 ">
                            <h4 class="text-2xl font-bold dark:text-white mb-1">Consecutivos guardados</h4>
                            @include('components.alert')

                            @include('partials.savesConsecutivesTable')
                        </div>
                    </section>

                    <sectioon>
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
</script>

</html>
