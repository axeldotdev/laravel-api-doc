@props([
    'id' => '',
    'curl' => null,
    'php' => null,
    'javascript' => null,
])

<section x-data="{language: 'curl'}" class="relative w-1/2 px-8 pt-20 pb-12 bg-code text-gray-50 font-mono border-b border-gray-900">
    @if(!is_null($curl) || !is_null($php) || !is_null($javascript))
    <div class="absolute top-4 left-8 flex items-center space-x-4">
        @foreach(config('api-doc.languages') as $language)
        @if(!is_null($$language))
        <button @click="language = '{{ $language }}'" :class="language === '{{ $language }}' ? 'text-gray-50' : 'text-gray-400'" type="button" class="rounded-lg font-medium text-xs bg-gray-600 hover:text-gray-50 transition-colors p-2">
            {{ $language }}
        </button>
        @endif
        @endforeach
    </div>
    @endif

    @if(!is_null($curl) || !is_null($php) || !is_null($javascript))
    <button @click="copyCode(`#id_{{ $id }}_${language}`); $tooltip('Copied!');" †ype="button" class="absolute top-4 right-8 flex justify-center items-center rounded-lg bg-gray-600 text-gray-400 hover:text-gray-50 transition-colors p-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
            <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
        </svg>
    </button>
    @endif

    @if(!is_null($curl))
    <div x-show="language === 'curl'">
        <input id="id_{{ $id }}_curl" class="absolute left-[9999px]" value="{{ $curl }}">
        <x-api-doc::shiki>{{ $curl }}</x-api-doc::shiki>
    </div>
    @endif

    @if(!is_null($php))
    <div x-show="language === 'php'">
        <input id="id_{{ $id }}_php" class="absolute left-[9999px]" value="{{ $php }}">
        <x-api-doc::shiki>{{ $php }}</x-api-doc::shiki>
    </div>
    @endif

    @if(!is_null($javascript))
    <div x-show="language === 'javascript'">
        <input id="id_{{ $id }}_javascript" class="absolute left-[9999px]" value="{{ $javascript }}">
        <x-api-doc::shiki>{{ $javascript }}</x-api-doc::shiki>
    </div>
    @endif
</section>

<script defer>
    document.addEventListener('alpine:init', () => {
        Alpine.magic('tooltip', (el) => (message) => {
            let instance = tippy(el, { content: message, trigger: 'manual' });

            instance.show();

            setTimeout(() => {
                instance.hide();

                setTimeout(() => instance.destroy(), 150);
            }, 2000);
        });
    });

    function copyCode(id) {
        let input = document.querySelector(id);
        input.select();
        document.execCommand('copy');
    }
</script>
