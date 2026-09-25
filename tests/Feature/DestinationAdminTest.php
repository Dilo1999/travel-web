<?php

namespace Tests\Feature;

use App\Filament\Resources\DestinationResource\Pages\CreateDestination;
use App\Filament\Resources\DestinationResource\Pages\EditDestination;
use App\Filament\Resources\PackageResource\Pages\EditPackage;
use App\Models\Destination;
use App\Models\Package;
use App\Models\User;
use App\Services\ClaudeTranslator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DestinationAdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin(string $role = User::ROLE_ADMIN): User
    {
        return User::factory()->create(['role' => $role]);
    }

    private function destination(string $slug): Destination
    {
        return Destination::query()->where('slug', $slug)->firstOrFail();
    }

    public function test_migration_imports_destinations_and_links_packages(): void
    {
        $this->assertSame(12, Destination::count());

        $kandy = $this->destination('kandy-hill-country');
        $this->assertSame('Kandy & the hill country', $kandy->name['en']);
        $this->assertSame(['Culture', 'Train', 'Tea'], $kandy->tags);
        $this->assertEqualsCanonicalizing(
            ['emerald-coast-honeymoon', 'cultural-triangle-explorer', 'ramayana-heritage-circuit', 'knuckles-trek-kitulgala-rafting'],
            $kandy->packages->pluck('slug')->all(),
        );
        $this->assertCount(0, $this->destination('nepal')->packages);
        $this->assertSame(5, Destination::query()->where('is_featured', true)->count());
    }

    public function test_see_packages_lists_only_that_destinations_packages(): void
    {
        $this->get('/packages?destination=galle-south-coast')
            ->assertOk()
            ->assertSee('Emerald Coast Honeymoon')
            ->assertSee('Southern Beaches Escape')
            ->assertDontSee('Yala &amp; Udawalawe Safari', false)
            ->assertSee('Galle &amp; the south coast', false);

        // An unknown destination falls back to the normal list.
        $this->get('/packages?destination=nowhere')->assertOk()->assertSee('Yala &amp; Udawalawe Safari', false);
    }

    public function test_destination_card_links_to_its_packages_or_to_an_enquiry(): void
    {
        $this->get('/destinations')
            ->assertOk()
            ->assertSee(route('packages.index', ['destination' => 'yala-udawalawe']), false)
            ->assertSee(e(route('contact', ['package' => 'Nepal'])), false);
    }

    public function test_package_page_links_back_to_its_destinations(): void
    {
        $this->get('/packages/cultural-triangle-explorer')
            ->assertOk()
            ->assertSee(route('packages.index', ['destination' => 'cultural-triangle']), false)
            ->assertSee(route('packages.index', ['destination' => 'kandy-hill-country']), false);
    }

    public function test_unpublished_destinations_are_hidden(): void
    {
        $this->destination('nepal')->update(['is_published' => false]);

        $this->get('/destinations?kind=Outbound')->assertOk()->assertDontSee('Kathmandu');
    }

    public function test_edit_destination_in_another_language_and_link_packages(): void
    {
        $this->actingAs($this->admin(User::ROLE_EDITOR));
        $nepal = $this->destination('nepal');
        $package = Package::query()->where('slug', 'maldives-overwater-getaway')->firstOrFail();

        Livewire::test(EditDestination::class, ['record' => $nepal->getKey()])
            ->set('data.packages', [(string) $package->getKey()])
            ->call('setActiveLocale', 'ta')
            ->assertSee('You are editing the')
            ->set('data.name.ta', 'நேபாளம் மலைகள்')
            ->call('save')
            ->assertHasNoErrors();

        $nepal->refresh();
        $this->assertSame('நேபாளம் மலைகள்', $nepal->name['ta']);
        $this->assertSame('Nepal', $nepal->name['en']);
        $this->assertSame([$package->getKey()], $nepal->packages->modelKeys());
    }

    public function test_linking_from_the_package_side(): void
    {
        $this->actingAs($this->admin());
        $package = Package::query()->where('slug', 'yala-udawalawe-safari')->firstOrFail();
        $ids = [$this->destination('yala-udawalawe')->getKey(), $this->destination('galle-south-coast')->getKey()];

        Livewire::test(EditPackage::class, ['record' => $package->getKey()])
            ->assertSet('data.destinations', [(string) $ids[0]])
            ->set('data.destinations', array_map('strval', $ids))
            ->call('save')
            ->assertHasNoErrors();

        $this->assertEqualsCanonicalizing($ids, $package->fresh()->destinations->modelKeys());
    }

    public function test_create_destination(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(CreateDestination::class)
            ->set('data.name.en', 'Wilpattu & the north-west')
            ->assertSet('data.slug', 'wilpattu-the-north-west')
            ->set('data.blurb.en', 'Villus, leopards and quiet jeep tracks.')
            ->set('data.tags', ['Wildlife'])
            ->call('create')
            ->assertHasNoErrors();

        $destination = $this->destination('wilpattu-the-north-west');
        $this->assertSame('Inbound', $destination->kind);
        $this->assertSame(13, $destination->sort_order);
    }

    public function test_translate_destination_with_claude(): void
    {
        $this->app->bind(ClaudeTranslator::class, fn () => new class extends ClaudeTranslator
        {
            public function __construct() {}

            public function translate(array $items, string $language, array $glossary, callable $onBatch): array
            {
                $onBatch(array_map(fn (array $item) => "[{$language}] {$item['text']}", $items));

                return [];
            }
        });
        $this->actingAs($this->admin());
        $nepal = $this->destination('nepal');

        Livewire::test(EditDestination::class, ['record' => $nepal->getKey()])
            ->callPageAction('translate', ['locales' => ['hi'], 'scope' => 'pending'])
            ->assertHasNoPageActionErrors()
            ->assertSet('activeLocale', 'hi');

        $nepal->refresh();
        $this->assertSame('[Hindi (हिन्दी)] Nepal', $nepal->name['hi']);
        $this->assertSame(0, $nepal->translationSummary('hi')['missing']);
    }

    public function test_viewers_cannot_edit_destinations(): void
    {
        $this->actingAs($this->admin(User::ROLE_VIEWER));

        $this->get('/admin/destinations')->assertOk();
        $this->get('/admin/destinations/'.$this->destination('nepal')->getKey().'/edit')->assertForbidden();
    }
}
