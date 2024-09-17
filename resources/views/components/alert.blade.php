@if (session('message'))
    @php
        $message = session('message');
        $alertType = $message['type'] ?? 'info'; // Predeterminado a 'info' si no se pasa tipo
    @endphp
    <div class="flex items-center p-3.5 mt-3 text-sm bg-gray-800 
            text-{{ $alertType == 'success' ? 'green' : ($alertType == 'error' ? 'red' : '') }}-400 
            border-{{ $alertType == 'success' ? 'green' : ($alertType == 'error' ? 'red' : '') }}-800 rounded-xl"
        role="alert">
        <x-svg-icon name="icon-info" class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" />
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium"> {{ $message['text'] }}</span>
        </div>
    </div>
@endif
