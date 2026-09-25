{{-- Filament's edit-record page with the language switch (HasContentLocale) above the form. --}}
<x-filament::page
    :widget-data="['record' => $record]"
    :class="
        \Illuminate\Support\Arr::toCssClasses([
            'filament-resources-edit-record-page',
            'filament-resources-' . str_replace('/', '-', $this->getResource()::getSlug()),
            'filament-resources-record-' . $record->getKey(),
        ])
    "
>
    <div data-active-locale="{{ $this->activeLocale }}">
        @include('filament.content-locale.switcher')

        <x-filament::form wire:submit.prevent="save">
            {{ $this->form }}

            <x-filament::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament::form>
    </div>
</x-filament::page>
