@php
use Axeldotdev\LaravelApiDoc\Route;
use Axeldotdev\LaravelApiDoc\Features;
use Axeldotdev\LaravelApiDoc\Facades\LaravelApiDoc;

$versions = config('api-doc.versions');

@endphp

<nav x-data="{version: {{ count($versions) > 1 ? '\'' . reset($versions) . '\'' : 'null' }}}" class="flex flex-col shrink-0 grow-0 w-72 h-full bg-white shadow overflow-y-auto">
    <x-api-doc::header></x-api-doc::header>

    @if(count($versions) > 1)
    <div class="px-6 pt-8">
        <select x-model="version" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            @foreach($versions as $version => $path)
            <option value="{{ $path }}">
                {{ $version }}
            </option>
            @endforeach
        </select>
    </div>
    @endif

    <div class="flex flex-col px-6 py-8">
        <a href="#get-started" class="truncate font-medium text-gray-500 hover:text-gray-900 transition-colors">
            {{ __('Get Started') }}
        </a>

        @if(Features::enabled(Features::authentication()))
        <a href="#authentication" class="mt-4 truncate font-medium text-gray-500 hover:text-gray-900 transition-colors">
            {{ __('Authentication') }}
        </a>
        @endif

        <a href="#errors" class="mt-4 truncate font-medium text-gray-500 hover:text-gray-900 transition-colors">
            {{ __('Errors') }}
        </a>

        @if(count(config('api-doc.groups')) < 1)
        @foreach(LaravelApiDoc::routes() as $index => $route)
        <a href="#{{ $index }}" class="mt-4 flex items-center">
            <span class="
                flex
                justify-center
                items-center
                p-1
                rounded
                @if ($route->method === Route::METHOD_GET)
                text-emerald-50
                bg-emerald-400
                @elseif ($route->method === Route::METHOD_POST)
                text-blue-50
                bg-blue-400
                @elseif ($route->method === Route::METHOD_PUT)
                text-violet-50
                bg-violet-400
                @elseif ($route->method === Route::METHOD_DELETE)
                text-red-50
                bg-red-400
                @endif
                mr-2
                text-xs
                font-medium">
                {{ $route->method }}
            </span>

            <span class="truncate font-medium text-gray-500 hover:text-gray-900 transition-colors">
                {{ $route->short_uri }}
            </span>
        </a>
        @endforeach
        @else
        @foreach(LaravelApiDoc::groups() as $group => $routes)
        <span class="mt-8 truncate uppercase text-xs font-bold text-gray-400"
            x-show="@foreach($routes as $route) @if($loop->index > 0) && @endif version === '{{ $route->version }}' @endforeach">
            {{ __($group) }}
        </span>
        @foreach($routes as $index => $route)
        <a href="#{{ $index }}" class="mt-4 flex items-center" x-show="version === '{{ $route->version }}'">
            <span class="
                flex
                justify-center
                items-center
                p-1
                rounded
                @if ($route->method === Route::METHOD_GET)
                text-emerald-50
                bg-emerald-400
                @elseif ($route->method === Route::METHOD_POST)
                text-blue-50
                bg-blue-400
                @elseif ($route->method === Route::METHOD_PUT)
                text-violet-50
                bg-violet-400
                @elseif ($route->method === Route::METHOD_DELETE)
                text-red-50
                bg-red-400
                @endif
                mr-2
                text-xs
                font-medium">
                {{ $route->method }}
            </span>

            <span class="truncate font-medium text-gray-500 hover:text-gray-900 transition-colors">
                {{ $route->short_uri }}
            </span>
        </a>
        @endforeach
        @endforeach
        @endif
    </div>
</nav>
