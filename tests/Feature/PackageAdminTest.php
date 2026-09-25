<?php

namespace Tests\Feature;

use App\Filament\Resources\PackageResource\Pages\CreatePackage;
use App\Filament\Resources\PackageResource\Pages\EditPackage;
use App\Models\Package;
use App\Models\User;
use App\Services\ClaudeTranslator;
use App\Services\SiteTranslations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\LaravelLocalization;
use Tests\TestCase;

class PackageAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // The test database has no translations table rows to import, so give Yala some.
        $yala = $this->yala();
        $yala->setTranslation('title', 'hi', 'याला और उदावलावे सफारी');
        $yala->setTranslation('title', 'ta', 'யாலா & உடவலவே சஃபாரி');
        $yala->save();
    }

    protected function tearDown(): void
    {
        putenv(LaravelLocalization::ENV_ROUTE_KEY);

        parent::tearDown();
    }

    /**
     * Localized routes are registered at boot from the request URL, so boot again for a locale.
     */
    private function bootWithLocale(string $locale): void
    {
        parent::tearDown();
        putenv(LaravelLocalization::ENV_ROUTE_KEY.'='.$locale);
        parent::setUp();
    }

    private function admin(string $role = User::ROLE_ADMIN): User
    {
        return User::factory()->create(['role' => $role]);
    }

    private function yala(): Package
    {
        return Package::query()->where('slug', 'yala-udawalawe-safari')->firstOrFail();
    }

    /**
     * A translator that never calls the API: every text comes back as "[locale] English".
     */
    private function fakeClaude(): void
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
    }

    public function test_migration_imports_packages_with_existing_structure(): void
    {
        $this->assertSame(12, Package::count());

        $yala = $this->yala();
        $this->assertSame('Yala & Udawalawe Safari', $yala->title['en']);
        $this->assertCount(5, $yala->itinerary);
        $this->assertTrue($yala->itinerary[2]['open']);
        $this->assertCount(8, $yala->inclusions);
        $this->assertSame(['p1', 'p2', 'p4'], Package::query()->where('is_featured', true)->ordered()->pluck('image_seed')->map(fn ($seed) => str_replace('niop', 'p', $seed))->all());
    }

    public function test_changing_english_marks_translation_outdated_until_it_is_retranslated(): void
    {
        $yala = $this->yala();
        $yala->setTranslation('title', 'hi', 'याला सफारी');
        $yala->save();
        $this->assertSame('current', $yala->translationState('title', 'hi'));

        $yala->title = [...$yala->title, 'en' => 'Yala Leopard Safari'];
        $yala->save();
        $this->assertSame('outdated', $yala->fresh()->translationState('title', 'hi'));

        $yala->setTranslation('title', 'hi', 'याला तेंदुआ सफारी');
        $yala->save();
        $this->assertSame('current', $yala->fresh()->translationState('title', 'hi'));
    }

    public function test_blank_translations_are_dropped_so_the_site_falls_back_to_english(): void
    {
        $yala = $this->yala();
        $yala->title = ['en' => ' Yala ', 'hi' => '  ', 'ta' => null];
        $yala->save();

        $this->assertSame(['en' => 'Yala'], $yala->fresh()->title);
        $this->assertSame('missing', $yala->fresh()->translationState('title', 'hi'));
    }

    public function test_editing_one_language_saves_without_losing_the_others(): void
    {
        $this->actingAs($this->admin());
        $yala = $this->yala();
        $tamilTitle = $yala->title['ta'];
        $firstDayKey = $yala->itinerary[0]['key'];

        $page = Livewire::test(EditPackage::class, ['record' => $yala->getKey()])
            ->assertSet('activeLocale', 'en')
            ->call('setActiveLocale', 'hi')
            ->assertSet('activeLocale', 'hi')
            ->assertSee('You are editing the');

        $itinerary = $page->get('data.itinerary');
        $firstUuid = array_key_first($itinerary);

        $page->set('data.title.hi', 'याला और उदावलावे वन्यजीव सफारी')
            ->set("data.itinerary.{$firstUuid}.title.hi", 'आगमन')
            ->call('save')
            ->assertHasNoErrors();

        $yala->refresh();
        $this->assertSame('याला और उदावलावे वन्यजीव सफारी', $yala->title['hi']);
        $this->assertSame($tamilTitle, $yala->title['ta']);
        $this->assertSame('Yala & Udawalawe Safari', $yala->title['en']);
        $this->assertSame('आगमन', $yala->itinerary[0]['title']['hi']);
        $this->assertSame($firstDayKey, $yala->itinerary[0]['key']);
        $this->assertTrue($yala->itinerary[2]['open']);
        $this->assertFalse($yala->inclusions[5]['included']);
        $this->assertSame('Wildlife', $yala->theme);
        $this->assertSame(5, $yala->days);
    }

    public function test_english_edits_made_before_switching_language_are_saved(): void
    {
        $this->actingAs($this->admin());
        $yala = $this->yala();

        Livewire::test(EditPackage::class, ['record' => $yala->getKey()])
            ->set('data.days', 6)
            ->set('data.theme', 'Adventure')
            ->call('setActiveLocale', 'ta')
            ->call('save')
            ->assertHasNoErrors();

        $yala->refresh();
        $this->assertSame(6, $yala->days);
        $this->assertSame('Adventure', $yala->theme);
    }

    public function test_cannot_switch_language_while_required_english_is_empty(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(EditPackage::class, ['record' => $this->yala()->getKey()])
            ->set('data.title.en', '')
            ->call('setActiveLocale', 'hi')
            ->assertHasErrors(['data.title.en'])
            ->assertSet('activeLocale', 'en');
    }

    public function test_translate_action_fills_missing_translations_and_keeps_edits(): void
    {
        $this->fakeClaude();
        $this->actingAs($this->admin());
        $yala = $this->yala();
        $existingHindiTitle = $yala->title['hi'];

        Livewire::test(EditPackage::class, ['record' => $yala->getKey()])
            ->callPageAction('translate', ['locales' => ['hi'], 'scope' => 'pending'])
            ->assertHasNoPageActionErrors()
            ->assertSet('activeLocale', 'hi');

        $yala->refresh();
        $this->assertSame('[Hindi (हिन्दी)] 2–14 pax', $yala->pax['hi']);
        $this->assertSame('[Hindi (हिन्दी)] B · L · D', $yala->itinerary[2]['meals']['hi']);
        $this->assertSame($existingHindiTitle, $yala->title['hi']);
        $this->assertSame(0, $yala->translationSummary('hi')['missing']);
        $this->assertGreaterThan(0, $yala->translationSummary('ta')['missing']);
    }

    public function test_translate_all_replaces_existing_translations(): void
    {
        $this->fakeClaude();
        $this->actingAs($this->admin());
        $yala = $this->yala();

        Livewire::test(EditPackage::class, ['record' => $yala->getKey()])
            ->call('translate', ['ta'], true);

        $this->assertSame('[Tamil (தமிழ்)] Yala & Udawalawe Safari', $yala->fresh()->title['ta']);
    }

    public function test_website_translator_run_does_not_include_package_text(): void
    {
        $sources = array_column(app(SiteTranslations::class)->strings(), 'source');

        $this->assertNotContains('Yala & Udawalawe Safari', $sources);
        $this->assertNotContains('The main experience', $sources);
        $this->assertNotContains('Kandy & the hill country', $sources, 'destinations are translated from their own edit page too');
    }

    public function test_create_package_in_english(): void
    {
        $this->actingAs($this->admin(User::ROLE_EDITOR));

        Livewire::test(CreatePackage::class)
            ->set('data.title.en', 'Wilpattu Leopard Trail')
            ->set('data.slug', 'wilpattu-leopard-trail')
            ->set('data.theme', 'Wildlife')
            ->set('data.days', 4)
            ->set('data.pax.en', '2–8 pax')
            ->set('data.location.en', 'Wilpattu · Anuradhapura')
            ->set('data.blurb.en', 'Three drives in the island\'s largest park.')
            ->set('data.season.en', 'February to October.')
            ->set('data.itinerary', ['day-1' => ['title' => ['en' => 'Into the park'], 'body' => ['en' => 'Afternoon drive.'], 'open' => true]])
            ->call('create')
            ->assertHasNoErrors();

        $package = Package::query()->where('slug', 'wilpattu-leopard-trail')->firstOrFail();
        $this->assertSame('Inbound', $package->kind);
        $this->assertCount(8, $package->inclusions, 'new packages start with the default inclusions');
        $this->assertNotEmpty($package->itinerary[0]['key']);
        $this->assertSame(13, $package->sort_order);

        $this->get('/packages/wilpattu-leopard-trail')->assertOk()->assertSee('Into the park');
    }

    public function test_viewers_cannot_edit_packages(): void
    {
        $this->actingAs($this->admin(User::ROLE_VIEWER));

        $this->get('/admin/packages')->assertOk();
        $this->get('/admin/packages/'.$this->yala()->getKey().'/edit')->assertForbidden();
    }

    public function test_public_page_shows_translations_and_falls_back_to_english(): void
    {
        $this->bootWithLocale('hi');
        $yala = $this->yala();
        $yala->setTranslation('title', 'hi', 'याला और उदावलावे सफारी');
        $yala->save();

        $this->get('/hi/packages/yala-udawalawe-safari')
            ->assertOk()
            ->assertSee('याला और उदावलावे सफारी')
            ->assertSee('2–14 pax');

        $this->yala()->update(['is_published' => false]);
        $this->get('/packages/yala-udawalawe-safari')->assertNotFound();
    }
}
