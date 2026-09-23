<div class="fixed right-4 bottom-24 z-[70] flex flex-col items-end gap-3 sm:right-6 lg:bottom-6">

    <div data-wa-panel class="hidden w-[min(340px,calc(100vw-32px))] animate-pop-in glass-strong rounded-[26px] p-5">
        <div class="mb-4 flex items-start gap-3">
            <div class="flex-1">
                <div class="text-[17px] font-semibold" style="font-family:var(--font-heading)">{{ __('site.whatsapp.heading') }}</div>
                <div class="mt-1 text-[12.5px] text-ink/45">{{ __('site.whatsapp.subheading') }}</div>
            </div>
            <button data-wa-close type="button" aria-label="{{ __('site.whatsapp.close') }}" class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-black/5 text-[13px] text-ink/60">✕</button>
        </div>

        <div class="flex flex-col gap-2.5">
            @foreach (config('travel.contacts') as $contact)
                <a href="{{ whatsapp_link($contact['number']) }}" target="_blank" rel="noopener"
                   class="flex items-center gap-3 rounded-2xl border border-white/80 bg-white/72 p-3.5 transition hover:-translate-y-0.5 hover:bg-white">
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-accent-100 text-[11.5px] font-semibold text-accent-800" style="font-family:var(--font-heading)">
                        {{ $contact['cc'] }}
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-[13.5px] font-bold">{{ $contact['name'] }}</span>
                        <span class="block text-[11.5px] text-ink/45">{{ travel_t($contact['role']) }} · {{ travel_t($contact['country']) }}</span>
                        <span class="mt-0.5 block text-[12px] font-semibold text-accent-700">{{ $contact['number'] }}</span>
                    </span>
                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-accent">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="#fff"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.46 1.32 4.97L2 22l5.27-1.38a9.87 9.87 0 0 0 4.77 1.22c5.46 0 9.91-4.45 9.91-9.91C21.96 6.45 17.5 2 12.04 2Z"/></svg>
                    </span>
                </a>
            @endforeach
        </div>

        <p class="mt-3.5 text-[11.5px] text-ink/45">{{ travel_t(config('travel.brand.hours')) }}</p>
    </div>

    <button data-wa-toggle type="button" aria-label="{{ __('site.whatsapp.toggle_aria') }}" aria-expanded="false"
            class="grid h-[60px] w-[60px] animate-wa-pulse place-items-center rounded-full bg-accent text-white shadow-[0_18px_40px_-14px_rgba(47,158,65,.95)] transition hover:scale-105">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.46 1.32 4.97L2 22l5.27-1.38a9.87 9.87 0 0 0 4.77 1.22h.01c5.46 0 9.91-4.45 9.91-9.91C21.96 6.45 17.5 2 12.04 2Zm0 18.13h-.01c-1.5 0-2.98-.4-4.27-1.17l-.31-.18-3.17.83.85-3.09-.2-.32a8.19 8.19 0 0 1-1.26-4.37c0-4.53 3.7-8.22 8.24-8.22 2.2 0 4.26.86 5.82 2.41a8.16 8.16 0 0 1 2.41 5.82c0 4.54-3.7 8.23-8.24 8.23Zm5.43-5.75c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.27-.47-2.42-1.49-.9-.8-1.5-1.79-1.67-2.09-.17-.3-.02-.46.13-.61.15-.15.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.5h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.01-1.04 2.47s1.06 2.87 1.21 3.07c.15.2 2.09 3.33 5.07 4.54 2.98 1.21 3.32.97 3.92.91.6-.05 1.92-.78 2.19-1.54.27-.76.27-1.41.19-1.54-.08-.13-.28-.2-.58-.35Z"/></svg>
    </button>
</div>
