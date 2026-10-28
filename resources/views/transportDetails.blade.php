@extends('layouts.app')

@section('title', 'Truck Details | Diamond Group')

{{-- Needs @stack('head') inside <head> of layouts/app.blade.php --}}
@push('head')
<style>
    .js-loading #truck-hero .hero-img { transform: scale(1.25); filter: blur(8px); }
    .js-loading #truck-hero .hero-badge,
    .js-loading #truck-hero .hero-title,
    .js-loading #truck-hero .hero-description,
    .js-loading #truck-hero .hero-buttons { opacity: 0; }

    @keyframes truck-ring {
        0%   { box-shadow: 0 0 0 0 rgba(34, 211, 238, .55); }
        100% { box-shadow: 0 0 0 16px rgba(34, 211, 238, 0); }
    }
    .cta-pulse { animation: truck-ring 2s ease-out infinite; }
    @media (prefers-reduced-motion: reduce) { .cta-pulse { animation: none; } }
</style>
@endpush

@section('content')

{{-- =====================================================
    1. HERO
===================================================== --}}
<section id="truck-hero" class="relative isolate overflow-hidden bg-slate-950 text-white">

    <div class="absolute inset-0 -z-20 overflow-hidden">
        <img
            src="{{ !empty($setting->header_image)
                ? asset('storage/' . $setting->header_image)
                : asset('assets/images/transport.jpg') }}"
            alt="Diamond Group transport and logistics"
            class="hero-img absolute inset-x-0 -top-[10%] h-[120%] w-full object-cover object-center"
        >
    </div>

    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-slate-950/90 via-slate-950/70 to-slate-950/20"></div>
    <div class="absolute inset-x-0 bottom-0 -z-10 h-40 bg-gradient-to-t from-slate-950/80 to-transparent"></div>

    <div class="mx-auto max-w-6xl px-6 py-24 sm:py-28 lg:py-32">
        <div class="max-w-2xl">

            <div class="hero-badge mb-5 flex items-center gap-3">
                <span class="h-1 w-10 rounded-full bg-cyan-400"></span>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-cyan-300">
                    {{ $setting->header_badge ?? 'Transport Services' }}
                </p>
            </div>

            <h1 class="hero-title text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                {{ $setting->header_title_part_1 ?? 'Reliable transport solutions' }}
                <span class="text-cyan-400">{{ $setting->header_title_part_2 ?? 'for your business.' }}</span>
            </h1>

            <p class="hero-description mt-6 max-w-xl text-base leading-8 text-slate-100 sm:text-lg">
                {{ $setting->header_description ?? 'Diamond Group provides practical transport solutions to help businesses move goods and materials efficiently.' }}
            </p>

            <div class="hero-buttons mt-9 flex flex-wrap gap-4">
                <a href="{{ route('contracts') }}"
                   class="cta-pulse inline-flex items-center gap-3 rounded-full bg-cyan-400 px-7 py-3.5 font-bold text-slate-950 transition duration-300 hover:bg-cyan-300 focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-slate-950">
                    Contact Us
                    <span aria-hidden="true">&rarr;</span>
                </a>
                <a href="#vehicle-section-1"
                   class="inline-flex items-center rounded-full border border-white/40 px-7 py-3.5 font-semibold text-white transition duration-300 hover:border-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/60">
                    See our vehicles
                </a>
            </div>
        </div>
    </div>
</section>


