<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Packages move from config/travel.php into the database so they can be edited in the admin panel.
 * Text fields hold every language in one JSON object ({"en": ..., "hi": ..., "ta": ...}); the
 * Hindi and Tamil already made by the Translator page are carried over from the translations table.
 */
return new class extends Migration
{
    private const LOCALES = ['hi', 'ta'];

    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            // Stable filter keys (config travel.themes / Inbound|Outbound), never translated.
            $table->string('kind', 16);
            $table->string('theme', 64);
            $table->string('country', 64);
            $table->unsignedSmallInteger('days');
            $table->json('title');
            $table->json('location');
            $table->json('pax');
            $table->json('blurb');
            $table->json('season');
            $table->json('itinerary');
            $table->json('inclusions');
            $table->string('hero_image')->nullable();
            $table->json('gallery')->nullable();
            // Placeholder photo seed used until a hero image is uploaded.
            $table->string('image_seed', 32)->nullable();
            $table->boolean('is_published')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            // locale => field path => sha1 of the English each translation was made from.
            $table->json('translation_sources')->nullable();
            $table->timestamps();
        });

        $this->importFromConfig();
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }

    private function importFromConfig(): void
    {
        $existing = $this->existingTranslations();
        $localize = function (string $english) use ($existing): array {
            $value = ['en' => $english];
            foreach (self::LOCALES as $locale) {
                if (isset($existing[$locale][$english])) {
                    $value[$locale] = $existing[$locale][$english];
                }
            }

            return $value;
        };

        $now = now();
        $featured = ['p1', 'p2', 'p4'];

        foreach ($this->packages() as $index => $package) {
            $itinerary = array_map(fn (array $day) => [
                'key' => (string) Str::uuid(),
                'title' => $localize($day['title']),
                'body' => $localize($day['body']),
                'stay' => $localize($day['stay']),
                'meals' => ['en' => $day['meals']],
                'open' => $day['open'],
            ], $this->sampleItinerary());

            $inclusions = array_map(fn (array $row) => [
                'key' => (string) Str::uuid(),
                'item' => $localize($row['item']),
                'note' => $localize($row['note']),
                'included' => $row['included'],
            ], $this->inclusions());

            $row = [
                'slug' => $package['slug'],
                'kind' => $package['kind'],
                'theme' => $package['theme'],
                'country' => $package['country'],
                'days' => $package['days'],
                'title' => $localize($package['title']),
                'location' => $localize($package['where']),
                'pax' => ['en' => $package['pax']],
                'blurb' => $localize($package['blurb']),
                'season' => $localize($package['season']),
                'itinerary' => $itinerary,
                'inclusions' => $inclusions,
            ];

            DB::table('packages')->insert([
                ...array_map(fn ($value) => is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value, $row),
                'image_seed' => $package['img'],
                'is_published' => true,
                'is_featured' => in_array($package['id'], $featured, true),
                'sort_order' => $index + 1,
                'translation_sources' => json_encode($this->sourcesFor($row)),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Carried-over translations were made from the current English, so record them as up to date.
     */
    private function sourcesFor(array $row): array
    {
        $sources = [];
        $record = function (string $path, array $value) use (&$sources) {
            foreach (self::LOCALES as $locale) {
                if (isset($value[$locale])) {
                    $sources[$locale][$path] = sha1($value['en']);
                }
            }
        };

        foreach (['title', 'location', 'pax', 'blurb', 'season'] as $field) {
            $record($field, $row[$field]);
        }
        foreach (['itinerary' => ['title', 'body', 'stay', 'meals'], 'inclusions' => ['item', 'note']] as $list => $fields) {
            foreach ($row[$list] as $item) {
                foreach ($fields as $field) {
                    $record("{$list}.{$item['key']}.{$field}", $item[$field]);
                }
            }
        }

        return $sources;
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

    private function packages(): array
    {
        return [
            ['id' => 'p1', 'slug' => 'emerald-coast-honeymoon', 'theme' => 'Honeymoon', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 6, 'pax' => '2 pax', 'img' => 'niop1',
                'title' => 'Emerald Coast Honeymoon', 'where' => 'Galle · Mirissa · Ella',
                'season' => 'December to April on the south coast; the sea is calm and the evenings dry.',
                'blurb' => 'Private villa nights on the south coast, a hill-country train morning and a sunset whale cruise from Mirissa.'],
            ['id' => 'p2', 'slug' => 'yala-udawalawe-safari', 'theme' => 'Wildlife', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 5, 'pax' => '2–14 pax', 'img' => 'niop2',
                'title' => 'Yala & Udawalawe Safari', 'where' => 'Yala · Udawalawe',
                'season' => 'February to July, when the waterholes shrink and sightings peak.',
                'blurb' => 'Two parks, four game drives and a naturalist who knows which waterhole the leopards are using this month.'],
            ['id' => 'p3', 'slug' => 'pigeon-island-reef-dive', 'theme' => 'Reef & diving', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 4, 'pax' => '2–10 pax', 'img' => 'niop3',
                'title' => 'Pigeon Island Reef & Dive', 'where' => 'Trincomalee · Nilaveli',
                'season' => 'May to September on the east coast, flat water, clear visibility.',
                'blurb' => 'Snorkel the reef flats, two guided dives at Swami Rock, and a PADI discover-scuba session for first-timers.'],
            ['id' => 'p4', 'slug' => 'cultural-triangle-explorer', 'theme' => 'Culture & heritage', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 7, 'pax' => '2–24 pax', 'img' => 'niop4',
                'title' => 'Cultural Triangle Explorer', 'where' => 'Sigiriya · Polonnaruwa · Kandy',
                'season' => 'All year; climb Sigiriya at first light in any season.',
                'blurb' => 'Sigiriya at dawn, the Polonnaruwa ruins by bicycle, cave temples at Dambulla and evening drumming in Kandy.'],
            ['id' => 'p5', 'slug' => 'ramayana-heritage-circuit', 'theme' => 'Pilgrimage', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 7, 'pax' => '20–60 pax', 'img' => 'niop5',
                'title' => 'Ramayana Heritage Circuit', 'where' => 'Chilaw · Nuwara Eliya · Ella',
                'season' => 'January to March, ideal for large groups in the hills.',
                'blurb' => "The island's Ramayana sites with a Hindi-speaking manager, pure-veg catering and temple arrangements for large groups."],
            ['id' => 'p6', 'slug' => 'knuckles-trek-kitulgala-rafting', 'theme' => 'Adventure', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 5, 'pax' => '4–16 pax', 'img' => 'niop7',
                'title' => 'Knuckles Trek & Kitulgala Rafting', 'where' => 'Knuckles · Kitulgala',
                'season' => 'January to March and July to September for the driest trails.',
                'blurb' => 'Two days on the Knuckles ridges, a night in a tented camp and grade-3 rapids on the Kelani river.'],
            ['id' => 'p7', 'slug' => 'southern-beaches-escape', 'theme' => 'Beach', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 5, 'pax' => '2–20 pax', 'img' => 'niop8',
                'title' => 'Southern Beaches Escape', 'where' => 'Bentota · Unawatuna',
                'season' => 'November to April.',
                'blurb' => 'Beach days either side of a Galle fort evening, with a river safari and a turtle hatchery stop for the children.'],
            ['id' => 'p8', 'slug' => 'minneriya-elephant-gathering', 'theme' => 'Wildlife', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 3, 'pax' => '2–18 pax', 'img' => 'niop9',
                'title' => 'Minneriya Elephant Gathering', 'where' => 'Habarana · Minneriya',
                'season' => 'August and September, when hundreds gather at the tank.',
                'blurb' => 'A short trip timed to the Gathering, with an afternoon jeep and a village lunch in Habarana.'],
            ['id' => 'p9', 'slug' => 'maldives-overwater-getaway', 'theme' => 'Honeymoon', 'country' => 'Maldives', 'kind' => 'Outbound', 'days' => 4, 'pax' => '2 pax', 'img' => 'niop10',
                'title' => 'Maldives Overwater Getaway', 'where' => 'Male · North Ari Atoll',
                'season' => 'January to April for the clearest lagoons.',
                'blurb' => 'Seaplane transfer, three nights in an overwater villa, a sandbank dinner and a manta snorkel morning.'],
            ['id' => 'p10', 'slug' => 'singapore-sentosa-family-break', 'theme' => 'City break', 'country' => 'Singapore', 'kind' => 'Outbound', 'days' => 5, 'pax' => '2–12 pax', 'img' => 'niop11',
                'title' => 'Singapore & Sentosa Family Break', 'where' => 'Singapore · Sentosa',
                'season' => 'All year; February to April is driest.',
                'blurb' => 'Gardens by the Bay, Universal Studios and a river cruise, with family rooms near Orchard Road.'],
            ['id' => 'p11', 'slug' => 'thailand-islands-bangkok', 'theme' => 'Beach', 'country' => 'Thailand', 'kind' => 'Outbound', 'days' => 6, 'pax' => '2–16 pax', 'img' => 'niop12',
                'title' => 'Thailand Islands & Bangkok', 'where' => 'Bangkok · Krabi',
                'season' => 'November to March.',
                'blurb' => 'Two city nights and four on the Andaman coast, with island hopping and a longtail trip to Railay.'],
            ['id' => 'p12', 'slug' => 'dubai-city-desert', 'theme' => 'City break', 'country' => 'UAE', 'kind' => 'Outbound', 'days' => 5, 'pax' => '2–20 pax', 'img' => 'niop13',
                'title' => 'Dubai City & Desert', 'where' => 'Dubai · Al Marmoom',
                'season' => 'November to March.',
                'blurb' => "Burj Khalifa, a dhow dinner, an evening desert safari and a day trip to Abu Dhabi's Grand Mosque."],
        ];
    }

    private function sampleItinerary(): array
    {
        return [
            ['title' => 'Arrival & transfer', 'body' => 'Met at the airport with a name-board, SIM card and cold towels. Transfer to the first hotel, welcome dinner and a route briefing with your tour manager.', 'stay' => 'Negombo / Colombo', 'meals' => 'Dinner', 'open' => false],
            ['title' => 'On the road', 'body' => 'The first full touring day, timed to avoid the coach crowds. Lunch at a place we actually eat at, and an afternoon at a slower pace.', 'stay' => 'En route', 'meals' => 'B · L · D', 'open' => false],
            ['title' => 'The main experience', 'body' => 'The centrepiece of this tour, booked and permitted in advance so there is no queueing on the day.', 'stay' => 'En route', 'meals' => 'B · L · D', 'open' => true],
            ['title' => 'A free morning', 'body' => 'Deliberately unscheduled. Spa, market, beach or a second game drive, your manager arranges whichever you pick at breakfast.', 'stay' => 'En route', 'meals' => 'B · D', 'open' => false],
            ['title' => 'Return & departure', 'body' => 'A relaxed drive back with one last stop, then the airport with time to spare. Written trip record handed over.', 'stay' => 'Departure', 'meals' => 'B', 'open' => false],
        ];
    }

    private function inclusions(): array
    {
        return array_map(
            fn (array $row) => ['item' => $row[0], 'note' => $row[1], 'included' => $row[2]],
            [
                ['Accommodation', 'Twin-share; upgrades quoted on request', true],
                ['Airport transfers', 'Private vehicle, meet and greet', true],
                ['AC vehicle & driver-guide', 'Dedicated for your party throughout', true],
                ['Entrance fees', 'All sites named in the itinerary', true],
                ['Daily breakfast', 'Half or full board quoted on request', true],
                ['Airfare', 'We block-book from Chennai, Trichy, Mumbai or Delhi', false],
                ['Visa fee', 'ETA assistance and invitation letters provided', false],
                ['Travel insurance', 'Strongly recommended; mandatory over 70', false],
            ],
        );
    }
};
