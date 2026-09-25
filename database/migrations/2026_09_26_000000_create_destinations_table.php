<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Destinations move from config/travel.php into the database so they can be edited in the admin
 * panel, and are linked to packages (many-to-many: one tour can run through several destinations).
 * The Hindi and Tamil already made by the Translator page are carried over from the translations table.
 */
return new class extends Migration
{
    private const LOCALES = ['hi', 'ta'];

    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            // Stable keys: Inbound|Outbound, a config travel.country_labels key and travel.tag_labels keys.
            $table->string('kind', 16);
            $table->string('country', 64);
            $table->json('name');
            $table->json('blurb');
            $table->json('tags')->nullable();
            $table->string('hero_image')->nullable();
            // Placeholder photo seed used until a photo is uploaded.
            $table->string('image_seed', 32)->nullable();
            $table->boolean('is_published')->default(true);
            // Shown in the "Where we go" strip on the home page.
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            // locale => field => sha1 of the English each translation was made from.
            $table->json('translation_sources')->nullable();
            $table->timestamps();
        });

        Schema::create('destination_package', function (Blueprint $table) {
            $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->primary(['destination_id', 'package_id']);
        });

        $this->importFromConfig();
    }

    public function down(): void
    {
        Schema::dropIfExists('destination_package');
        Schema::dropIfExists('destinations');
    }

    private function importFromConfig(): void
    {
        $existing = $this->existingTranslations();
        $now = now();

        foreach ($this->destinations() as $index => $destination) {
            $text = [];
            $sources = [];

            foreach (['name', 'blurb'] as $field) {
                $english = $destination[$field];
                $text[$field] = ['en' => $english];

                foreach (self::LOCALES as $locale) {
                    if (isset($existing[$locale][$english])) {
                        $text[$field][$locale] = $existing[$locale][$english];
                        $sources[$locale][$field] = sha1($english);
                    }
                }
            }

            $id = DB::table('destinations')->insertGetId([
                'slug' => $destination['slug'],
                'kind' => $destination['kind'],
                'country' => $destination['country'],
                'name' => json_encode($text['name'], JSON_UNESCAPED_UNICODE),
                'blurb' => json_encode($text['blurb'], JSON_UNESCAPED_UNICODE),
                'tags' => json_encode($destination['tags']),
                'image_seed' => $destination['img'],
                'is_published' => true,
                // The home page showed the first five.
                'is_featured' => $index < 5,
                'sort_order' => $index + 1,
                'translation_sources' => json_encode($sources),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $packageIds = DB::table('packages')->whereIn('slug', $destination['packages'])->pluck('id');
            foreach ($packageIds as $packageId) {
                DB::table('destination_package')->insert(['destination_id' => $id, 'package_id' => $packageId]);
            }
        }
    }

    /**
     * @return array<string, array<string, string>> locale => English => translation
     */
    private function existingTranslations(): array
    {
        if (! Schema::hasTable('translations')) {
            return [];
        }

        $existing = [];
        foreach (DB::table('translations')->where('group', '*')->whereIn('locale', self::LOCALES)->get(['locale', 'source', 'text']) as $row) {
            $existing[$row->locale][$row->source] = $row->text;
        }

        return $existing;
    }

    /**
     * The destinations from config/travel.php, with the packages that run through each.
     */
    private function destinations(): array
    {
        return [
            ['slug' => 'colombo-the-west', 'kind' => 'Inbound', 'country' => 'Sri Lanka', 'img' => 'niod1', 'tags' => ['City', 'Food', 'Shopping'],
                'name' => 'Colombo & the west',
                'blurb' => 'Arrivals, city sightseeing and the springboard for every circuit we run.',
                'packages' => ['ramayana-heritage-circuit']],
            ['slug' => 'kandy-hill-country', 'kind' => 'Inbound', 'country' => 'Sri Lanka', 'img' => 'niod2', 'tags' => ['Culture', 'Train', 'Tea'],
                'name' => 'Kandy & the hill country',
                'blurb' => 'Tea estates, the Temple of the Tooth and the Ella train through the gap.',
                'packages' => ['emerald-coast-honeymoon', 'cultural-triangle-explorer', 'ramayana-heritage-circuit', 'knuckles-trek-kitulgala-rafting']],
            ['slug' => 'yala-udawalawe', 'kind' => 'Inbound', 'country' => 'Sri Lanka', 'img' => 'niod3', 'tags' => ['Wildlife', 'Safari'],
                'name' => 'Yala & Udawalawe',
                'blurb' => 'Leopards, elephants and the best-run game drives on the island.',
                'packages' => ['yala-udawalawe-safari']],
            ['slug' => 'galle-south-coast', 'kind' => 'Inbound', 'country' => 'Sri Lanka', 'img' => 'niod4', 'tags' => ['Beach', 'Honeymoon', 'Whales'],
                'name' => 'Galle & the south coast',
                'blurb' => 'Fort evenings, whale cruises from Mirissa and quiet honeymoon beaches.',
                'packages' => ['emerald-coast-honeymoon', 'southern-beaches-escape']],
            ['slug' => 'trincomalee-the-east', 'kind' => 'Inbound', 'country' => 'Sri Lanka', 'img' => 'niod5', 'tags' => ['Reef', 'Diving'],
                'name' => 'Trincomalee & the east',
                'blurb' => 'Pigeon Island reef, Swami Rock dives and flat May-to-September seas.',
                'packages' => ['pigeon-island-reef-dive']],
            ['slug' => 'cultural-triangle', 'kind' => 'Inbound', 'country' => 'Sri Lanka', 'img' => 'niod6', 'tags' => ['Heritage', 'UNESCO'],
                'name' => 'Cultural Triangle',
                'blurb' => 'Sigiriya, Dambulla, Polonnaruwa and Anuradhapura in one loop.',
                'packages' => ['cultural-triangle-explorer', 'minneriya-elephant-gathering']],
            ['slug' => 'maldives', 'kind' => 'Outbound', 'country' => 'Maldives', 'img' => 'niod7', 'tags' => ['Honeymoon', 'Reef'],
                'name' => 'Maldives',
                'blurb' => 'Overwater villas an hour from Colombo, our most-booked honeymoon add-on.',
                'packages' => ['maldives-overwater-getaway']],
            ['slug' => 'thailand', 'kind' => 'Outbound', 'country' => 'Thailand', 'img' => 'niod8', 'tags' => ['Beach', 'City'],
                'name' => 'Thailand',
                'blurb' => 'Bangkok, Phuket and Krabi, with Indian-friendly dining arranged.',
                'packages' => ['thailand-islands-bangkok']],
            ['slug' => 'singapore-malaysia', 'kind' => 'Outbound', 'country' => 'Singapore', 'img' => 'niod9', 'tags' => ['Family', 'City'],
                'name' => 'Singapore & Malaysia',
                'blurb' => 'The family favourite: theme parks, gardens and easy transfers.',
                'packages' => ['singapore-sentosa-family-break']],
            ['slug' => 'dubai-abu-dhabi', 'kind' => 'Outbound', 'country' => 'UAE', 'img' => 'niod10', 'tags' => ['City', 'Desert'],
                'name' => 'Dubai & Abu Dhabi',
                'blurb' => 'City sightseeing, desert evenings and shopping weeks.',
                'packages' => ['dubai-city-desert']],
            ['slug' => 'nepal', 'kind' => 'Outbound', 'country' => 'Nepal', 'img' => 'niod11', 'tags' => ['Mountains', 'Pilgrimage'],
                'name' => 'Nepal',
                'blurb' => 'Kathmandu, Pokhara and the Annapurna foothills for walking groups.',
                'packages' => []],
            ['slug' => 'vietnam', 'kind' => 'Outbound', 'country' => 'Vietnam', 'img' => 'niod12', 'tags' => ['Culture', 'Beach'],
                'name' => 'Vietnam',
                'blurb' => 'Hanoi, Ha Long Bay and Da Nang, our fastest-growing outbound route.',
                'packages' => []],
        ];
    }
};
