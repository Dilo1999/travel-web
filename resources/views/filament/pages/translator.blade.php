<x-filament::page>
    {{-- Started by the "Translate website" button; runs one batch per request until step() returns false. --}}
    <div
        x-data="{ async run() { while (await $wire.step()) {} } }"
        x-on:translator-run.window="run()"
    >
        @if ($running)
            <x-filament::card>
                <p class="font-medium">Translating… {{ $done }} of {{ $total }} strings</p>

                <progress class="mt-3 w-full" max="{{ max($total, 1) }}" value="{{ $done }}"></progress>

                <p class="mt-3 text-sm text-gray-500">
                    Keep this page open until it finishes. If it is closed, everything translated so far stays saved.
                </p>
            </x-filament::card>
        @else
            <x-filament::card>
                <p class="text-sm text-gray-500">
                    The website's English text is translated with Claude and saved in the database. Visitors are served
                    those saved translations, so the API is only used when you click "Translate website".
                    Packages are translated separately, with the "Translate with Claude" button on each package.
                </p>

                <div class="mt-4 space-y-2">
                    @foreach ($status as $language)
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium">{{ $language['name'] }}</span>
                            <span class="text-gray-500">
                                {{ $language['translated'] }} of {{ $language['total'] }} strings translated
                                @if ($language['updated'])
                                    · last updated {{ $language['updated']->diffForHumans() }}
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            </x-filament::card>
        @endif
    </div>
</x-filament::page>
