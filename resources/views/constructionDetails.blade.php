@extends('layouts.app')

@section('title', 'Construction Details | Diamond Group')

{{-- Needs @stack('head') inside <head> of layouts/app.blade.php --}}
@push('head')
<style>
    .js-loading #construction-hero .hero-img { transform: scale(1.25); filter: blur(8px); }
    .js-loading #construction-hero .hero-badge,
    .js-loading #construction-hero .hero-title,
    .js-loading #construction-hero .hero-description,
    .js-loading #construction-hero .hero-buttons { opacity: 0; }

    @keyframes construction-ring {
        0%   { box-shadow: 0 0 0 0 rgba(34, 211, 238, .55); }
        100% { box-shadow: 0 0 0 16px rgba(34, 211, 238, 0); }
    }
    .cta-pulse { animation: construction-ring 2s ease-out infinite; }
    @media (prefers-reduced-motion: reduce) { .cta-pulse { animation: none; } }
</style>
@endpush

@section('content')

{{-- =====================================================
    1. HERO
===================================================== --}}
<section id="construction-hero" class="relative isolate overflow-hidden bg-slate-950 text-white">

    <div class="absolute inset-0 -z-20 overflow-hidden">
        <img
            src="{{ !empty($setting->header_image)
                ? asset('storage/' . $setting->header_image)
                : asset('assets/images/aboutushero.png') }}"
            alt="Diamond Group construction services"
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
                    {{ $setting->header_badge ?? 'Construction Services' }}
                </p>
            </div>

            <h1 class="hero-title text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                {{ $setting->header_title_part_1 ?? 'Building with confidence' }}
                <span class="text-cyan-400">{{ $setting->header_title_part_2 ?? 'from the ground up.' }}</span>
            </h1>

            <p class="hero-description mt-6 max-w-xl text-base leading-8 text-slate-100 sm:text-lg">
                {{ $setting->header_description ?? 'Diamond Group provides dependable construction materials and practical project support for stronger communities.' }}
            </p>

            <div class="hero-buttons mt-9 flex flex-wrap gap-4">
                <a href="{{ route('contracts') }}"
                   class="cta-pulse inline-flex items-center gap-3 rounded-full bg-cyan-400 px-7 py-3.5 font-bold text-slate-950 transition duration-300 hover:bg-cyan-300 focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-slate-950">
                    Contact Us
                    <span aria-hidden="true">&rarr;</span>
                </a>
                <a href="#construction-section-1"
                   class="inline-flex items-center rounded-full border border-white/40 px-7 py-3.5 font-semibold text-white transition duration-300 hover:border-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/60">
                    See our services
                </a>
            </div>
        </div>
    </div>
</section>


{{-- =====================================================
    2. SERVICE SECTIONS
===================================================== --}}
@foreach ($serviceSections as $serviceSection)
    <section
        id="construction-section-{{ $loop->iteration }}"
        data-service-section
        class="relative overflow-hidden px-6 py-20 sm:py-28 {{ $loop->odd ? 'bg-slate-50' : 'bg-white' }}"
    >
        <div class="mx-auto max-w-7xl">
            <div class="grid items-center gap-12 lg:grid-cols-5 lg:gap-20">

                {{-- Image --}}
                <div class="service-image order-1 lg:col-span-2 {{ $loop->even ? 'lg:order-2' : 'lg:order-1' }}">
                    <div class="relative mx-auto max-w-md">

                        <div class="service-frame absolute top-5 -bottom-5 rounded-[2rem] border-2 border-cyan-400/60
                                    {{ $loop->even ? 'left-5 -right-5' : '-left-5 right-5' }}"
                                    aria-hidden="true"></div>

                        <div class="service-mask relative aspect-[4/5] w-full overflow-hidden rounded-3xl bg-slate-200 shadow-2xl">
                            <img
                                src="{{ !empty($serviceSection->image)
                                    ? asset('storage/' . $serviceSection->image)
                                    : asset('assets/images/company-building.jpg') }}"
                                alt="{{ $serviceSection->title }}"
                                loading="lazy"
                                class="service-img h-full w-full object-cover object-center"
                            >
                            <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-slate-950/60 to-transparent"></div>

                            @if (!empty($serviceSection->badge))
                                <span class="service-chip absolute bottom-5 left-5 z-10 rounded-full bg-cyan-400 px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-950">
                                    {{ $serviceSection->badge }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="service-content order-2 lg:col-span-3 {{ $loop->even ? 'lg:order-1' : 'lg:order-2' }}">

                    <div class="sc-item mb-5 flex items-center gap-3">
                        <span class="sc-line h-1 w-10 origin-left rounded-full bg-cyan-500"></span>
                        <p class="text-sm font-bold uppercase tracking-[0.18em] text-cyan-700">
                            {{ $serviceSection->badge }}
                        </p>
                    </div>

                    <h2 class="sc-item text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl">
                        {{ $serviceSection->title }}
                    </h2>

                    <p class="sc-item mt-4 text-base font-semibold text-cyan-700 sm:text-lg">
                        {{ $serviceSection->subtitle }}
                    </p>

                    <div class="mt-7 max-w-2xl space-y-5 leading-8 text-slate-600">
                        <p class="sc-item">{{ $serviceSection->description_1 }}</p>
                        <p class="sc-item">{{ $serviceSection->description_2 }}</p>
                    </div>

                    <a href="{{ route('contracts') }}"
                       class="sc-item mt-9 inline-flex items-center gap-2 rounded-full bg-slate-900 px-7 py-3.5 font-bold text-white transition duration-300 hover:-translate-y-1 hover:bg-cyan-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                        Contact Us
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>

            </div>
        </div>
    </section>
@endforeach

@endsection


@push('scripts')
{{-- Load GSAP + ScrollTrigger + SplitType --}}
<script src="https://cdn.jsdelivr.net/npm/gsap@3.14.2/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.14.2/dist/ScrollTrigger.min.js"></script>
<script src="https://unpkg.com/split-type@0.3.4/umd/index.min.js"></script>

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
    const hero = document.querySelector('#construction-hero');
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

    /* ---------- SERVICE SECTIONS ---------- */
    document.querySelectorAll('[data-service-section]').forEach((section, index) => {
        const reversed = index % 2 === 1;
        const mask  = section.querySelector('.service-mask');
        const img   = section.querySelector('.service-img');
        const frame = section.querySelector('.service-frame');
        const chip  = section.querySelector('.service-chip');
        const items = section.querySelectorAll('.sc-item');
        const line  = section.querySelector('.sc-line');

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

    unlock();

    window.addEventListener('load', () => ScrollTrigger.refresh());
    window.addEventListener('resize', () => ScrollTrigger.refresh());
});
</script>
@endpush