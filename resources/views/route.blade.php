<x-api-doc::section>
<x-api-doc::content>
<x-api-doc::heading :method="$route->method" :id="$route->index">
    /{{ $route->short_uri }}
</x-api-doc::heading>

{!! __($route->description) !!}

{{ __('The route only accept the :METHOD HTTP method.', ['method' => "**{$route->method}**"]) }}

@if($route->uri_params->filter(fn ($uri_param) => ! $uri_param->is_request)->isNotEmpty() || $route->query_params->isNotEmpty())
### {{ __('Request') }}

@if($route->uri_params->filter(fn ($uri_param) => ! $uri_param->is_request)->isNotEmpty())
#### {{ __('Params') }}

<x-api-doc::table :headers="[__('Name'), __('Type'), __('Required'), __('Values')]">
    @foreach($route->uri_params->filter(fn ($uri_param) => ! $uri_param->is_request) as $param)
    <x-api-doc::table-row>
        <x-api-doc::table-column class="w-1/4">
            <x-api-doc::tag>{{ $param->name }}</x-api-doc::tag>
        </x-api-doc::table-column>
        <x-api-doc::table-column class="w-1/4">
            <span class="text-emerald-400">{{ $param->uri_type }}</span>
        </x-api-doc::table-column>
        <x-api-doc::table-column class="w-1/4">
            {{ $param->required ? __('Yes') : __('No') }}
        </x-api-doc::table-column>
        <x-api-doc::table-column class="w-1/4">
            {{ $param->values }}
        </x-api-doc::table-column>
    </x-api-doc::table-row>
    @endforeach
</x-api-doc::table>
@endif

@if($route->query_params->isNotEmpty())
#### {{ __('Fields') }}

<x-api-doc::table :headers="[__('Name'), __('Type'), __('Required'), __('Values')]">
    @foreach($route->query_params as $param)
    <x-api-doc::table-row>
            <x-api-doc::table-column class="w-1/4">
                <x-api-doc::tag>{{ $param->name }}</x-api-doc::tag>
            </x-api-doc::table-column>
            <x-api-doc::table-column class="w-1/4">
                <span class="text-emerald-400">{{ $param->type }}</span>
            </x-api-doc::table-column>
            <x-api-doc::table-column class="w-1/4">
                {{ $param->required ? __('Yes') : __('No') }}
            </x-api-doc::table-column>
            <x-api-doc::table-column class="w-1/4">
                {{ $param->values }}
            </x-api-doc::table-column>
        </x-api-doc::table-row>
    @endforeach
</x-api-doc::table>
@endif
@endif

@if($route->response_fields->isNotEmpty())
### {{ __('Response') }}

<x-api-doc::table :headers="[__('Name'), __('Type'), __('Nullable'), __('Values')]">
    @foreach($route->response_fields as $field)
    <x-api-doc::table-row>
            <x-api-doc::table-column class="w-1/4">
                <x-api-doc::tag>{{ $field->name }}</x-api-doc::tag>
            </x-api-doc::table-column>
            <x-api-doc::table-column class="w-1/4">
                <span class="text-emerald-400">{{ $field->type }}</span>
            </x-api-doc::table-column>
            <x-api-doc::table-column class="w-1/4">
                {{ $field->nullable ? __('Yes') : __('No') }}
            </x-api-doc::table-column>
            <x-api-doc::table-column class="w-1/4">
                {{ $field->values }}
            </x-api-doc::table-column>
        </x-api-doc::table-row>
    @endforeach
</x-api-doc::table>
@endif
</x-api-doc::content>

<x-api-doc::code>
    <x-slot name="curl">
        Curl
    </x-slot>

    <x-slot name="php">
        PHP
    </x-slot>

    <x-slot name="javascript">
        Javascript
    </x-slot>
</x-api-doc::code>
</x-api-doc::section>
