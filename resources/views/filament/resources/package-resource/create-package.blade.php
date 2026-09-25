{{-- Filament's create-record page with the language switch above the form. --}}
<x-filament::page
    :class="
        \Illuminate\Support\Arr::toCssClasses([
            'filament-resources-create-record-page',
            'filament-resources-' . str_replace('/', '-', $this->getResource()::getSlug()),
        ])
    "
>
    <div data-active-locale="{{ $this->activeLocale }}">
        @include('filament.resources.package-resource.locale-switcher')

        <x-filament::form wire:submit.prevent="create">
            {{ $this->form }}

            <x-filament::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament::form>
    </div>
</x-filament::page>
