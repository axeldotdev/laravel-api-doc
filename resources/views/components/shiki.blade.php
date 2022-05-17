@php
use Spatie\ShikiPhp\Shiki;
@endphp

@props(['language' => 'php'])

{!! Shiki::highlight($slot, $language, 'nord') !!}
