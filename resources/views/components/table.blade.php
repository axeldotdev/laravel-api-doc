@props(['headers' => []])

<table {{ $attributes }}>
@if(count($headers))
<thead>
<tr>
@foreach($headers as $header)
<th class="p-1">
{{ $header }}
</th>
@endforeach
</tr>
</thead>
@endif
<tbody>
{!! $slot !!}
</tbody>
</table>
