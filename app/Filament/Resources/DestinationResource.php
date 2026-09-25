<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\TranslatableForm;
use App\Filament\Resources\DestinationResource\Pages;
use App\Models\Destination;
use App\Models\Package;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
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

/**
 * Destinations on the Destinations page and the home page, edited in every site language
 * (see TranslatableForm) and linked to the packages that run through them.
 */
class DestinationResource extends Resource
{
    use TranslatableForm;

    protected static ?string $model = Destination::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'slug';

    public static function getRecordTitle(?Model $record): ?string
    {
        return $record instanceof Destination ? ($record->name[Destination::SOURCE_LOCALE] ?? $record->slug) : static::getModelLabel();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Group::make([
                        Section::make('Destination')
                            ->schema([
                                ...static::localized('name', fn (string $path) => TextInput::make($path)
                                    ->label('Name')
                                    ->maxLength(80)
                                    ->lazy()
                                    ->afterStateUpdated(function (?string $state, callable $set, $livewire) use ($path) {
                                        if ($livewire instanceof CreateRecord && str_ends_with($path, '.en')) {
                                            $set('slug', Str::slug((string) $state));
                                        }
                                    }), required: true, help: 'e.g. "Kandy & the hill country".'),
                                ...static::localized('blurb', fn (string $path) => Textarea::make($path)
                                    ->label('Description')
                                    ->rows(3)
                                    ->maxLength(300), required: true, help: 'One or two sentences for the destination card.'),
                            ]),

                        static::shared(
                            Section::make('Packages')
                                ->description('Tours that run through this destination. The card\'s "See packages" button lists them; with none, it becomes "Enquire now".')
                                ->schema([
                                    Select::make('packages')
                                        ->label('Packages here')
                                        ->multiple()
                                        ->relationship('packages', 'slug')
                                        ->getOptionLabelFromRecordUsing(fn (Package $record) => $record->title[Package::SOURCE_LOCALE] ?? $record->slug)
                                        ->preload(),
                                ]),
                        ),
                    ])->columnSpan(['lg' => 2]),

                    Group::make([
                        static::shared(
                            Section::make('Details')
                                ->schema([
                                    TextInput::make('slug')
                                        ->label('Link name')
                                        ->required()
                                        ->maxLength(120)
                                        ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                                        ->unique(ignoreRecord: true)
                                        ->helperText('Used in the link to its packages, e.g. /packages?destination=yala-udawalawe. Lowercase letters, numbers and hyphens.'),
                                    Select::make('kind')
                                        ->label('Type')
                                        ->options(['Inbound' => 'Sri Lanka (inbound)', 'Outbound' => 'Outbound'])
                                        ->default('Inbound')
                                        ->required(),
                                    Select::make('country')
                                        ->options(array_combine($countries = array_keys(config('travel.country_labels')), $countries))
                                        ->default('Sri Lanka')
                                        ->required(),
                                    Select::make('tags')
                                        ->multiple()
                                        ->options(array_combine($tags = array_keys(config('travel.tag_labels')), $tags))
                                        ->helperText('Shown on the card; they are translated with the rest of the website.'),
                                ]),

                            Section::make('Photo')
                                ->schema([
                                    FileUpload::make('hero_image')
                                        ->label('Card photo')
                                        ->image()
                                        ->disk('public')
                                        ->directory('destinations')
                                        ->maxSize(8192)
                                        ->helperText('Landscape photo for the destination card and the home page. Without one, a placeholder is used.'),
                                ]),

                            Section::make('Publishing')
                                ->schema([
                                    Toggle::make('is_published')
                                        ->label('Published on the website')
                                        ->default(true),
                                    Toggle::make('is_featured')
                                        ->label('Show on the home page')
                                        ->helperText('In "Where we go"; the first five are shown.'),
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
                    ->getStateUsing(fn (Destination $record) => $record->heroImageUrl(240, 160))
                    ->width(72)
                    ->height(48),
                TextColumn::make('name')
                    ->getStateUsing(fn (Destination $record) => $record->name['en'] ?? $record->slug)
                    ->description(fn (Destination $record) => $record->country)
                    ->searchable(query: fn (Builder $query, string $search) => $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")),
                TextColumn::make('kind')->label('Type')->sortable(),
                TextColumn::make('packages_count')->label('Packages')->counts('packages')->sortable(),
                IconColumn::make('is_featured')->label('Home page')->boolean(),
                IconColumn::make('is_published')->label('Published')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('kind')->label('Type')->options(['Inbound' => 'Sri Lanka (inbound)', 'Outbound' => 'Outbound']),
                Tables\Filters\TernaryFilter::make('is_published')->label('Published'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDestinations::route('/'),
            'create' => Pages\CreateDestination::route('/create'),
            'edit' => Pages\EditDestination::route('/{record}/edit'),
        ];
    }
}
