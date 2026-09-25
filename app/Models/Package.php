<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableText;
use App\Models\Contracts\TranslatableContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

/**
 * A tour package, edited in the admin panel (PackageResource). Text fields hold every language;
 * see HasTranslatableText. A package runs through one or more destinations.
 */
class Package extends Model implements TranslatableContent
{
    use HasTranslatableText;

    /** Top-level text fields. */
    public const TEXT_FIELDS = ['title', 'location', 'pax', 'blurb', 'season'];

    /** Text fields inside each item of the list fields. */
    public const LIST_TEXT_FIELDS = [
        'itinerary' => ['title', 'body', 'stay', 'meals'],
        'inclusions' => ['item', 'note'],
    ];

    protected $fillable = [
        'slug', 'kind', 'theme', 'country', 'days',
        'title', 'location', 'pax', 'blurb', 'season',
        'itinerary', 'inclusions', 'hero_image', 'gallery', 'image_seed',
        'is_published', 'is_featured', 'sort_order',
    ];

    protected $casts = [
        'days' => 'integer',
        'title' => 'array',
        'location' => 'array',
        'pax' => 'array',
        'blurb' => 'array',
        'season' => 'array',
        'itinerary' => 'array',
        'inclusions' => 'array',
        'gallery' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'translation_sources' => 'array',
    ];

    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(Destination::class)->orderBy('destinations.sort_order')->orderBy('destinations.id');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }

    public function describePath(string $path): string
    {
        $segments = explode('.', $path);
        $title = $this->title[self::SOURCE_LOCALE] ?? $this->slug;

        if (count($segments) === 1) {
            return "tour package \"{$title}\": {$path}";
        }

        [$list, $key, $field] = $segments;
        $position = collect($this->{$list} ?? [])->search(fn ($item) => ($item['key'] ?? null) === $key);
        $label = $list === 'itinerary' ? 'day '.($position + 1) : 'included/excluded item';

        return "tour package \"{$title}\": {$label} {$field}";
    }

    public function heroImageUrl(int $width = 1920, int $height = 900): string
    {
        if ($this->hero_image) {
            return Storage::disk('public')->url($this->hero_image);
        }

        return travel_img($this->image_seed ?: 'niopkg'.$this->id, $width, $height, $this->photoKeywords());
    }

    /**
     * The photo strip on the package page: the uploaded gallery, or four placeholders until there is one.
     *
     * @return list<string>
     */
    public function galleryUrls(): array
    {
        if ($this->gallery) {
            return array_values(array_map(fn (string $path) => Storage::disk('public')->url($path), $this->gallery));
        }

        return array_map(
            fn (int $i) => travel_img('niodet'.$this->id.'-'.$i, 700, 500, $this->photoKeywords()),
            range(1, 4),
        );
    }

    public function photoKeywords(): string
    {
        return travel_place($this->location ?? '').','.$this->country;
    }
}