{{-- =====================================================
    2. VEHICLE SECTIONS
===================================================== --}}
@foreach ($vehicleSections as $vehicleSection)
    <section
        id="vehicle-section-{{ $loop->iteration }}"
        data-vehicle-section
        class="relative overflow-hidden px-6 py-20 sm:py-28 {{ $loop->odd ? 'bg-slate-50' : 'bg-white' }}"
    >
        <div class="mx-auto max-w-7xl">
            <div class="grid items-center gap-12 lg:grid-cols-5 lg:gap-20">

                {{-- Image --}}
                <div class="vehicle-image order-1 lg:col-span-2 {{ $loop->even ? 'lg:order-2' : 'lg:order-1' }}">
                    <div class="relative mx-auto max-w-md">

                        <div class="vehicle-frame absolute top-5 -bottom-5 rounded-[2rem] border-2 border-cyan-400/60
                                    {{ $loop->even ? 'left-5 -right-5' : '-left-5 right-5' }}"
                                    aria-hidden="true"></div>

                        <div class="vehicle-mask relative aspect-[4/5] w-full overflow-hidden rounded-3xl bg-slate-200 shadow-2xl">
                            <img
                                src="{{ !empty($vehicleSection->image)
                                    ? asset('storage/' . $vehicleSection->image)
                                    : asset('assets/images/minitruck.png') }}"
                                alt="{{ $vehicleSection->title }}"
                                loading="lazy"
                                class="vehicle-img h-full w-full object-cover object-center"
                            >
                            <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-slate-950/60 to-transparent"></div>

                            @if (!empty($vehicleSection->badge))
                                <span class="vehicle-chip absolute bottom-5 left-5 z-10 rounded-full bg-cyan-400 px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-950">
                                    {{ $vehicleSection->badge }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="vehicle-content order-2 lg:col-span-3 {{ $loop->even ? 'lg:order-1' : 'lg:order-2' }}">

                    <div class="vc-item mb-5 flex items-center gap-3">
                        <span class="vc-line h-1 w-10 origin-left rounded-full bg-cyan-500"></span>
                        <p class="text-sm font-bold uppercase tracking-[0.18em] text-cyan-700">
                            {{ $vehicleSection->badge }}
                        </p>
                    </div>

                    <h2 class="vc-item text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl">
                        {{ $vehicleSection->title }}
                    </h2>

                    <p class="vc-item mt-4 text-base font-semibold text-cyan-700 sm:text-lg">
                        {{ $vehicleSection->subtitle }}
                    </p>

                    <div class="mt-7 max-w-2xl space-y-5 leading-8 text-slate-600">
                        <p class="vc-item">{{ $vehicleSection->description_1 }}</p>
                        <p class="vc-item">{{ $vehicleSection->description_2 }}</p>
                    </div>

                    <a href="{{ route('contracts') }}"
                       class="vc-item mt-9 inline-flex items-center gap-2 rounded-full bg-slate-900 px-7 py-3.5 font-bold text-white transition duration-300 hover:-translate-y-1 hover:bg-cyan-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                        Contact Us
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>

            </div>
        </div>
    </section>
@endforeach


{{-- =====================================================
    3. CLOSING CTA
===================================================== --}}
{{-- <section id="truck-cta" class="relative isolate overflow-hidden bg-slate-950 px-6 py-20 text-center text-white sm:py-24">
    <div class="absolute -top-24 left-1/2 -z-10 h-72 w-72 -translate-x-1/2 rounded-full bg-cyan-500/20 blur-3xl" aria-hidden="true"></div>
    <div class="mx-auto max-w-3xl">
        <h2 class="cta-item text-3xl font-bold tracking-tight sm:text-4xl">
            Need the right vehicle for your next job?
        </h2>
        <p class="cta-item mx-auto mt-5 max-w-xl leading-8 text-slate-300">
            Tell us what you need to move and when. We will recommend the best fit and get you a quote.
        </p>
        <a href="{{ route('contracts') }}"
           class="cta-item cta-pulse mt-9 inline-flex items-center gap-3 rounded-full bg-cyan-400 px-8 py-4 font-bold text-slate-950 transition duration-300 hover:bg-cyan-300 focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-slate-950">
            Request a quote
            <span aria-hidden="true">&rarr;</span>
        </a>
    </div>
</section> --}}

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const unlock = () => {
        document.documentElement.classList.remove('js-loading');
        clearTimeout(window.__jsLoadingTimeout);
    };

    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce || typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
        return unlock();
    }

    gsap.registerPlugin(ScrollTrigger);

    /* ---------- HERO ---------- */
    const hero = document.querySelector('#truck-hero');
    if (hero) {
        const bg    = hero.querySelector('.hero-img');
        const badge = hero.querySelector('.hero-badge');
        const title = hero.querySelector('.hero-title');
        const desc  = hero.querySelector('.hero-description');
        const btns  = hero.querySelector('.hero-buttons');

        gsap.set(bg, { scale: 1.25, filter: 'blur(8px)' });
        gsap.to(bg, { scale: 1, filter: 'blur(0px)', duration: 2.2, ease: 'power3.out' });

        if (typeof SplitType !== 'undefined' && title) {
            const split = new SplitType(title, { types: 'words,chars' });
            gsap.set(title, { opacity: 1 });
            gsap.from(split.chars, {
                y: 80, opacity: 0, rotateX: -90,
                duration: 1, stagger: 0.02, ease: 'back.out(1.7)', delay: 0.3
            });
        } else if (title) {
            gsap.fromTo(title, { y: 45, opacity: 0 }, { y: 0, opacity: 1, duration: 1, delay: 0.3 });
        }

        const tl = gsap.timeline({ delay: 0.1, defaults: { ease: 'power3.out' } });
        tl.fromTo(badge, { y: 20, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8 })
          .fromTo(desc,  { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8 }, '-=0.4')
          .fromTo(btns.children, { y: 30, opacity: 0, scale: 0.92 },
                      { y: 0, opacity: 1, scale: 1, duration: 0.7, stagger: 0.15, ease: 'back.out(1.7)' }, '-=0.4');
        gsap.set(btns, { opacity: 1 });

        gsap.to(bg, {
            yPercent: 7, ease: 'none',
            scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true }
        });
    }

    /* ---------- VEHICLE SECTIONS ---------- */
    document.querySelectorAll('[data-vehicle-section]').forEach((section, index) => {
        const reversed = index % 2 === 1;
        const mask  = section.querySelector('.vehicle-mask');
        const img   = section.querySelector('.vehicle-img');
        const frame = section.querySelector('.vehicle-frame');
        const chip  = section.querySelector('.vehicle-chip');
        const items = section.querySelectorAll('.vc-item');
        const line  = section.querySelector('.vc-line');

        if (mask) gsap.set(mask, { clipPath: 'inset(0% 0% 0% 0%)' });

        const tl = gsap.timeline({
            defaults: { ease: 'power3.out' },
            scrollTrigger: { trigger: section, start: 'top 80%', toggleActions: 'play none none reverse' }
        });

        if (mask && img) {
            tl.fromTo(mask,
                { clipPath: reversed ? 'inset(0 0 0 100%)' : 'inset(0 100% 0 0)' },
                { clipPath: 'inset(0% 0% 0% 0%)', duration: 1.2, ease: 'power4.inOut', clearProps: 'clipPath' }, 0)
              .from(img, { scale: 1.2, duration: 1.5 }, 0);
        }

        if (frame) tl.from(frame, { opacity: 0, scale: 0.94, duration: 0.9 }, 0.4);
        if (chip) tl.from(chip, { y: 20, opacity: 0, duration: 0.6 }, 0.8);

        if (items.length > 0) {
            tl.from(items, {
                x: reversed ? -40 : 40, opacity: 0,
                duration: 0.8, stagger: 0.1, clearProps: 'transform,opacity'
            }, 0.2);
        }

        if (line) tl.from(line, { scaleX: 0, duration: 0.6 }, 0.4);

        if (img) {
            gsap.fromTo(img, { yPercent: -5 }, {
                yPercent: 5, ease: 'none',
                scrollTrigger: { trigger: section, start: 'top bottom', end: 'bottom top', scrub: true }
            });
        }
    });

    /* ---------- CLOSING CTA ---------- */
    const cta = document.querySelector('#truck-cta');
    if (cta) {
        gsap.from(cta.querySelectorAll('.cta-item'), {
            y: 40, opacity: 0, duration: 0.9, stagger: 0.15, ease: 'power3.out',
            clearProps: 'transform',
            scrollTrigger: { trigger: cta, start: 'top 80%', toggleActions: 'play none none reverse' }
        });
    }

    unlock();

    window.addEventListener('load', () => ScrollTrigger.refresh());
    window.addEventListener('resize', () => ScrollTrigger.refresh());
});
</script>
@endpush