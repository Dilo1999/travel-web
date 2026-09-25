<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableText;
use App\Models\Contracts\TranslatableContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

/**
 * A place we run or book tours in, edited in the admin panel (DestinationResource). Text fields hold
 * every language; see HasTranslatableText. Packages are linked many-to-many, since one tour can run
 * through several destinations, and the destination card's "See packages" lists exactly those.
 */
class Destination extends Model implements TranslatableContent
{
    use HasTranslatableText;

    public const TEXT_FIELDS = ['name', 'blurb'];

    public const LIST_TEXT_FIELDS = [];

    protected $fillable = [
        'slug', 'kind', 'country', 'name', 'blurb', 'tags',
        'hero_image', 'image_seed', 'is_published', 'is_featured', 'sort_order',
    ];

    protected $casts = [
        'name' => 'array',
        'blurb' => 'array',
        'tags' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'translation_sources' => 'array',
    ];

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class)->orderBy('packages.sort_order')->orderBy('packages.id');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Load the number of published packages as published_packages_count.
     */
    public function scopeWithPublishedPackageCount(Builder $query): void
    {
        $query->withCount(['packages as published_packages_count' => fn (Builder $packages) => $packages->where('is_published', true)]);
    }

    public function describePath(string $path): string
    {
        $name = $this->name[self::SOURCE_LOCALE] ?? $this->slug;
        $what = $path === 'name' ? 'name' : 'short description';

        return "travel destination \"{$name}\": {$what}";
    }

    public function heroImageUrl(int $width = 1000, int $height = 700): string
    {
        if ($this->hero_image) {
            return Storage::disk('public')->url($this->hero_image);
        }

        return travel_img($this->image_seed ?: 'niodest'.$this->id, $width, $height, travel_place($this->name ?? '').','.$this->country);
    }

    /**
     * Where the card's button goes: this destination's packages, or an enquiry about it when it has none yet.
     */
    public function packagesUrl(): string
    {
        return $this->publishedPackageCount() > 0
            ? route('packages.index', ['destination' => $this->slug])
            : route('contact', ['package' => travel_t($this->name)]);
    }

    public function publishedPackageCount(): int
    {
        return $this->published_packages_count ??= $this->packages()->where('is_published', true)->count();
    }
}
