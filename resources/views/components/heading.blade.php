@php
use Illuminate\Support\Str;
use Axeldotdev\LaravelApiDoc\Route;
@endphp

@props([
    'method' => null,
    'id' => null,
])

<h2 class="flex items-start">
@if(! is_null($id))
<a href="#{{ $id }}" class="text-gray-300 no-underline mr-2">#</a>
@endif
@if(! is_null($method))
<span class="
    inline-flex
    justify-center
    items-center
    p-1
    rounded
    @if ($method === Route::METHOD_GET)
    text-emerald-50
    bg-emerald-400
    @elseif ($method === Route::METHOD_POST)
    text-blue-50
    bg-blue-400
    @elseif ($method === Route::METHOD_PUT)
    text-violet-50
    bg-violet-400
    @elseif ($method === Route::METHOD_DELETE)
    text-red-50
    bg-red-400
    @endif
    mr-2
    text-sm
    font-medium">
    {{ $method }}
</span>
@endif
@if(Str::contains($slot, '/'))
<span class="flex items-center flex-wrap">
@foreach(array_filter(explode('/', $slot)) as $part)
<span>/</span>
@if (Str::startsWith($part, '{') && Str::endsWith($part, '}'))
<span class="text-gray-400">{{ $part }}</span>
@else
<span>{{ $part }}</span>
@endif
@endforeach
</span>
@else
<span>
{{ $slot }}
</span>
@endif
</h2>
