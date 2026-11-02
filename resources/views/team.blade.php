@extends('layouts.app')

@section('title', 'Our Team | Diamond Group')

@section('content')

{{-- HERO SECTION --}}
{{-- 
<section class="relative overflow-hidden bg-slate-950 py-20 sm:py-28">
    <div class="absolute inset-0 opacity-20"
         style="background-image: radial-gradient(#94a3b8 1px, transparent 1px); background-size: 30px 30px;">
    </div>

    <div class="relative max-w-7xl mx-auto px-6 text-center reveal-scroll" data-delay="0">
        <span class="inline-block rounded-full border border-amber-400/40 bg-amber-400/10 px-5 py-2 text-sm font-semibold tracking-widest text-amber-400">
            THE PEOPLE BEHIND OUR SUCCESS
        </span>

        <h1 class="mt-7 text-4xl font-extrabold tracking-tight text-white sm:text-6xl">
            Meet The People
            <span class="block text-amber-400 mt-2">Behind Diamond Group</span>
        </h1>

        <p class="mx-auto mt-7 max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">
            Our strength lies in our people. Meet the dedicated professionals
            whose experience, passion and commitment drive Diamond Group forward.
        </p>

        <div class="mx-auto mt-10 h-1 w-24 rounded-full bg-amber-400"></div>
    </div>
</section> 
 --}}


{{-- FOUNDER / LEADERSHIP SECTION --}}
{{-- FOUNDER / LEADERSHIP SECTION --}}
<section class="bg-slate-50 py-20 overflow-hidden">
    <div class="mx-auto max-w-7xl px-6">

        {{-- Section Header --}}
        <div class="mb-12 text-center reveal-scroll" data-delay="0">
            <p class="text-sm font-bold uppercase tracking-[0.25em] text-amber-600">
                {{ $setting->section_header_top ?? 'Leadership' }}
            </p>

            <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">
                {{ $setting->section_header_middle ?? 'Meet Our Founder' }}
            </h2>

            <p class="mx-auto mt-4 max-w-2xl text-slate-500">
                {{ $setting->section_header_bottom ?? 'Strong leadership, clear vision and a commitment to excellence.' }}
            </p>
        </div>

        {{-- Founder Card Container --}}
        <div class="grid overflow-hidden rounded-3xl bg-white shadow-xl lg:grid-cols-3 reveal-scroll items-stretch" data-delay="150">

            {{-- Founder Image Box (ছোট স্ক্রিনে h-64 বা sm:h-80 এবং বড় স্ক্রিনে lg:h-full) --}}
            <div class="relative w-full h-64 sm:h-80 lg:h-full lg:col-span-1 bg-slate-200 overflow-hidden group">
                <img
                    src="{{ !empty($setting->founder_image)
                        ? asset('storage/' . $setting->founder_image)
                        : asset('assets/images/abdulMajid.jpg') }}"
                    alt="Diamond Group Founder"
                    class="w-full h-full object-cover object-top transition-transform duration-700 ease-out group-hover:scale-105"
                    onerror="this.onerror=null;this.src='https://placehold.co/800x1000/e2e8f0/475569?text=Founder+Image';"
                >

                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>

                <div class="absolute bottom-5 left-5 transition-transform duration-300 group-hover:translate-x-1">
                    <span class="rounded-full bg-amber-400 px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-950 shadow-md">
                        Founder & Chairman
                    </span>
                </div>
            </div>

            {{-- Founder Details (lg:col-span-2) --}}
            <div class="flex flex-col justify-center p-8 sm:p-10 lg:col-span-2">

                <span class="text-sm font-bold uppercase tracking-widest text-amber-600">
                    {{ $setting->founder_header_top ?? 'Leadership & Vision' }}
                </span>

                <h3 class="mt-4 text-3xl font-extrabold text-slate-900 sm:text-4xl">
                    {{ $setting->founder_name ?? 'Abdul Majid' }}
                </h3>

                <p class="mt-2 text-lg font-semibold text-slate-500">
                    {{ $setting->designation ?? 'Founder & Chairman' }}
                </p>

                <div class="my-6 h-1 w-16 rounded-full bg-amber-400 transition-all duration-500 hover:w-24"></div>

                <p class="leading-8 text-slate-600">
                    {{ $setting->founder_description ?? 'Leading Diamond Group with a vision for growth, quality and customer satisfaction.' }}
                </p>

            </div>
        </div>
    </div>
