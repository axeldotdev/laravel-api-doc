@props([
    'curl' => null,
    'php' => null,
    'javascript' => null,
])

<section class="relative w-1/2 px-8 pt-20 pb-12 bg-code text-gray-50 font-mono border-b border-gray-900">
    <div x-data="{language: 'curl'}" class="absolute top-4 left-8 flex items-center space-x-4">
        @foreach(config('api-doc.languages') as $language)
        <button @click="selectLanguage('{{ $language }}')" type="button" class="rounded-lg font-medium text-xs bg-gray-600 text-gray-400 hover:text-gray-50 transition-colors p-2">
            {{ $language }}
        </button>
        @endforeach
    </div>

    <button @click="copyCode()" †ype="button" class="absolute top-4 right-8 flex justify-center items-center rounded-lg bg-gray-600 text-gray-400 hover:text-gray-50 transition-colors p-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
            <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
        </svg>
    </button>

    @if(!is_null($curl))
    <x-api-doc::shiki>
        {{ $curl }}
    </x-api-doc::shiki>
    @endif

    @if(!is_null($php))
    <x-api-doc::shiki>
        {{ $php }}
    </x-api-doc::shiki>
    @endif

    @if(!is_null($javascript))
    <x-api-doc::shiki>
        {{ $javascript }}
    </x-api-doc::shiki>
    @endif
</section>

<script defer>
    function copyCode() {
        alert('code copied!');
    }
</script>
