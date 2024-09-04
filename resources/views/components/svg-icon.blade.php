<svg {{ $attributes }}>
    {!! file_get_contents(resource_path("svg/{$name}.svg")) !!}
</svg>
