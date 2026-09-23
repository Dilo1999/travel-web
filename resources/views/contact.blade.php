@extends('layouts.app')

@section('title', 'Contact — '.config('travel.brand.name'))
@section('description', 'Tell us who is travelling and we will send a written quote within one working day.')

@section('content')

<section class="px-4 pt-11 pb-6.5 sm:px-5">
    <div class="mx-auto max-w-[1400px]">
        <span class="section-kicker">Contact</span>
        <h1 class="mt-4 mb-3.5 text-[clamp(32px,4.4vw,60px)] leading-[1.02] tracking-[-.035em]">Tell us who is travelling</h1>
        <p class="max-w-[62ch] text-[16.5px] text-ink/60">One named coordinator answers every enquiry within a working day, in Colombo or from our India desk.</p>
    </div>
</section>

<section class="px-4 pb-16 sm:px-5">
    <div class="mx-auto grid max-w-[1400px] grid-cols-1 items-start gap-6 lg:grid-cols-[1.3fr_1fr]">

        <div class="glass-strong rounded-[30px] p-6 sm:p-10">
            @if (session('sent'))
                <div>
                    <div class="mb-5 grid h-[58px] w-[58px] place-items-center rounded-[20px] bg-accent text-2xl text-white shadow-[0_16px_34px_-14px_rgba(47,158,65,.8)]">✓</div>
                    <h3 class="mb-3 text-[28px] tracking-[-.025em]">Enquiry received</h3>
                    <p class="mb-2 text-[15px] leading-relaxed text-ink/60">
                        Reference <strong class="font-semibold text-ink">{{ session('reference') }}</strong>.
                        Nadeesha Perera will reply to {{ session('sentTo') }} within one working day.
                    </p>
                    <p class="mb-6.5 text-[14.5px] text-ink/60">Need it faster? Send the same reference on WhatsApp.</p>
                    <div class="flex flex-wrap gap-3">
                        <button type="button" data-wa-open class="btn btn-primary px-5.5 py-4 text-[13.5px]">WhatsApp us</button>
                        <a href="{{ route('contact') }}" class="btn btn-secondary px-5.5 py-4 text-[13.5px]">Send another</a>
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('contact.store') }}" novalidate>
                    @csrf
                    <div class="grid grid-cols-1 gap-4.5 sm:grid-cols-2">
                        <div>
                            <label class="field-label">Full name *</label>
                            <input class="field-input" name="name" value="{{ old('name') }}" placeholder="Your name">
                            @error('name') <div class="mt-1.5 text-[12.5px] text-[#c0392b]">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="field-label">Country</label>
                            <select class="field-input" name="country">
                                <option value="">Select country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country }}" @selected(old('country') === $country)>{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="field-label">Email</label>
                            <input class="field-input" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com">
                            @error('email') <div class="mt-1.5 text-[12.5px] text-[#c0392b]">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="field-label">WhatsApp number</label>
                            <div class="flex gap-2.5">
                                <select class="field-input w-[118px] shrink-0" name="dial">
                                    @foreach ($dialCodes as $code => $label)
                                        <option value="{{ $code }}" @selected(old('dial', '+91') === $code)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <input class="field-input min-w-0 flex-1" name="phone" value="{{ old('phone') }}" placeholder="98765 43210">
                            </div>
                            @error('phone') <div class="mt-1.5 text-[12.5px] text-[#c0392b]">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="field-label">Travellers *</label>
                            <input class="field-input" type="number" min="1" name="pax" value="{{ old('pax') }}" placeholder="2">
                            @error('pax') <div class="mt-1.5 text-[12.5px] text-[#c0392b]">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="field-label">Travel month</label>
                            <div class="flex gap-2.5">
                                <select class="field-input flex-1" name="month">
                                    <option value="">Month</option>
                                    @foreach (['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                                        <option value="{{ $m }}" @selected(old('month') === $m)>{{ $m }}</option>
                                    @endforeach
                                </select>
                                <select class="field-input flex-1" name="year">
                                    <option value="">Year</option>
                                    @foreach ([2026, 2027, 2028, 2029] as $y)
                                        <option value="{{ $y }}" @selected(old('year') == $y)>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5.5">
                        <label class="mb-2.5 block text-xs text-ink/60">What are you looking for? *</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($interests as $interest)
                                <label class="chip chip-inactive has-checked:border-accent has-checked:bg-accent has-checked:text-white">
                                    <input type="radio" name="interest" value="{{ $interest }}" class="hidden" @checked(old('interest', $prefillInterest) === $interest)>
                                    {{ $interest }}
                                </label>
                            @endforeach
                        </div>
                        @error('interest') <div class="mt-2 text-[12.5px] text-[#c0392b]">{{ $message }}</div> @enderror
                    </div>

                    <div class="mt-5.5">
                        <label class="field-label">Anything we should plan around?</label>
                        <textarea class="field-input min-h-[104px]" name="message" placeholder="Anniversary trip, elders in the group, diving certification, fixed dates…">{{ old('message', $prefillMessage) }}</textarea>
                    </div>

                    <div class="mt-6.5 flex flex-wrap items-center gap-4">
                        <button type="submit" class="btn btn-primary px-7 py-4.5 text-sm">Send enquiry</button>
                        <button type="button" data-wa-open class="btn btn-secondary px-6.5 py-4.5 text-sm">WhatsApp us</button>
                    </div>

                    @if ($errors->any())
                        <p class="mt-4 text-[13.5px] text-[#c0392b]">Please correct the highlighted fields.</p>
                    @endif
                </form>
            @endif
        </div>

        <div class="flex flex-col gap-4.5">
            <div class="glass rounded-[26px] p-6.5">
                <div class="mb-4 text-[11.5px] font-semibold tracking-[0.12em] text-accent-700 uppercase">Our desks</div>
                <div class="flex flex-col gap-3">
                    @foreach ($contacts as $contact)
                        <div class="flex items-center gap-3.5 rounded-2xl bg-white/60 px-4 py-3.5">
                            <span class="grid h-9.5 w-9.5 shrink-0 place-items-center rounded-xl bg-accent-100 text-xs font-semibold text-accent-800" style="font-family:var(--font-heading)">{{ $contact['cc'] }}</span>
                            <span class="flex-1">
                                <span class="block text-sm font-bold">{{ $contact['name'] }}</span>
                                <span class="block text-[12.5px] text-ink/45">{{ $contact['role'] }} · {{ $contact['country'] }}</span>
                            </span>
                            <span class="text-[13px] font-semibold whitespace-nowrap">{{ $contact['number'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="glass rounded-[26px] p-6.5">
                <div class="mb-3.5 text-[11.5px] font-semibold tracking-[0.12em] text-accent-700 uppercase">Colombo office</div>
                <p class="mb-3.5 text-[14.5px] leading-relaxed">{!! nl2br(e(config('travel.brand.address'))) !!}</p>
                <div class="flex justify-between gap-3.5 text-sm"><span class="text-ink/45">Email</span><strong class="text-right">{{ config('travel.brand.email') }}</strong></div>
                <div class="mt-2 flex justify-between gap-3.5 text-sm"><span class="text-ink/45">Mon – Sat</span><strong class="text-right">08:30 – 19:00 IST</strong></div>
            </div>
            <div class="h-[230px] rounded-[26px] bg-[#dfe5de] bg-cover bg-center shadow-glass" style="background-image:url('{{ travel_img('niooffice3', 900, 700) }}')"></div>
        </div>
    </div>
</section>

@endsection
