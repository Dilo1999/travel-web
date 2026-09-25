{{--
    Package form language switch (PackageResource). Every language's fields stay in the form so
    they are all saved; these rules hide the grid cells of the languages not being edited, and the
    shared (language-neutral) fields while a translation is being edited.
--}}
<style>
    @foreach (array_keys(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales()) as $code)
        [data-active-locale="{{ $code }}"] .filament-forms-component-container > div:has(> [data-content-locale]:not([data-content-locale="{{ $code }}"])) { display: none !important; }
    @endforeach
    [data-active-locale]:not([data-active-locale="en"]) .filament-forms-component-container > div:has(> [data-locale-shared]) { display: none !important; }

    .pkg-locale-bar { position: sticky; top: 4.5rem; z-index: 20; margin-bottom: 1.5rem; padding: .75rem 1rem; border: 1px solid #e5e7eb; border-radius: 1rem; background: rgba(255, 255, 255, .92); backdrop-filter: blur(8px); box-shadow: 0 1px 2px rgba(0, 0, 0, .04); }
    .pkg-locale-bar__row { display: flex; flex-wrap: wrap; align-items: center; gap: .75rem; }
    .pkg-locale-bar__label { font-size: .75rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: #6b7280; }
    .pkg-locale-bar__note { margin-top: .6rem; font-size: .85rem; line-height: 1.45; color: #4b5563; }
    .pkg-locale-bar__spinner { width: 1.1rem; height: 1.1rem; color: #6b7280; animation: pkg-spin .8s linear infinite; }
    @keyframes pkg-spin { to { transform: rotate(360deg); } }

    .pkg-locale-switch { display: inline-flex; gap: .125rem; padding: .25rem; border: 1px solid #e5e7eb; border-radius: 9999px; background: #f3f4f6; }
    .pkg-locale-switch__option { display: inline-flex; align-items: center; gap: .4rem; padding: .4rem .95rem; border-radius: 9999px; font-size: .85rem; font-weight: 600; color: #4b5563; white-space: nowrap; transition: background-color .15s, color .15s; }
    .pkg-locale-switch__option:hover { color: #111827; background: rgba(255, 255, 255, .6); }
    .pkg-locale-switch__option.is-active { color: #111827; background: #fff; box-shadow: 0 1px 3px rgba(0, 0, 0, .12); }
    .pkg-locale-switch__option:disabled { cursor: wait; }
    .pkg-locale-switch__badge { min-width: 1.25rem; padding: 0 .35rem; border-radius: 9999px; font-size: .7rem; line-height: 1.25rem; text-align: center; color: #15803d; background: #dcfce7; }
    .pkg-locale-switch__badge.is-pending { color: #92400e; background: #fef3c7; }

    @media (max-width: 640px) {
        .pkg-locale-bar { top: 4rem; }
        .pkg-locale-switch__option { padding: .4rem .7rem; }
    }
</style>
