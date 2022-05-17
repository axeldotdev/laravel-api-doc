@php
use Axeldotdev\LaravelApiDoc\Features;
use Axeldotdev\LaravelApiDoc\Facades\LaravelApiDoc;
@endphp

<x-api-doc::layout>
    <x-api-doc::section id="get-started" class="flex-col">
        {!! LaravelApiDoc::getStarted() !!}
    </x-api-doc::section>

    @if(Features::enabled(Features::authentication()))
    <x-api-doc::section id="authentication" class="flex-col">
        {!! LaravelApiDoc::authentication() !!}
    </x-api-doc::section>
    @endif

    <x-api-doc::section id="errors" class="flex-col">
        {!! LaravelApiDoc::errors() !!}
    </x-api-doc::section>

    @if(count(config('api-doc.groups')) < 1)
    @foreach(LaravelApiDoc::routes() as $index => $route)
    <x-api-doc::section id="{{ $index }}" class="flex-col">
        {!! $route->view !!}
    </x-api-doc::section>
    @endforeach
    @else
    @foreach(LaravelApiDoc::groups() as $routes)
    @foreach($routes as $index => $route)
    <x-api-doc::section x-show="version === '{{ $route->version }}'" id="{{ $index }}" class="flex-col">
        {!! $route->view !!}
    </x-api-doc::section>
    @endforeach
    @endforeach
    @endif
</x-api-doc::layout>
