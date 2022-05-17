<header class="flex justify-center items-center w-full h-16">
    @if (config('api-doc.brand.logo'))
        <div class="">
            {!! file_get_contents(config('api-doc.brand.logo')) !!}
        </div>
    @else
        <div class="font-bold text-gray-800">
            {{ config('app.name') }}
        </div>
    @endif
</header>
