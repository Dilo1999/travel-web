<?php

namespace App\Filament\Pages;

use Anthropic\Core\Exceptions\APIException;
use App\Services\ClaudeTranslator;
use App\Services\PackageTranslations;
use App\Services\SiteTranslations;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use RuntimeException;

/**
 * One button that translates all of the site's English into every other locale with Claude
 * and saves it to the translations table, then fills in package text that is missing or
 * outdated (packages keep their translations on the package itself; see PackageTranslations). The browser drives the run one batch (one API
 * request) at a time, so no single request runs long enough to hit a server timeout.
 */
class Translator extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-translate';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 90;

    protected static string $view = 'filament.pages.translator';

    public bool $running = false;

    public ?string $startedAt = null;

    /** @var list<string> strings that failed in this run and are not retried until the next one */
    public array $skipped = [];

    /** @var list<string> "package id|locale" pairs that failed in this run */
    public array $skippedPackages = [];

    /** Package texts that needed translating when the run started. */
    public int $packagesAtStart = 0;

    public int $total = 0;

    public int $done = 0;

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $this->authorizeAdmin();
    }

    protected function getActions(): array
    {
        return [
            Action::make('translate')
                ->label('Translate website')
                ->icon('heroicon-o-translate')
                ->disabled(fn () => $this->running)
                ->requiresConfirmation()
                ->modalHeading('Translate the website')
                ->modalSubheading(fn () => 'All '.count(app(SiteTranslations::class)->strings()).' strings of English text will be translated into '
                    .implode(' and ', app(SiteTranslations::class)->targetLocales())
                    .' with the Claude API and saved, replacing the current translations. Package text is then translated where it is missing or its English has changed; package translations edited by hand are kept. This uses API credit and takes a few minutes. Keep this page open until it finishes.')
                ->modalButton('Translate')
                ->action(fn () => $this->start()),
        ];
    }

    protected function getViewData(): array
    {
        return [
            'status' => $this->running ? [] : app(SiteTranslations::class)->status(),
            'packageStatus' => $this->running ? [] : app(PackageTranslations::class)->status(),
        ];
    }

    public function start(): void
    {
        $this->authorizeAdmin();

        $this->startedAt = now()->startOfSecond()->toDateTimeString();
        $this->skipped = [];
        $this->skippedPackages = [];
        $this->packagesAtStart = app(PackageTranslations::class)->pendingCount();
        $this->running = true;
        $this->updateProgress();

        // The view listens for this and keeps calling step() until it returns false.
        $this->dispatchBrowserEvent('translator-run');
    }

    /**
     * Translate and save the next batch. Returns whether there is more to do.
     */
    public function step(): bool
    {
        $this->authorizeAdmin();

        if (! $this->running) {
            return false;
        }

        set_time_limit(0);
        $translations = app(SiteTranslations::class);

        try {
            $saved = $translations->translateNext(Carbon::parse($this->startedAt), $this->skipped);
        } catch (RuntimeException|APIException $e) {
            $this->running = false;

            Notification::make()
                ->danger()
                ->title('Translation stopped')
                ->body(ClaudeTranslator::describeError($e).' Everything translated before this was saved.')
                ->persistent()
                ->send();

            return false;
        }

        if ($saved === null && ! $this->translateNextPackage()) {
            // Not running any more means a package request failed and has already been reported.
            if ($this->running) {
                $this->finish($translations);
            }

            return false;
        }

        $this->updateProgress();

        return true;
    }

    /**
     * Once the site strings are done, one package and language per step. Returns whether there was one.
     */
    private function translateNextPackage(): bool
    {
        $packages = app(PackageTranslations::class);
        $next = $packages->next($this->skippedPackages);

        if (! $next) {
            return false;
        }

        [$package, $locale] = $next;

        try {
            $result = $packages->translateLocale($package, $locale);
        } catch (RuntimeException|APIException $e) {
            $this->running = false;

            Notification::make()
                ->danger()
                ->title('Translation stopped')
                ->body(ClaudeTranslator::describeError($e).' Everything translated before this was saved.')
                ->persistent()
                ->send();

            return false;
        }

        if ($result['failed']) {
            $this->skippedPackages[] = "{$package->id}|{$locale}";
            array_push($this->skipped, ...array_keys($result['failed']));
        }

        return true;
    }

    private function finish(SiteTranslations $translations): void
    {
        $translations->removeStale();
        $this->running = false;
        $this->updateProgress();

        if ($this->skipped) {
            Notification::make()
                ->warning()
                ->title("Translated {$this->done} strings; ".count($this->skipped).' could not be translated')
                ->body('Those show in English for now. Translating the website again will retry them.')
                ->persistent()
                ->send();

            return;
        }

        Notification::make()
            ->success()
            ->title('Website translated')
            ->body("{$this->done} strings were translated and saved. The website is showing them now.")
            ->persistent()
            ->send();
    }

    private function updateProgress(): void
    {
        $translations = app(SiteTranslations::class);
        $packagesLeft = min($this->packagesAtStart, app(PackageTranslations::class)->pendingCount($this->skippedPackages));
        $this->total = count($translations->strings()) + $this->packagesAtStart;
        $this->done = $this->total - count($translations->remaining(Carbon::parse($this->startedAt))) - $packagesLeft;
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
    }
}
