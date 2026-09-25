<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Tour packages. The form holds every language at once; the language switch on the create/edit
 * pages (HasContentLocale) only changes which language is shown, via the data-content-locale /
 * data-locale-shared markers styled in resources/views/filament/content-locale-styles.blade.php.
 * Fields are hidden with CSS rather than ->hidden() because Filament does not save hidden fields.
 */
class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'slug';

    public static function getRecordTitle(?Model $record): ?string
    {
        return $record instanceof Package ? ($record->title[Package::SOURCE_LOCALE] ?? $record->slug) : static::getModelLabel();
    }

    /**
     * @return array<string, array{name: string, native: string}> locale => names, English first
     */
    public static function locales(): array
    {
        return LaravelLocalization::getSupportedLocales();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Group::make([
                        Section::make('Package')
                            ->schema([
                                ...static::localized('title', fn (string $path) => TextInput::make($path)
                                    ->label('Title')
                                    ->maxLength(120)
                                    ->lazy()
                                    ->afterStateUpdated(function (?string $state, callable $set, $livewire) use ($path) {
                                        if ($livewire instanceof CreateRecord && str_ends_with($path, '.en')) {
                                            $set('slug', Str::slug((string) $state));
                                        }
                                    }), required: true),
                                ...static::localized('location', fn (string $path) => TextInput::make($path)
                                    ->label('Places')
                                    ->maxLength(120), required: true, help: 'Shown on the photo, e.g. "Yala · Udawalawe". The first place also picks the placeholder photo.'),
                                ...static::localized('blurb', fn (string $path) => Textarea::make($path)
                                    ->label('Summary')
                                    ->rows(3)
                                    ->maxLength(400), required: true, help: 'Shown on the package card and used as the page description for search engines.'),
                                ...static::localized('season', fn (string $path) => Textarea::make($path)
                                    ->label('Best season')
                                    ->rows(2)
                                    ->maxLength(300), required: true, help: 'Shown in the enquiry box beside the itinerary.'),
                            ]),

                        Section::make('Day by day')
                            ->description('The itinerary on the package page. Days can be added, removed and dragged into order in English.')
                            ->schema([
                                Repeater::make('itinerary')
                                    ->label('Days')
                                    ->schema([
                                        ...static::localized('title', fn (string $path) => TextInput::make($path)->label('Day title')->maxLength(120), required: true),
                                        ...static::localized('body', fn (string $path) => Textarea::make($path)->label('Description')->rows(3)->maxLength(1500), required: true),
                                        Grid::make(2)->schema([
                                            ...static::localized('stay', fn (string $path) => TextInput::make($path)->label('Overnight / location tag')->maxLength(80)),
                                            ...static::localized('meals', fn (string $path) => TextInput::make($path)->label('Meals tag')->maxLength(40), help: 'B = breakfast, L = lunch, D = dinner, e.g. "B · L · D".'),
                                        ]),
                                        static::shared(
                                            Toggle::make('open')->label('Show this day expanded when the page opens'),
                                        ),
                                    ])
                                    ->itemLabel(fn (array $state, $livewire) => static::itemLabel($state, 'title', $livewire, 'Day'))
                                    ->createItemButtonLabel('Add day')
                                    ->collapsible()
                                    ->disableItemCreation(fn ($livewire) => static::isTranslating($livewire))
                                    ->disableItemDeletion(fn ($livewire) => static::isTranslating($livewire))
                                    ->disableItemMovement(fn ($livewire) => static::isTranslating($livewire))
                                    ->minItems(1),
                            ]),

                        Section::make('Included & excluded')
                            ->schema([
                                Repeater::make('inclusions')
                                    ->label('Items')
                                    ->schema([
                                        static::shared(
                                            Toggle::make('included')->label('Included in the price')->default(true),
                                        ),
                                        Grid::make(2)->schema([
                                            ...static::localized('item', fn (string $path) => TextInput::make($path)->label('Item')->maxLength(80), required: true),
                                            ...static::localized('note', fn (string $path) => TextInput::make($path)->label('Note')->maxLength(160)),
                                        ]),
                                    ])
                                    ->itemLabel(fn (array $state, $livewire) => static::itemLabel($state, 'item', $livewire, 'Item', withStatus: true))
                                    ->createItemButtonLabel('Add item')
                                    ->collapsible()
                                    ->disableItemCreation(fn ($livewire) => static::isTranslating($livewire))
                                    ->disableItemDeletion(fn ($livewire) => static::isTranslating($livewire))
                                    ->disableItemMovement(fn ($livewire) => static::isTranslating($livewire))
                                    ->default(fn () => static::defaultInclusions()),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                    Group::make([
                        Section::make('Tour details')
                            ->schema([
                                static::shared(
                                    TextInput::make('slug')
                                        ->label('Web address')
                                        ->prefix('/packages/')
                                        ->required()
                                        ->maxLength(120)
                                        ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                                        ->unique(ignoreRecord: true)
                                        ->helperText('Lowercase letters, numbers and hyphens. Changing it breaks old links.'),
                                    Select::make('kind')
                                        ->label('Destination')
                                        ->options(['Inbound' => 'Sri Lanka (inbound)', 'Outbound' => 'Outbound'])
                                        ->default('Inbound')
                                        ->required(),
                                    Select::make('theme')
                                        ->options(array_combine(config('travel.themes'), config('travel.themes')))
                                        ->required(),
                                    Select::make('country')
                                        ->options(array_combine($countries = array_keys(config('travel.country_labels')), $countries))
                                        ->default('Sri Lanka')
                                        ->required(),
                                    TextInput::make('days')
                                        ->numeric()
                                        ->minValue(1)
                                        ->maxValue(60)
                                        ->required()
                                        ->helperText('Shown on cards and used by the duration filter.'),
                                ),
                                ...static::localized('pax', fn (string $path) => TextInput::make($path)
                                    ->label('Group size')
                                    ->maxLength(40), required: true, help: 'e.g. "2–14 pax".'),
                            ]),

                        static::shared(
                            Section::make('Photos')
                                ->schema([
                                    FileUpload::make('hero_image')
                                        ->label('Main photo')
                                        ->image()
                                        ->disk('public')
                                        ->directory('packages')
                                        ->maxSize(8192)
                                        ->helperText('Wide landscape photo for the top of the page and the package card. Without one, a placeholder is used.'),
                                    FileUpload::make('gallery')
                                        ->label('Photo strip')
                                        ->image()
                                        ->multiple()
                                        ->enableReordering()
                                        ->disk('public')
                                        ->directory('packages/gallery')
                                        ->maxFiles(8)
                                        ->maxSize(8192)
                                        ->helperText('Shown below the itinerary; four look best. Drag to reorder.'),
                                ]),

                            Section::make('Publishing')
                                ->schema([
                                    Toggle::make('is_published')
                                        ->label('Published on the website')
                                        ->default(true),
                                    Toggle::make('is_featured')
                                        ->label('Featured on the home page')
                                        ->helperText('The first three featured packages are shown.'),
                                ]),
                        ),
                    ])->columnSpan(['lg' => 1]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('')
                    ->getStateUsing(fn (Package $record) => $record->heroImageUrl(240, 160))
                    ->width(72)
                    ->height(48),
                TextColumn::make('title')
                    ->getStateUsing(fn (Package $record) => $record->title['en'] ?? $record->slug)
                    ->description(fn (Package $record) => ($record->location['en'] ?? '').' · '.$record->days.' days')
                    ->searchable(query: fn (Builder $query, string $search) => $query
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")),
                TextColumn::make('theme')->sortable(),
                TextColumn::make('kind')->label('Destination')->sortable(),
                IconColumn::make('is_featured')->label('Featured')->boolean(),
                IconColumn::make('is_published')->label('Published')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('kind')->label('Destination')->options(['Inbound' => 'Sri Lanka (inbound)', 'Outbound' => 'Outbound']),
                Tables\Filters\SelectFilter::make('theme')->options(array_combine(config('travel.themes'), config('travel.themes'))),
                Tables\Filters\TernaryFilter::make('is_published')->label('Published'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-external-link')
                    ->url(fn (Package $record) => route('packages.show', $record->slug))
                    ->openUrlInNewTab()
                    ->visible(fn (Package $record) => $record->is_published),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }

    /**
     * One copy of a field per language, each tagged with its locale so only the active one shows.
     * English is required where $required; the other languages show the English beneath them.
     *
     * @param  Closure(string $path): \Filament\Forms\Components\Field  $make
     * @return list<Group>
     */
    public static function localized(string $name, Closure $make, bool $required = false, ?string $help = null): array
    {
        $groups = [];

        foreach (static::locales() as $locale => $properties) {
            $field = $make("{$name}.{$locale}");

            if ($locale === Package::SOURCE_LOCALE) {
                $field->required($required)->helperText($help);
            } else {
                $field
                    ->label($field->getLabel().' · '.$properties['native'])
                    ->required(false)
                    ->placeholder(fn (Closure $get) => $get("{$name}.".Package::SOURCE_LOCALE))
                    ->helperText(fn (Closure $get) => filled($english = $get("{$name}.".Package::SOURCE_LOCALE)) ? 'English: '.$english : 'No English text yet.')
                    ->hint(fn (Closure $get, $livewire) => static::isOutdated($livewire, $name, $locale, $get) ? 'English changed since this was translated' : null)
                    ->hintIcon(fn (Closure $get, $livewire) => static::isOutdated($livewire, $name, $locale, $get) ? 'heroicon-s-exclamation' : null)
                    ->hintColor('warning');
            }

            $groups[] = Group::make([$field])->extraAttributes(['data-content-locale' => $locale]);
        }

        return $groups;
    }

    /**
     * Fields that are the same in every language; they are only shown while editing English.
     */
    public static function shared(Component ...$components): Group
    {
        return Group::make($components)->extraAttributes(['data-locale-shared' => 'true']);
    }

    public static function isTranslating($livewire): bool
    {
        return ($livewire->activeLocale ?? Package::SOURCE_LOCALE) !== Package::SOURCE_LOCALE;
    }

    /**
     * Whether the saved translation at this field was made from different English than the form now has.
     */
    private static function isOutdated($livewire, string $name, string $locale, Closure $get): bool
    {
        $record = $livewire->record ?? null;

        if (! $record instanceof Package || blank($get("{$name}.{$locale}"))) {
            return false;
        }

        // Inside a repeater item the path includes the list name and item key.
        $key = $get('key');
        $path = $key ? static::listNameFor($name)."{$key}.{$name}" : $name;

        return isset($record->translation_sources[$locale][$path])
            && $record->translation_sources[$locale][$path] !== sha1((string) $get("{$name}.".Package::SOURCE_LOCALE));
    }

    private static function listNameFor(string $field): string
    {
        foreach (Package::LIST_TEXT_FIELDS as $list => $fields) {
            if (in_array($field, $fields, true)) {
                return "{$list}.";
            }
        }

        return '';
    }

    private static function itemLabel(array $state, string $field, $livewire, string $fallback, bool $withStatus = false): string
    {
        $locale = $livewire->activeLocale ?? Package::SOURCE_LOCALE;
        $text = $state[$field][$locale] ?? null;
        $label = filled($text) ? $text : (($state[$field][Package::SOURCE_LOCALE] ?? null) ?: $fallback);

        if ($locale !== Package::SOURCE_LOCALE && blank($text) && filled($state[$field][Package::SOURCE_LOCALE] ?? null)) {
            $label .= ' — not translated';
        }

        if ($withStatus) {
            $label = (($state['included'] ?? true) ? '✓ ' : '– ').$label;
        }

        return $label;
    }

    /**
     * Starting inclusions for a new package (English; translate after saving).
     */
    private static function defaultInclusions(): array
    {
        return array_map(fn (array $row) => [
            'key' => (string) Str::uuid(),
            'item' => ['en' => $row['item']],
            'note' => ['en' => $row['note']],
            'included' => $row['included'],
        ], config('travel.default_inclusions', []));
    }
}
