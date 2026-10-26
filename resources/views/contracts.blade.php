@extends('layouts.app')

@section('title', 'Contact Us | Diamond Group')

@section('content')
    <section class="px-6 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-bold tracking-tight">{{ $setting->top_header ?? 'Contact us' }}</h1>
                <p class="mt-4 text-slate-600">{{ $setting->header_description ?? 'Have a question or need our services? We would love to hear from you.' }}</p>
            </div>
            <div class="grid gap-8 lg:grid-cols-5">
                <aside class="rounded-2xl bg-slate-900 p-8 text-white lg:col-span-2">
                    <h2 class="text-2xl font-bold">Contact details</h2>
                    <dl class="mt-8 space-y-6">
                        <div>
                            <dt class="font-semibold text-cyan-300">Address</dt>
                            <dd class="mt-1 text-slate-300">{{ $setting->address_description ?? 'Enter your company address here' }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-cyan-300">Phone</dt>
                            <dd class="mt-1 text-slate-300">{{ $setting->phone_number ?? '+880 1XXXXXXXXX' }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-cyan-300">Email</dt>
                            <dd class="mt-1 text-slate-300">{{ $setting->email ?? 'info@example.com' }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-cyan-300">Business hours</dt>
                            <dd class="mt-1 text-slate-300">{{ $setting->business_our ?? 'Saturday – Thursday: 9:00 AM – 6:00 PM' }}</dd>
                        </div>
                    </dl>
                </aside>
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-9 lg:col-span-3">
                    <h2 class="text-2xl font-bold text-slate-900">Send us a message</h2>
                    <form action="{{ route('contract.store') }}" method="POST" class="mt-7 space-y-5">
                        @csrf
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Full
                                    name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    autocomplete="name" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-cyan-600 focus:ring-2 focus:ring-cyan-100">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email
                                    address</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    autocomplete="email" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-cyan-600 focus:ring-2 focus:ring-cyan-100">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="mb-2 block text-sm font-semibold text-slate-700">Subject</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-cyan-600 focus:ring-2 focus:ring-cyan-100">
                            @error('subject')
                                <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="message" class="mb-2 block text-sm font-semibold text-slate-700">Message</label>
                            <textarea name="message" id="message" rows="5" required
                                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-cyan-600 focus:ring-2 focus:ring-cyan-100">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="rounded-lg bg-cyan-700 px-6 py-3 font-semibold text-white transition hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:ring-offset-2">Send
                            message</button>
                    </form>
                    @if (session('success'))
                        <div role="status"
                            class="mt-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
                            {{ session('success') }}</div>
                    @endif
                </div>
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
       0. REMOVE FOUC CLASS (if you added it earlier)
    ============================================ */
    document.documentElement.classList.remove('js-loading');
    clearTimeout(window.__jsLoadingTimeout);

    /* ============================================
       1. PAGE HEADER — Split Reveal
    ============================================ */
    const header = document.querySelector('section .mb-12');
    const headerH1 = header.querySelector('h1');
    const headerP  = header.querySelector('p');

    // Split H1 into chars
    const splitH1 = new SplitType(headerH1, { types: 'words,chars' });

    gsap.from(splitH1.chars, {
        y: 60,
        opacity: 0,
        rotateX: -90,
        duration: 0.9,
        stagger: 0.02,
        ease: 'back.out(1.7)',
        delay: 0.2
    });

    gsap.from(headerP, {
        y: 25,
        opacity: 0,
        duration: 0.8,
        delay: 0.9,
        ease: 'power3.out'
    });

    /* ============================================
       2. CONTACT INFO CARD — Slide from Left
    ============================================ */
    const infoCard = document.querySelector('aside');
    const infoTitle = infoCard.querySelector('h2');
    const infoRows = infoCard.querySelectorAll('dl > div');

    // Card: slide + fade
    gsap.from(infoCard, {
        x: -80,
        opacity: 0,
        duration: 1,
        delay: 0.3,
        ease: 'power3.out'
    });

    // Title
    gsap.from(infoTitle, {
        y: 20,
        opacity: 0,
        duration: 0.7,
        delay: 0.6,
        ease: 'power2.out'
    });

    // Each row: slide in from left + icon pop
    infoRows.forEach((row, i) => {
        const dt = row.querySelector('dt');
        const dd = row.querySelector('dd');

        gsap.from(row, {
            x: -30,
            opacity: 0,
            duration: 0.6,
            delay: 0.8 + i * 0.12,
            ease: 'power3.out'
        });

        // Cyan glow pulse on the label
        gsap.from(dt, {
            scale: 0.8,
            opacity: 0,
            duration: 0.5,
            delay: 0.9 + i * 0.12,
            ease: 'back.out(2)'
        });

        gsap.from(dd, {
            x: 20,
            opacity: 0,
            duration: 0.6,
            delay: 1.0 + i * 0.12,
            ease: 'power2.out'
        });
    });

    // Floating glow orbs inside the dark card
    if (!isMobile) {
        for (let i = 0; i < 2; i++) {
            const orb = document.createElement('div');
            orb.style.cssText = `
                position: absolute;
                width: ${180 + i * 60}px; height: ${180 + i * 60}px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(34,211,238,0.18), transparent 70%);
                pointer-events: none;
                filter: blur(30px);
                z-index: 0;
            `;
            infoCard.style.position = 'relative';
            infoCard.style.overflow = 'hidden';
            infoCard.appendChild(orb);

            gsap.to(orb, {
                x: gsap.utils.random(-80, 80),
                y: gsap.utils.random(-80, 80),
                duration: 6 + i * 2,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut',
                delay: i * 0.6
            });
        }
    }

    // 3D tilt on hover (desktop)
    if (!isMobile) {
        infoCard.addEventListener('mousemove', e => {
            const r = infoCard.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width - 0.5;
            const y = (e.clientY - r.top) / r.height - 0.5;
            gsap.to(infoCard, {
                rotateX: -y * 4,
                rotateY: x * 4,
                transformPerspective: 1200,
                duration: 0.5,
                ease: 'power2.out'
            });
        });
        infoCard.addEventListener('mouseleave', () => {
            gsap.to(infoCard, { rotateX: 0, rotateY: 0, duration: 0.8, ease: 'power3.out' });
        });
    }

    /* ============================================
       3. FORM CARD — Slide from Right + Stagger Fields
    ============================================ */
    const formCard = document.querySelector('form').closest('.rounded-2xl');
    const formTitle = formCard.querySelector('h2');
    const formGroups = formCard.querySelectorAll('form > div');
    const submitBtn = formCard.querySelector('button[type="submit"]');

    gsap.from(formCard, {
        x: 80,
        opacity: 0,
        duration: 1,
        delay: 0.3,
        ease: 'power3.out'
    });

    gsap.from(formTitle, {
        y: 20,
        opacity: 0,
        duration: 0.7,
        delay: 0.6,
        ease: 'power2.out'
    });

    // Each field group staggered fade-up
    formGroups.forEach((group, i) => {
        gsap.from(group, {
            y: 25,
            opacity: 0,
            duration: 0.6,
            delay: 0.8 + i * 0.12,
            ease: 'power3.out'
        });

        // Input focus glow ripple
        const input = group.querySelector('input, textarea');
        if (input) {
            input.addEventListener('focus', () => {
                gsap.to(input, {
                    boxShadow: '0 0 0 4px rgba(6,182,212,0.15)',
                    scale: 1.01,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
            input.addEventListener('blur', () => {
                gsap.to(input, {
                    boxShadow: '0 0 0 0 rgba(6,182,212,0)',
                    scale: 1,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
        }
    });

    // Submit button: entrance + magnetic hover
    gsap.from(submitBtn, {
        y: 30,
        opacity: 0,
        scale: 0.9,
        duration: 0.7,
        delay: 1.4,
        ease: 'back.out(1.7)'
    });

    if (!isMobile) {
        submitBtn.addEventListener('mousemove', e => {
            const r = submitBtn.getBoundingClientRect();
            const x = e.clientX - r.left - r.width / 2;
            const y = e.clientY - r.top - r.height / 2;
            gsap.to(submitBtn, { x: x * 0.3, y: y * 0.3, duration: 0.4, ease: 'power2.out' });
        });
        submitBtn.addEventListener('mouseleave', () => {
            gsap.to(submitBtn, { x: 0, y: 0, duration: 0.8, ease: 'elastic.out(1, 0.4)' });
        });
    }

    // Success message: confetti-style pop
    const successMsg = document.querySelector('[role="status"]');
    if (successMsg) {
        gsap.from(successMsg, {
            y: -20,
            scale: 0.8,
            opacity: 0,
            duration: 0.8,
            ease: 'back.out(2)'
        });

        // Shine sweep across the success message
        const shine = document.createElement('div');
        shine.style.cssText = `
            position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
            pointer-events: none;
        `;
        successMsg.style.position = 'relative';
        successMsg.style.overflow = 'hidden';
        successMsg.appendChild(shine);

        gsap.to(shine, {
            left: '100%',
            duration: 1,
            delay: 0.5,
            ease: 'power2.inOut',
            repeat: 2,
            repeatDelay: 0.8
        });
    }

    /* ============================================
       4. SCROLL PROGRESS BAR (shared with other pages)
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
       5. CUSTOM CURSOR (desktop only)
    ============================================ */
    // if (!isMobile && window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
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

    //     document.querySelectorAll('a, button, input, textarea').forEach(el => {
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
       6. Refresh on load
    ============================================ */
    ScrollTrigger.refresh();
});

// Add after the input focus block
document.querySelectorAll('form input, form textarea').forEach(input => {
    input.addEventListener('input', () => {
        gsap.fromTo(input, 
            { borderColor: '#06b6d4' },
            { borderColor: '#cbd5e1', duration: 0.8, ease: 'power2.out' }
        );
    });
});
</script>
@endpush
