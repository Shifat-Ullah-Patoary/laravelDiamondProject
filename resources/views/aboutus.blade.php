@extends('layouts.app')

@section('title', 'About Diamond Group')

@section('content')

{{-- =====================================================
1. HERO SECTION
===================================================== --}}
<section id="about-hero" class="relative isolate overflow-hidden bg-slate-950 text-white">

    <div class="absolute inset-0 -z-20 overflow-hidden">
        <img
            src="{{ !empty($setting->hero_bg_image) ? asset('storage/' . $setting->hero_bg_image) : asset('assets/images/aboutushero.png') }}"
            alt="Diamond Group transport and logistics"
            class="hero-img absolute inset-x-0 -top-[10%] h-[120%] w-full object-cover object-center"
        >
    </div>

    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-slate-950/90 via-slate-950/70 to-slate-950/20"></div>

    <div class="relative z-10 mx-auto max-w-6xl px-6 py-24 sm:py-28 lg:py-30">
        <div class="max-w-2xl">

            <div class="hero-badge mb-5 flex items-center gap-3">
                <span class="h-1 w-10 rounded-full bg-cyan-400"></span>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-cyan-300">
                    {{ $setting->hero_badge ?? 'About Diamond Group' }}
                </p>
            </div>

            <h1 class="hero-title text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                {{ $setting->hero_title_part_1 ?? 'Building connections' }}
                <span class="text-cyan-400">{{ $setting->hero_title_part_2 ?? 'and stronger communities.' }}</span>
            </h1>

            <p class="hero-desc mt-6 max-w-xl text-base leading-8 text-slate-50 sm:text-lg">
                {{ $setting->hero_description ?? 'Diamond Group brings travel, transport, and construction supply services together to help people and businesses move forward.' }}
            </p>

            <div class="hero-btns mt-9 flex flex-wrap gap-4">
                <a href="{{ route('contracts') }}"
                   class="inline-flex items-center gap-3 rounded-full bg-cyan-400 px-7 py-3.5 font-bold text-slate-950 transition hover:bg-cyan-300 focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-slate-950">
                    Contact Us
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</section>


