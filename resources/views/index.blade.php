@extends('layouts.app')
@section('title', 'Diamond Group | Tours, Transport & Construction')
@section('content')

    <section id="home" class="relative isolate overflow-hidden px-6 py-32 text-center text-white sm:py-40">
 <div class=" absolute inset-0 -z-20">
      <img src="{{ $settings?->image ? asset('storage/' . $settings->image) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1500&q=80' }}"
    alt="Diamond Group transport and logistics"
            class="h-full w-full object-cover object-center"
            >

       </div>
        <div class="relative mx-auto max-w-4xl">

            <p class="mb-4 text-sm font-semibold uppercase tracking-[0.25em] text-cyan-300">
                {{ $settings?->eyebrow ?? 'Excellence in every division' }}
            </p>

            <h1 class="mb-6 text-4xl font-bold tracking-tight sm:text-6xl">
                {{ $settings?->title ?? 'Welcome to Diamond Group' }}
            </h1>

            <p class="mx-auto mb-9 max-w-2xl text-lg leading-8 text-slate-200">
                {{ $settings?->description ?? 'Delivering excellence across travel experiences, logistics solutions, and heavy construction materials.' }}
            </p>

            <a href="{{ $settings?->button_link ?: '#divisions' }}"
                class="inline-flex rounded-lg bg-cyan-500 px-6 py-3 font-semibold text-slate-950 transition hover:bg-cyan-300 focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-slate-900">
                {{ $settings?->button_text ?: 'Explore our services' }}
            </a>

        </div>
    </section>


    <section id="divisions" class="px-6 py-20 sm:py-24">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12 text-center">
                <p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-cyan-700">What we do</p>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Our Business Divisions</h2>
                <p class="mt-4 text-slate-600">Discover the key services that power our enterprise.</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <article class="group relative flex h-full flex-col overflow-hidden rounded-2xl bg-white text-center shadow-sm ring-1 ring-slate-200 transition-shadow duration-300 hover:shadow-xl">
                    <img src="{{ $settings?->travel_image ? asset('storage/' . $settings->travel_image) : asset('assets/images/travel.jpg') }}"
                        alt="Travel destination" class="h-56 w-full object-cover">

                    <div class="flex flex-1 flex-col items-center p-7">
                        <h3 class="mb-3 text-xl font-bold text-slate-900">{{ $settings?->travel_title ?? 'Diamond Travel & Tours' }}</h3>
                        <p class="mb-6 flex-1 leading-7 text-slate-600">
                            {{ $settings?->travel_description ?? 'Exceptional travel packages, flight reservations, tour management, and personalized holiday itineraries around the world.' }}
                        </p>
                        <a href="{{ route('contracts') }}"
                            class="rounded-full border border-cyan-700 px-5 py-2 text-sm font-semibold text-cyan-800 transition hover:bg-cyan-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">Learn
                            more</a>
                    </div>
                </article>

                <article class="group relative flex h-full flex-col overflow-hidden rounded-2xl bg-white text-center shadow-sm ring-1 ring-slate-200 transition-shadow duration-300 hover:shadow-xl">
                    <img src="{{ $settings?->transport_image ? asset('storage/' . $settings->transport_image) : asset('assets/images/transport.jpg') }}"
                        alt="Diamond Transport vehicles" class="h-56 w-full object-cover">
                    <div class="flex flex-1 flex-col items-center p-7">
                        <h3 class="mb-3 text-xl font-bold text-slate-900">{{ $settings?->transport_title ?? 'Diamond Transport' }}</h3>
                        <p class="mb-6 flex-1 leading-7 text-slate-600">
                            {{ $settings?->transport_description ?? 'Reliable freight logistics, fleet rental services, and nation-wide commercial transportation solutions built on safety and speed.' }}
                        </p>
                        <a href="{{ route('transportDetails') }}"
                            class="rounded-full border border-cyan-700 px-5 py-2 text-sm font-semibold text-cyan-800 transition hover:bg-cyan-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">Learn
                            more</a>
                    </div>
                </article>

                <article class="group relative flex h-full flex-col overflow-hidden rounded-2xl bg-white text-center shadow-sm ring-1 ring-slate-200 transition-shadow duration-300 hover:shadow-xl md:col-span-2 lg:col-span-1">
                    <img src="{{ $settings?->construction_image ? asset('storage/' . $settings->construction_image) : asset('assets/images/brick.jpg') }}"
                        alt="Construction materials" class="h-56 w-full object-cover">
                    <div class="flex flex-1 flex-col items-center p-7">
                        <h3 class="mb-3 text-xl font-bold text-slate-900">{{ $settings?->construction_title ?? 'Brick, Sand & Concrete' }}</h3>
                        <p class="mb-6 flex-1 leading-7 text-slate-600">
                            {{ $settings?->construction_description ?? 'High-grade ready-mix concrete, sand, cement supply, and heavy material delivery tailored for durable infrastructure construction.' }}
                        </p>
                        <a href="{{ route('contracts') }}"
                            class="rounded-full border border-cyan-700 px-5 py-2 text-sm font-semibold text-cyan-800 transition hover:bg-cyan-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">Learn
                            more</a>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
