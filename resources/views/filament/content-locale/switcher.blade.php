{{-- Language switch for a translatable form (HasContentLocale), styled like the one on the website (see content-locale-styles). --}}
@php
    $locales = $this->getContentLocales();
    $active = $this->activeLocale;
@endphp

<div class="pkg-locale-bar">
    <div class="pkg-locale-bar__row">
        <span class="pkg-locale-bar__label">Language</span>

        <div class="pkg-locale-switch" role="tablist" aria-label="Language to edit">
            @foreach ($locales as $code => $locale)
                <button
                    type="button"
                    role="tab"
                    aria-selected="{{ $code === $active ? 'true' : 'false' }}"
                    wire:click="setActiveLocale('{{ $code }}')"
                    wire:loading.attr="disabled"
                    title="{{ $locale['name'] }}{{ $locale['detail'] ? ' — '.$locale['detail'] : '' }}"
                    @class(['pkg-locale-switch__option', 'is-active' => $code === $active])
                >
                    {{ $locale['native'] }}
                    @if ($locale['pending'] !== null)
                        <span @class(['pkg-locale-switch__badge', 'is-pending' => $locale['pending'] > 0])>
                            {{ $locale['pending'] > 0 ? $locale['pending'] : '✓' }}
                        </span>
                    @endif
                </button>
            @endforeach
        </div>

        <svg wire:loading wire:target="setActiveLocale" class="pkg-locale-bar__spinner" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3" stroke-opacity=".25"/>
            <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
        </svg>
    </div>

    @if ($active !== \App\Models\Contracts\TranslatableContent::SOURCE_LOCALE)
        <p class="pkg-locale-bar__note">
            You are editing the <strong>{{ $locales[$active]['name'] }}</strong> text. The English it translates is shown
            under each field, and empty fields show English on the website.
            Photos and settings are shared by all languages; switch to English to change them.
        </p>
    @endif
</div>