{{-- =====================================================
     2. COMPANY INTRODUCTION AND MISSION
===================================================== --}}
<section class="bg-white px-6 py-16 sm:py-24">
    <div class="mx-auto max-w-7xl">

        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">

            {{-- Company introduction --}}
            <div>
                <div class="mb-5 flex items-center gap-3">
                    <span class="h-1 w-10 rounded-full bg-cyan-500"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-cyan-700">
                        {{ $setting->story_badge ?? 'Our Story' }}
                    </p>
                </div>

                <h2 class="max-w-xl text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    {{ $setting->story_title ?? 'One group. Multiple ways to help.' }}
                </h2>

                <p class="mt-6 leading-8 text-slate-600">
                    {{ $setting->story_description ?? 'Diamond Group brings together different services to meet the evolving needs of individuals and businesses. From planning memorable journeys to delivering goods and supplying construction materials, we focus on dependable service and lasting relationships.' }}
                </p>

                <ul class="mt-8 space-y-5">
                    @if(!empty($setting->story_features) && is_array($setting->story_features))
                        @foreach($setting->story_features as $feature)
                            <li class="flex items-start gap-4">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-cyan-500 text-sm font-bold text-white">
                                    &#10003;
                                </span>
                                <div>
                                    <h3 class="font-semibold text-slate-900">
                                        {{ $feature['title'] ?? '' }}
                                    </h3>
                                    <p class="mt-1 text-sm leading-6 text-slate-600">
                                        {{ $feature['description'] ?? '' }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    @else
                        {{-- Default fallback features --}}
                        <li class="flex items-start gap-4">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-cyan-500 text-sm font-bold text-white">&#10003;</span>
                            <div>
                                <h3 class="font-semibold text-slate-900">Customer-focused service</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-600">We work to understand our customers and deliver solutions suited to their needs.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-cyan-500 text-sm font-bold text-white">&#10003;</span>
                            <div>
                                <h3 class="font-semibold text-slate-900">Reliable solutions</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-600">Our divisions aim to provide dependable travel, transport, and supply services.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-cyan-500 text-sm font-bold text-white">&#10003;</span>
                            <div>
                                <h3 class="font-semibold text-slate-900">Commitment to quality</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-600">We value consistency, professional service, and long-term business relationships.</p>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>


            {{-- Mission card and company image --}}
            <div class="grid gap-5 sm:grid-cols-2">

                <div class="flex flex-col justify-center rounded-3xl bg-cyan-50 p-7 sm:p-8">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-100 text-cyan-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-7 w-7" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"></circle>
                            <circle cx="12" cy="12" r="5"></circle>
                            <circle cx="12" cy="12" r="1"></circle>
                            <path d="m13.5 10.5 6-6"></path>
                            <path d="M16 4.5h3.5V8"></path>
                        </svg>
                    </div>

                    <p class="mt-6 text-xs font-bold uppercase tracking-[0.18em] text-cyan-800">
                        Our Mission
                    </p>

                    <h3 class="mt-3 text-2xl font-bold leading-snug text-slate-900">
                        {{ $setting->mission_title ?? 'Making progress easier for our customers.' }}
                    </h3>

                    <p class="mt-4 text-sm leading-7 text-slate-600">
                        {{ $setting->mission_description ?? 'We aim to earn trust through responsive support, consistent quality, and a commitment to doing the work well.' }}
                    </p>

                    <a
                        href="{{ route('contracts') }}"
                        class="mt-7 inline-flex w-fit items-center gap-2 rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-cyan-800"
                    >
                        Learn More
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>

                <div class="min-h-[320px] overflow-hidden rounded-3xl bg-slate-100 sm:min-h-0">
                    <img
                        src="{{ !empty($setting->mission_image) ? asset('storage/' . $setting->mission_image) : asset('assets/images/aboutus-title.jpg') }}"
                        alt="Modern business architecture"
                        loading="lazy"
                        class="h-full min-h-[320px] w-full object-cover transition duration-700 hover:scale-105"
                    >
                </div>

            </div>

        </div>
    </div>
</section>


{{-- =====================================================
     3. FOUNDER SECTION
===================================================== --}}
<section class="border-y border-slate-200 bg-slate-50 px-6 py-16 sm:py-24">
    <div class="mx-auto max-w-7xl">

        <div class="grid items-center gap-10 lg:grid-cols-5 lg:gap-16">

            {{-- Founder portrait --}}
            <div class="lg:col-span-2">
                <div class="mx-auto max-w-md overflow-hidden rounded-3xl bg-slate-200 shadow-xl">
                    <img
                        src="{{ !empty($setting->founder_image) ? asset('storage/' . $setting->founder_image) : asset('assets/images/founder.jpg') }}"
                        alt="Founder of Diamond Group"
                        loading="lazy"
                        class="aspect-[4/5] w-full object-cover"
                    >
                </div>
            </div>

            {{-- Founder information --}}
            <div class="lg:col-span-3">

                <div class="mb-5 flex items-center gap-3">
                    <span class="h-1 w-10 rounded-full bg-cyan-500"></span>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-cyan-700">
                        Meet Our Founder
                    </p>
                </div>

                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    {{ $setting->founder_name ?? 'Founder Name' }}
                </h2>

                <p class="mt-3 text-base font-semibold text-cyan-700 sm:text-lg">
                    {{ $setting->founder_designation ?? 'Founder & Managing Director, Diamond Group' }}
                </p>

                <div class="mt-7 space-y-5 leading-8 text-slate-600">
                    <p>
                        {{ $setting->founder_bio_1 ?? 'With a vision for growth and a commitment to excellence, the founder established Diamond Group with the goal of delivering reliable services across travel, transport, and construction supply.' }}
                    </p>

                    <p>
                        {{ $setting->founder_bio_2 ?? 'Through dedicated leadership and a focus on customer satisfaction, the company strives to build lasting relationships, create value for its customers, and develop opportunities for sustainable growth.' }}
                    </p>
                </div>

                @if(!empty($setting->founder_quote))
                    <blockquote class="mt-8 border-l-4 border-cyan-500 pl-5">
                        <p class="text-lg font-semibold italic leading-8 text-slate-800">
                            "{{ $setting->founder_quote }}"
                        </p>
                    </blockquote>
                @endif

            </div>

        </div>
    </div>
</section>

{{-- =====================================================
     4. OUR BUSINESS DIVISIONS
===================================================== --}}
{{-- <section id="our-divisions" class="scroll-mt-24 bg-white px-6 py-16 sm:py-24"> --}}
    {{-- <div class="mx-auto max-w-7xl"> --}}

        {{-- <div class="mx-auto max-w-2xl text-center">
            <div class="mb-4 flex items-center justify-center gap-3">
                <span class="h-1 w-8 rounded-full bg-cyan-500"></span>
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-cyan-700">What We Do</p>
                <span class="h-1 w-8 rounded-full bg-cyan-500"></span>
            </div>

            <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                Our Business Divisions
            </h2>

            <p class="mt-5 leading-7 text-slate-600">
                Discover how our specialized divisions support travel, transportation, and construction supply needs.
            </p>
        </div> --}}

        {{-- <div class="mt-12 grid gap-7 sm:grid-cols-2 lg:grid-cols-3"> --}}
          {{-- Travel & Tours
            <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('assets/images/travel.jpg') }}" alt="Diamond Travel" class="h-56 w-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 to-transparent"></div>
                    <span class="absolute bottom-4 left-5 rounded-full bg-cyan-400 px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-950">Travel</span>
                </div>
                <div class="p-7">
                    <h3 class="text-xl font-bold text-slate-900">Diamond Travel &amp; Tours</h3>
                    <p class="mt-3 leading-7 text-slate-600">Explore new destinations with trip planning, flight reservations, tour management, and personalized travel services.</p>
                    <a href="{{ route('contracts') }}" class="mt-6 inline-flex items-center gap-2 font-semibold text-cyan-700 transition hover:text-cyan-900">Enquire Now <span aria-hidden="true">&rarr;</span></a>
                </div>
            </article> --}}

            {{-- Transport
            <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('assets/images/transport.jpg') }}" alt="Diamond Transport" class="h-56 w-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 to-transparent"></div>
                    <span class="absolute bottom-4 left-5 rounded-full bg-cyan-400 px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-950">Transport</span>
                </div>
                <div class="p-7">
                    <h3 class="text-xl font-bold text-slate-900">Diamond Transport</h3>
                    <p class="mt-3 leading-7 text-slate-600">Dependable freight logistics, fleet services, and commercial transportation solutions designed around your business needs.</p>
                    <a href="{{ route('contracts') }}" class="mt-6 inline-flex items-center gap-2 font-semibold text-cyan-700 transition hover:text-cyan-900">Enquire Now <span aria-hidden="true">&rarr;</span></a>
                </div>
            </article> --}}

            {{-- Construction Supply
            <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl sm:col-span-2 lg:col-span-1">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('assets/images/brick.jpg') }}" alt="Construction Supply" class="h-56 w-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 to-transparent"></div>
                    <span class="absolute bottom-4 left-5 rounded-full bg-cyan-400 px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-950">Construction</span>
                </div>
                <div class="p-7">
                    <h3 class="text-xl font-bold text-slate-900">Construction Supply</h3>
                    <p class="mt-3 leading-7 text-slate-600">Source sand, bricks, concrete, and other construction materials for building and infrastructure projects.</p>
                    <a href="{{ route('contracts') }}" class="mt-6 inline-flex items-center gap-2 font-semibold text-cyan-700 transition hover:text-cyan-900">Enquire Now <span aria-hidden="true">&rarr;</span></a>
                </div>
            </article> --}}
        {{-- </div> --}}
    {{-- </div>
</section> --}}