</section>

{{-- TEAM MEMBERS SECTION --}}
<section class="bg-white py-20 overflow-hidden">
    <div class="mx-auto max-w-7xl px-6">

        {{-- Section Header --}}
        <div class="mb-14 text-center reveal-scroll" data-delay="0">
            {{-- <p class="text-sm font-bold uppercase tracking-[0.25em] text-amber-600">
                Our Professionals
            </p> --}}

            <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">
                {{ $setting->member_heading ?? 'Meet Our Team' }}
            </h2>

            <p class="mx-auto mt-4 max-w-2xl leading-7 text-slate-500">
                {{ $setting->member_description ?? 'A team of talented individuals working together to deliver outstanding results.' }}
            </p>
        </div>

        {{-- Grid with Staggered Scroll Animations --}}
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

            @foreach ($setting->teamMembers ?? [] as $index => $member)

                <div 
                    class="reveal-scroll group overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-md transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl"
                    data-delay="{{ $index * 150 }}"
                >

                    {{-- Member Image Container --}}
                    <div class="relative h-96 overflow-hidden bg-slate-100">
                        <img
                            src="{{ $member->image ? asset('storage/' . $member->image) : asset('assets/images/abdulMajid.jpg') }}"
                            alt="{{ $member->name }}"
                            class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-110"
                            onerror="this.onerror=null;this.src='https://placehold.co/600x700/e2e8f0/475569?text=Team+Member';"
                        >

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent opacity-70 transition-opacity duration-300 group-hover:opacity-90"></div>

                        <div class="absolute bottom-5 left-5 transition-transform duration-300 group-hover:translate-x-1">
                            <span class="rounded-full bg-amber-400 px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-950 shadow-md">
                                Diamond Group
                            </span>
                        </div>
                    </div>

                    {{-- Member Details --}}
                    <div class="p-7">

                        <h3 class="text-xl font-extrabold text-slate-900 transition-colors duration-300 group-hover:text-amber-600">
                            {{ $member->name }}
                        </h3>

                        <p class="mt-2 text-sm font-bold uppercase tracking-wider text-amber-600">
                            {{ $member->position }}
                        </p>

                        <p class="mt-4 text-sm leading-7 text-slate-500">
                            {{ $member->description }}
                        </p>

                        <div class="mt-6 border-t border-slate-100 pt-5 flex items-center justify-between">
                            <span class="text-sm font-semibold text-slate-700">
                                Our strength is our people.
                            </span>
                            <span class="text-amber-500 opacity-0 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-1">→</span>
                        </div>

                    </div>
                </div>

            @endforeach

        </div>
    </div>
</section>


{{-- BOTTOM CTA SECTION --}}
{{-- 
<section class="bg-slate-950 py-16 overflow-hidden">
    <div class="mx-auto max-w-5xl px-6 text-center reveal-scroll" data-delay="0">

        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
            Together, We Build Excellence.
        </h2>

        <p class="mx-auto mt-5 max-w-2xl leading-7 text-slate-300">
            Have a project or business opportunity in mind?
            Our team is ready to help you move forward.
        </p>

        <a href="{{ url('/contracts') }}"
           class="mt-8 inline-flex items-center rounded-full bg-amber-400 px-8 py-4 font-bold text-slate-950 shadow-lg transition-all duration-300 hover:bg-amber-300 hover:shadow-amber-400/20 hover:-translate-y-0.5">
            Contact Our Team
            <span class="ml-2 transition-transform duration-300 hover:translate-x-1">→</span>
        </a>

    </div>
</section> 
--}}

{{-- Inline CSS for Intersection Reveal States --}}
<style>
    .reveal-scroll {
        opacity: 0;
        transform: translateY(35px);
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: opacity, transform;
    }

    .reveal-scroll.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

{{-- Intersection Observer JavaScript --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const revealElements = document.querySelectorAll('.reveal-scroll');

        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -60px 0px',
            threshold: 0.15
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const delay = parseInt(entry.target.getAttribute('data-delay') || 0, 10);
                    
                    setTimeout(() => {
                        entry.target.classList.add('is-visible');
                    }, delay);

                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        revealElements.forEach(el => observer.observe(el));
    });
</script>

@endsection