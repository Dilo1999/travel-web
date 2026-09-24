<?php

namespace App\Translation;

use App\Models\Translation;
use Illuminate\Contracts\Translation\Loader;
use Illuminate\Support\Arr;

/**
 * Laravel's file loader with the translations table layered on top, so __('site.nav.home')
 * and travel_t() read the translations saved by the admin Translator page.
 */
class DatabaseLoader implements Loader
{
    public function __construct(private Loader $files)
    {
    }

    public function load($locale, $group, $namespace = null)
    {
        $lines = $this->files->load($locale, $group, $namespace);

        // Package namespaces (e.g. filament::) only ever come from files.
        if ($namespace !== null && $namespace !== '*') {
            return $lines;
        }

        $translations = Translation::lines($locale, $group);

        if ($group === Translation::CONTENT) {
            return array_merge($lines, $translations);
        }

        return array_replace_recursive($lines, Arr::undot($translations));
    }

    public function addNamespace($namespace, $hint)
    {
        $this->files->addNamespace($namespace, $hint);
    }

    public function addJsonPath($path)
    {
        $this->files->addJsonPath($path);
    }

    public function namespaces()
    {
        return $this->files->namespaces();
    }
}