<script>
window.addEventListener('load', () => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    if (typeof gsap === 'undefined') return;

    gsap.registerPlugin(ScrollTrigger);

    const isMobile = window.innerWidth < 768;

    /* ============================================
       0. REMOVE FOUC CLASS (if present)
    ============================================ */
    document.documentElement.classList.remove('js-loading');
    if (window.__jsLoadingTimeout) clearTimeout(window.__jsLoadingTimeout);

    /* ============================================
       1. HERO — Cinematic Entrance (FIXED)
    ============================================ */
    const hero      = document.querySelector('#home');
    const heroBg    = hero?.querySelector('img');
    const heroBadge = hero?.querySelector('p.mb-4');
    const heroTitle = hero?.querySelector('h1');
    const heroDesc  = hero?.querySelector('p.mx-auto');
    const heroBtn   = hero?.querySelector('a');

    if (!hero || !heroBg || !heroBadge || !heroTitle || !heroDesc || !heroBtn) {
        console.warn('Hero animation: missing element(s) — skipping.');
    } else {

        // ---- 1a. Background: fade + scale (no blur, no pop) ----
        heroBg.style.willChange = 'transform, opacity';

        const startHeroBg = () => {
            gsap.fromTo(heroBg,
                { scale: 1.15, opacity: 0 },
                {
                    scale: 1,
                    opacity: 1,
                    duration: 1.8,
                    ease: 'power2.out',
                    onComplete: () => {
                        heroBg.style.willChange = 'auto';
                    }
                }
            );
        };

        // Wait for image load — prevents the "sharp → blurred → sharp" pop
        if (heroBg.complete && heroBg.naturalWidth > 0) {
            startHeroBg();
        } else {
            heroBg.addEventListener('load', startHeroBg, { once: true });
            heroBg.addEventListener('error', startHeroBg, { once: true });
        }

      // Ken Burns background
    gsap.fromTo(heroBg,
        { scale: 1.25, filter: 'blur(8px)' },
        { scale: 1, filter: 'blur(0px)', duration: 2.2, ease: 'power3.out' }
    );
        // ---- 1b. Title — char reveal ----
        const splitTitle = new SplitType(heroTitle, { types: 'words,chars' });
        gsap.from(splitTitle.chars, {
            y: 90, opacity: 0, rotateX: -90,
            duration: 1, stagger: 0.025, ease: 'back.out(1.7)', delay: 0.3
        });

        // ---- 1c. Badge — typewriter ----
        const badgeText = heroBadge.textContent.trim();
        heroBadge.textContent = '';
        heroBadge.style.borderRight = '2px solid #22d3ee';
        heroBadge.style.paddingRight = '4px';
        let bi = 0;
        const typeBadge = () => {
            if (bi < badgeText.length) {
                heroBadge.textContent += badgeText.charAt(bi++);
                setTimeout(typeBadge, 55);
            } else {
                let vis = true;
                setInterval(() => {
                    heroBadge.style.borderRightColor = vis ? 'transparent' : '#22d3ee';
                    vis = !vis;
                }, 500);
            }
        };

        // ---- 1d. Description + kick off typewriter ----
        gsap.timeline({ delay: 0.2 })
            .from(heroDesc, { y: 30, opacity: 0, duration: 0.9, ease: 'power3.out' }, 0.9)
            .add(typeBadge, 0.4);

        // ---- 1e. Button — clean set → to → pulse ----
        // gsap.set(heroBtn, { opacity: 0, y: 00, scale: 0.05 });
        gsap.to(heroBtn, {
            opacity: 1,
            y: 0,
            scale: 1,
            duration: 0.8,
            delay: 1.1,
            ease: 'back.out(1.7)',
            onComplete: () => {
                gsap.fromTo(heroBtn,
                    { boxShadow: '0 0 0 0 rgba(6,182,212,0.7)' },
                    {
                        boxShadow: '0 0 0 14px rgba(6,182,212,0)',
                        duration: 1.6,
                        repeat: -1,
                        ease: 'sine.out'
                    }
                );
            }
        });

        // ---- 1f. Parallax — start AFTER entrance completes ----
        gsap.to(heroBg, {
            yPercent: 20,
            ease: 'none',
            scrollTrigger: {
                trigger: hero,
                start: 'top top',
                end: 'bottom top',
                scrub: true
            },
            delay: 1.8   // wait for entrance tween to finish
        });
    }

    /* ============================================
       2. DIVISIONS HEADER
    ============================================ */
    const divisionsHeader = document.querySelector('#divisions .mb-12');
    if (divisionsHeader) {
        gsap.from(divisionsHeader.children, {
            y: 40, opacity: 0, duration: 0.9, stagger: 0.15, ease: 'power3.out',
            scrollTrigger: { trigger: divisionsHeader, start: 'top 82%', toggleActions: 'play none none reverse' }
        });
    }

    /* ============================================
       3. DIVISION CARDS — 3D Flip Reveal
    ============================================ */
    const cards = document.querySelectorAll('#divisions article');

    cards.forEach((card, i) => {
        const img   = card.querySelector('img');
        const title = card.querySelector('h3');
        const desc  = card.querySelector('p');
        const link  = card.querySelector('a');

        // 3a. Card entrance
        gsap.from(card, {
            y: 80,
            opacity: 0,
            rotateY: i === 0 ? -25 : i === 1 ? 0 : 25,
            scale: 0.9,
            duration: 1.1,
            delay: i * 0.12,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: card,
                start: 'top 85%',
                toggleActions: 'play none none reverse'
            }
        });

        // 3b. Image clip reveal
        if (img) {
            gsap.from(img, {
                scale: 1.5,
                clipPath: 'inset(0 0 100% 0)',
                duration: 1.2,
                delay: i * 0.12 + 0.15,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: card,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                }
            });
        }

        // 3c. Staggered text
        const textEls = [title, desc].filter(Boolean);
        if (textEls.length) {
            gsap.from(textEls, {
                y: 20, opacity: 0, duration: 0.6, stagger: 0.1, delay: i * 0.12 + 0.4,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: card,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                }
            });
        }

        // 3d. 3D tilt + shine on hover (desktop only)
        if (!isMobile) {
            const shine = document.createElement('div');
            shine.className = 'shine-layer';
            shine.style.cssText = `
                position: absolute; inset: 0; pointer-events: none; border-radius: inherit;
                transition: background 0.1s; z-index: 1;
            `;
            card.style.position = 'relative';
            card.appendChild(shine);

            card.addEventListener('mousemove', e => {
                const r = card.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - 0.5;
                const y = (e.clientY - r.top) / r.height - 0.5;
                gsap.to(card, {
                    rotateX: -y * 8,
                    rotateY: x * 8,
                    transformPerspective: 1200,
                    duration: 0.4,
                    ease: 'power2.out'
                });
                shine.style.background = `radial-gradient(circle at ${(x + 0.5) * 100}% ${(y + 0.5) * 100}%, rgba(255,255,255,0.4), transparent 60%)`;
            });
            card.addEventListener('mouseleave', () => {
                gsap.to(card, { rotateX: 0, rotateY: 0, duration: 0.7, ease: 'power3.out' });
                shine.style.background = 'transparent';
            });
        }
    });

    /* ============================================
       4. FLOATING BACKGROUND ORBS
    ============================================ */
    if (!isMobile) {
        for (let i = 0; i < 3; i++) {
            const orb = document.createElement('div');
            orb.style.cssText = `
                position: fixed;
                width: ${150 + i * 80}px; height: ${150 + i * 80}px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(34,211,238,${0.15 - i * 0.04}), transparent 70%);
                pointer-events: none; z-index: 0;
                filter: blur(40px);
                top: ${20 + i * 25}%; left: ${10 + i * 30}%;
            `;
            document.body.appendChild(orb);

            gsap.to(orb, {
                x: 'random(-100, 100)',
                y: 'random(-100, 100)',
                duration: 8 + i * 3,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut',
                delay: i * 0.5
            });
        }
    }

    /* ============================================
       5. SCROLL PROGRESS BAR
    ============================================ */
    if (!document.querySelector('.scroll-progress-bar')) {
        const bar = document.createElement('div');
        bar.className = 'scroll-progress-bar';
        bar.style.cssText = `
            position: fixed; top: 0; left: 0; height: 3px; width: 0%;
            background: linear-gradient(90deg, #22d3ee, #06b6d4, #0891b2);
            z-index: 99999; box-shadow: 0 0 12px rgba(34,211,238,0.9);
            transition: width 0.1s linear;
        `;
        document.body.appendChild(bar);

        window.addEventListener('scroll', () => {
            const max = document.documentElement.scrollHeight - window.innerHeight;
            bar.style.width = (window.scrollY / max) * 100 + '%';
        }, { passive: true });
    }

    /* ============================================
       6. MAGNETIC BUTTONS
    ============================================ */
    if (!isMobile) {
        document.querySelectorAll('#home a, #divisions a').forEach(btn => {
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
    }

    /* ============================================
       7. Refresh after images load
    ============================================ */
    ScrollTrigger.refresh();
});
</script>
@endpush