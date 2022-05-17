@php
use Illuminate\Support\Str;
@endphp

<section class="w-1/2 px-8 py-12 border-b border-gray-100">
    <div class="prose max-w-none">
        {!! Str::markdown($slot) !!}
    </div>
</section>
