<div id="success-message"
    class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
    role="alert">
    <x-svg-icon name="icon-info" class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" />
    <span class="sr-only">Info</span>
    <div>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
</div>
