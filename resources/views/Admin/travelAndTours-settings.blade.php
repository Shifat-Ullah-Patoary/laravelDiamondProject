@extends('layouts.admin')

@section('title', 'Travel & Tours Settings | Diamond Group')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Travel & Tours Page Settings</h1>
            <p class="mt-2 text-sm text-slate-500">Edit the page header and add, update, or remove travel sections.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <p class="mb-2 font-semibold">Please correct the following errors:</p>
                <ul class="list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('admin.travelDetails-settings.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            @method('PUT')
            <section class="space-y-4 border-b border-slate-200 pb-6">
                <h2 class="text-lg font-bold text-slate-800">Page Header</h2>
                <input name="header_badge" type="text" placeholder="Header badge"
                    value="{{ old('header_badge', $setting->header_badge ?? 'Travel & Tours') }}"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3">
                <div class="grid gap-4 sm:grid-cols-2">
                    <input name="header_title_part_1" type="text" required placeholder="Heading"
                        value="{{ old('header_title_part_1', $setting->header_title_part_1 ?? 'Explore more') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    <input name="header_title_part_2" type="text" required placeholder="Heading highlight"
                        value="{{ old('header_title_part_2', $setting->header_title_part_2 ?? 'with Diamond Travel.') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3">
                </div>
                <textarea name="header_description" rows="3" required placeholder="Header description"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3">{{ old('header_description', $setting->header_description ?? 'Exceptional travel packages, flight reservations, tour management, and personalized holiday itineraries around the world.') }}</textarea>
                @if ($setting->header_image)
                    <img src="{{ asset('storage/' . $setting->header_image) }}" alt="Current header background"
                        class="max-h-64 w-full rounded-xl object-cover">
                @endif
                <input name="header_image" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    class="block w-full rounded-lg border border-slate-300 p-3 text-sm">
            </section>

            <section class="space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Travel Service Sections</h2>
                        <p class="text-xs text-slate-500">Add up to 20 sections. Removing a section takes effect when you save.</p>
                    </div>
                    <button id="add-travel-section" type="button"
                        class="rounded-lg border border-cyan-600 px-4 py-2 text-sm font-semibold text-cyan-700">Add Section</button>
                </div>
                <div id="travel-sections" class="space-y-6" data-next-index="{{ $sections->count() }}">
                    @foreach ($sections as $index => $section)
                        <section data-travel-card class="space-y-4 rounded-xl border border-slate-200 p-4 sm:p-6">
                            <input type="hidden" name="sections[{{ $index }}][id]" value="{{ $section->id }}">
                            <div class="flex items-center justify-between gap-3">
                                <h3 class="font-semibold text-slate-800">Section {{ $loop->iteration }}</h3>
                                <button type="button" data-remove-travel class="px-3 py-2 text-sm font-semibold text-red-700">Remove</button>
                            </div>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <input name="sections[{{ $index }}][badge]" type="text" placeholder="Section badge"
                                    value="{{ old("sections.$index.badge", $section->badge) }}" class="w-full rounded-lg border border-slate-300 px-4 py-3">
                                <input name="sections[{{ $index }}][title]" type="text" required placeholder="Section heading"
                                    value="{{ old("sections.$index.title", $section->title) }}" class="w-full rounded-lg border border-slate-300 px-4 py-3">
                            </div>
                            <input name="sections[{{ $index }}][subtitle]" type="text" placeholder="Section subtitle"
                                value="{{ old("sections.$index.subtitle", $section->subtitle) }}" class="w-full rounded-lg border border-slate-300 px-4 py-3">
                            <textarea name="sections[{{ $index }}][description_1]" rows="3" required placeholder="Description"
                                class="w-full rounded-lg border border-slate-300 px-4 py-3">{{ old("sections.$index.description_1", $section->description_1) }}</textarea>
                            <textarea name="sections[{{ $index }}][description_2]" rows="3" required placeholder="Description"
                                class="w-full rounded-lg border border-slate-300 px-4 py-3">{{ old("sections.$index.description_2", $section->description_2) }}</textarea>
                            @if ($section->image)
                                <img src="{{ asset('storage/' . $section->image) }}" alt="Current image for {{ $section->title }}"
                                    class="max-h-64 rounded-xl object-cover">
                            @endif
                            <input name="sections[{{ $index }}][image]" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                class="block w-full rounded-lg border border-slate-300 p-3 text-sm">
                        </section>
                    @endforeach
                </div>
            </section>
            <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-6">
                <button type="submit" class="rounded-lg bg-cyan-600 px-6 py-3 font-semibold text-white">Save Changes</button>
                <a href="{{ route('travelAndToursDetals') }}" target="_blank"
                    class="rounded-lg border border-slate-300 px-6 py-3 font-semibold text-slate-700">View Travel Details Page</a>
            </div>
        </form>

        <template id="travel-section-template">
            <section data-travel-card class="space-y-4 rounded-xl border border-slate-200 p-4 sm:p-6">
                <input type="hidden" name="sections[__INDEX__][id]" value="">
                <div class="flex items-center justify-between gap-3"><h3 class="font-semibold text-slate-800">New Section</h3>
                    <button type="button" data-remove-travel class="px-3 py-2 text-sm font-semibold text-red-700">Remove</button></div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <input name="sections[__INDEX__][badge]" type="text" placeholder="Section badge" class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    <input name="sections[__INDEX__][title]" type="text" required placeholder="Section heading" class="w-full rounded-lg border border-slate-300 px-4 py-3">
                </div>
                <input name="sections[__INDEX__][subtitle]" type="text" placeholder="Section subtitle" class="w-full rounded-lg border border-slate-300 px-4 py-3">
                <textarea name="sections[__INDEX__][description_1]" rows="3" required placeholder="Description" class="w-full rounded-lg border border-slate-300 px-4 py-3"></textarea>
                <textarea name="sections[__INDEX__][description_2]" rows="3" required placeholder="Description" class="w-full rounded-lg border border-slate-300 px-4 py-3"></textarea>
                <input name="sections[__INDEX__][image]" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="block w-full rounded-lg border border-slate-300 p-3 text-sm">
            </section>
        </template>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('travel-sections');
            const template = document.getElementById('travel-section-template');
            const addButton = document.getElementById('add-travel-section');
            let nextIndex = Number(container.dataset.nextIndex);

            const refresh = () => container.querySelectorAll('[data-travel-card]').forEach((card, index) => {
                card.querySelector('h3').textContent = `Section ${index + 1}`;
            });

            addButton.addEventListener('click', () => {
                if (container.querySelectorAll('[data-travel-card]').length >= 20) return;
                container.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__INDEX__', nextIndex++));
                refresh();
            });
            container.addEventListener('click', (event) => {
                if (event.target.matches('[data-remove-travel]')) {
                    event.target.closest('[data-travel-card]').remove();
                    refresh();
                }
            });
        });
    </script>
@endpush