@endsection

@push('head')
<style>
    .js-loading #about-hero .hero-img { transform: scale(1.25); filter: blur(8px); }
    .js-loading #about-hero .hero-badge,
    .js-loading #about-hero .hero-title,
    .js-loading #about-hero .hero-desc,
    .js-loading #about-hero .hero-btns { opacity: 0; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const unlock = () => {
        document.documentElement.classList.remove('js-loading');
        clearTimeout(window.__jsLoadingTimeout);
    };

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return unlock();
    if (typeof gsap === 'undefined') return unlock();

    gsap.registerPlugin(ScrollTrigger);

    /* ===== 1. HERO ===== */
    const hero      = document.querySelector('#about-hero');
    const heroBg    = hero.querySelector('.hero-img');
    const heroTitle = hero.querySelector('.hero-title');
    const heroBadge = hero.querySelector('.hero-badge');
    const heroDesc  = hero.querySelector('.hero-desc');
    const heroBtns  = hero.querySelector('.hero-btns');

    const startHero = () => {
        // Background: zoom out + sharpen (never hidden)
        gsap.set(heroBg, { scale: 1.25, filter: 'blur(8px)' });
        gsap.to(heroBg, { scale: 1, filter: 'blur(0px)', duration: 2.2, ease: 'power3.out' });

        // Title: char by char
        if (typeof SplitType !== 'undefined') {
            const split = new SplitType(heroTitle, { types: 'words,chars' });
            gsap.set(heroTitle, { opacity: 1 });
            gsap.from(split.chars, {
                y: 80, opacity: 0, rotateX: -90,
                duration: 1, stagger: 0.02, ease: 'back.out(1.7)', delay: 0.3
            });
        } else {
            gsap.fromTo(heroTitle, { y: 45, opacity: 0 }, { y: 0, opacity: 1, duration: 1, delay: 0.3 });
        }

        // Badge, description, buttons
        gsap.set(heroBtns, { opacity: 1 });
        gsap.timeline({ delay: 0.1, defaults: { ease: 'power3.out' } })
            .fromTo(heroBadge, { y: 20, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8 })
            .fromTo(heroDesc,  { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8 }, '-=0.4')
            .fromTo(heroBtns.children, { y: 30, opacity: 0, scale: 0.9 },
                    { y: 0, opacity: 1, scale: 1, duration: 0.7, stagger: 0.15, ease: 'back.out(1.7)' }, '-=0.4');

        // Parallax (image is 120% tall, so no empty edge)
        gsap.to(heroBg, {
            yPercent: 7, ease: 'none',
            scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true }
        });

        unlock();   // LAST: hidden start states are now applied inline
    };

    // Wait for the hero image so the animation starts on a loaded picture
    if (heroBg.complete && heroBg.naturalWidth > 0) {
        startHero();
    } else {
        heroBg.addEventListener('load',  startHero, { once: true });
        heroBg.addEventListener('error', startHero, { once: true });
    }

    /* ============================================
       2. STORY SECTION
    ============================================ */
    const storySection = document.querySelectorAll('section')[1];
    const storyLeft = storySection.querySelector(':scope > div > div > div:first-child');
    const featureItems = storySection.querySelectorAll('ul li');
    const storyCards = storySection.querySelectorAll('.grid.gap-5 > *');

    if (storyLeft) {
        gsap.from(storyLeft.children, {
            y: 50, opacity: 0, duration: 0.9, stagger: 0.15, ease: 'power3.out',
            scrollTrigger: { trigger: storyLeft, start: 'top 80%', toggleActions: 'play none none reverse' }
        });
    }

    featureItems.forEach((item, i) => {
        const icon = item.querySelector('span');
        gsap.from(item, {
            x: -40, opacity: 0, duration: 0.8, delay: i * 0.12, ease: 'power3.out',
            scrollTrigger: { trigger: item, start: 'top 88%', toggleActions: 'play none none reverse' }
        });
        if (icon) {
            gsap.from(icon, {
                scale: 0, rotate: -180, duration: 0.7, delay: i * 0.12 + 0.15,
                ease: 'back.out(2)',
                scrollTrigger: { trigger: item, start: 'top 88%', toggleActions: 'play none none reverse' }
            });
        }
    });

    storyCards.forEach((el, i) => {
        gsap.from(el, {
            y: 60, opacity: 0, rotateY: i === 0 ? -12 : 12, duration: 1, delay: i * 0.15,
            ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 85%', toggleActions: 'play none none reverse' }
        });
    });

    // Floating mission icon
    const missionIcon = storySection.querySelector('.bg-cyan-100');
    if (missionIcon) {
        gsap.to(missionIcon, { y: -10, duration: 2.2, repeat: -1, yoyo: true, ease: 'sine.inOut' });
    }

    /* ============================================
       3. FOUNDER SECTION
    ============================================ */
    const founderSection = document.querySelectorAll('section')[2];
    const founderImg = founderSection.querySelector('img');
    const founderContent = founderSection.querySelector(':scope > div > div > div:last-child');

    gsap.from(founderImg, {
        clipPath: 'inset(0 100% 0 0)',
        scale: 1.15, duration: 1.4, ease: 'power4.inOut',
        scrollTrigger: { trigger: founderImg, start: 'top 80%', toggleActions: 'play none none reverse' }
    });

    gsap.to(founderImg, {
        yPercent: -8, ease: 'none',
        scrollTrigger: { trigger: founderSection, start: 'top bottom', end: 'bottom top', scrub: true }
    });

    if (founderContent) {
        gsap.from(founderContent.children, {
            x: 60, opacity: 0, duration: 0.9, stagger: 0.15, ease: 'power3.out',
            scrollTrigger: { trigger: founderContent, start: 'top 80%', toggleActions: 'play none none reverse' }
        });
    }

    const quote = founderSection.querySelector('blockquote');
    if (quote) {
        gsap.from(quote, {
            scale: 0.94, opacity: 0, duration: 1, ease: 'power3.out',
            scrollTrigger: { trigger: quote, start: 'top 88%', toggleActions: 'play none none reverse' }
        });
    }

    /* ============================================
       4. SCROLL PROGRESS BAR
    ============================================ */
    const progressBar = document.createElement('div');
    progressBar.style.cssText = `
        position: fixed; top: 0; left: 0; height: 3px; width: 0%;
        background: linear-gradient(90deg, #22d3ee, #06b6d4, #0891b2);
        z-index: 99999; box-shadow: 0 0 12px rgba(34,211,238,0.9);
        transition: width 0.1s linear;
    `;
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', () => {
        const max = document.documentElement.scrollHeight - window.innerHeight;
        progressBar.style.width = (window.scrollY / max) * 100 + '%';
    }, { passive: true });

    /* ============================================
       5. CUSTOM CURSOR (desktop only)
    ============================================ */
    // if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
    //     const cursor = document.createElement('div');
    //     cursor.style.cssText = `
    //         position: fixed; width: 24px; height: 24px; border-radius: 50%;
    //         background: rgba(34, 211, 238, 0.4);
    //         pointer-events: none; z-index: 9999;
    //         transform: translate(-50%, -50%);
    //         transition: width 0.3s, height 0.3s, background 0.3s;
    //         backdrop-filter: blur(4px); mix-blend-mode: difference;
    //     `;
    //     document.body.appendChild(cursor);

    //     let mx = 0, my = 0, cx = 0, cy = 0;
    //     window.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; });
    //     (function loop() {
    //         cx += (mx - cx) * 0.18;
    //         cy += (my - cy) * 0.18;
    //         cursor.style.left = cx + 'px';
    //         cursor.style.top = cy + 'px';
    //         requestAnimationFrame(loop);
    //     })();

    //     document.querySelectorAll('a, button').forEach(el => {
    //         el.addEventListener('mouseenter', () => {
    //             cursor.style.width = '56px';
    //             cursor.style.height = '56px';
    //             cursor.style.background = 'rgba(34, 211, 238, 0.6)';
    //         });
    //         el.addEventListener('mouseleave', () => {
    //             cursor.style.width = '24px';
    //             cursor.style.height = '24px';
    //             cursor.style.background = 'rgba(34, 211, 238, 0.4)';
    //         });
    //     });
    // }

    /* ============================================
       6. CARD 3D TILT
    ============================================ */
    document.querySelectorAll('.rounded-3xl').forEach(card => {
        card.style.transformStyle = 'preserve-3d';
        card.addEventListener('mousemove', e => {
            const r = card.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width - 0.5;
            const y = (e.clientY - r.top) / r.height - 0.5;
            gsap.to(card, {
                rotateX: -y * 8, rotateY: x * 8,
                transformPerspective: 1000, duration: 0.4, ease: 'power2.out'
            });
        });
        card.addEventListener('mouseleave', () => {
            gsap.to(card, { rotateX: 0, rotateY: 0, duration: 0.7, ease: 'power3.out' });
        });
    });

    /* ============================================
       7. MAGNETIC BUTTONS
    ============================================ */
    document.querySelectorAll('a[href]').forEach(btn => {
        btn.addEventListener('mousemove', e => {
            const r = btn.getBoundingClientRect();
            const x = e.clientX - r.left - r.width / 2;
            const y = e.clientY - r.top - r.height / 2;
            gsap.to(btn, { x: x * 0.25, y: y * 0.25, duration: 0.4, ease: 'power2.out' });
        });
        btn.addEventListener('mouseleave', () => {
            gsap.to(btn, { x: 0, y: 0, duration: 0.8, ease: 'elastic.out(1, 0.4)' });
        });
    });

    /* ============================================
       8. Refrech after images load
    ============================================ */
     window.addEventListener('load', () => ScrollTrigger.refresh());
});
</script>
@endpush