@extends('layouts.admin')

@section('title', 'Construction Details Settings | Diamond Group')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Construction Details Page Settings</h1>
            <p class="mt-2 text-sm text-slate-500">Edit the page header and add, update, or remove construction service
                sections.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <p class="mb-2 font-semibold">Please correct the following errors:</p>
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.constructionDetails-settings.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            @method('PUT')
            <section class="space-y-4 border-b border-slate-200 pb-6">
                <h2 class="text-lg font-bold text-slate-800">Page Header</h2>
                <input name="header_badge" type="text" placeholder="Header badge"
                    value="{{ old('header_badge', $setting->header_badge ?? 'Construction Services') }}"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3">
                <div class="grid gap-4 sm:grid-cols-2">
                    <input name="header_title_part_1" type="text" required placeholder="Heading"
                        value="{{ old('header_title_part_1', $setting->header_title_part_1 ?? 'Building with confidence') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    <input name="header_title_part_2" type="text" required placeholder="Heading highlight"
                        value="{{ old('header_title_part_2', $setting->header_title_part_2 ?? 'from the ground up.') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3">
                </div>
                <textarea name="header_description" rows="3" required placeholder="Header description"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3">{{ old('header_description', $setting->header_description ?? 'Diamond Group provides dependable construction materials and practical project support for stronger communities.') }}</textarea>
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
                        <h2 class="text-lg font-bold text-slate-800">Construction Service Sections</h2>
                        <p class="text-xs text-slate-500">Add up to 20 sections. Removing a section takes effect when you
                            save.</p>
                    </div>
                    <button id="add-service-section" type="button"
                        class="rounded-lg border border-cyan-600 px-4 py-2 text-sm font-semibold text-cyan-700">Add
                        Service</button>
                </div>
                <div id="service-sections" class="space-y-6" data-next-index="{{ $serviceSections->count() }}">
                    @foreach ($serviceSections as $index => $section)
                        <section data-service-card class="space-y-4 rounded-xl border border-slate-200 p-4 sm:p-6">
                            <input type="hidden" name="services[{{ $index }}][id]" value="{{ $section->id }}">
                            <div class="flex items-center justify-between gap-3">
                                <h3 class="font-semibold text-slate-800">Service {{ $loop->iteration }}</h3>
                                <button type="button" data-remove-service
                                    class="px-3 py-2 text-sm font-semibold text-red-700">Remove</button>
                            </div>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <input name="services[{{ $index }}][badge]" type="text"
                                    placeholder="Section badge" value="{{ old("services.$index.badge", $section->badge) }}"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3">
                                <input name="services[{{ $index }}][title]" type="text" required
                                    placeholder="Service heading"
                                    value="{{ old("services.$index.title", $section->title) }}"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3">
                            </div>
                            <input name="services[{{ $index }}][subtitle]" type="text"
                                placeholder="Service subtitle"
                                value="{{ old("services.$index.subtitle", $section->subtitle) }}"
                                class="w-full rounded-lg border border-slate-300 px-4 py-3">
                            <textarea name="services[{{ $index }}][description_1]" rows="3" required placeholder="Description"
                                class="w-full rounded-lg border border-slate-300 px-4 py-3">{{ old("services.$index.description_1", $section->description_1) }}</textarea>
                            <textarea name="services[{{ $index }}][description_2]" rows="3" required placeholder="Description"
                                class="w-full rounded-lg border border-slate-300 px-4 py-3">{{ old("services.$index.description_2", $section->description_2) }}</textarea>
                            @if ($section->image)
                                <img src="{{ asset('storage/' . $section->image) }}"
                                    alt="Current image for {{ $section->title }}" class="max-h-64 rounded-xl object-cover">
                            @endif
                            <input name="services[{{ $index }}][image]" type="file"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                class="block w-full rounded-lg border border-slate-300 p-3 text-sm">
                        </section>
                    @endforeach
                </div>
            </section>
            <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-6">
                <button type="submit" class="rounded-lg bg-cyan-600 px-6 py-3 font-semibold text-white">Save
                    Changes</button>
                <a href="{{ route('constructionDetails') }}" target="_blank"
                    class="rounded-lg border border-slate-300 px-6 py-3 font-semibold text-slate-700">View Construction
                    Details Page</a>
            </div>
        </form>

        <template id="service-section-template">
            <section data-service-card class="space-y-4 rounded-xl border border-slate-200 p-4 sm:p-6">
                <input type="hidden" name="services[__INDEX__][id]" value="">
                <div class="flex items-center justify-between gap-3">
                    <h3 class="font-semibold text-slate-800">New Service</h3>
                    <button type="button" data-remove-service
                        class="px-3 py-2 text-sm font-semibold text-red-700">Remove</button>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <input name="services[__INDEX__][badge]" type="text" placeholder="Section badge"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    <input name="services[__INDEX__][title]" type="text" required placeholder="Service heading"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3">
                </div>
                <input name="services[__INDEX__][subtitle]" type="text" placeholder="Service subtitle"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3">
                <textarea name="services[__INDEX__][description_1]" rows="3" required placeholder="Description"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3"></textarea>
                <textarea name="services[__INDEX__][description_2]" rows="3" required placeholder="Description"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3"></textarea>
                <input name="services[__INDEX__][image]" type="file"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    class="block w-full rounded-lg border border-slate-300 p-3 text-sm">
            </section>
        </template>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('service-sections');
            const template = document.getElementById('service-section-template');
            const addButton = document.getElementById('add-service-section');
            let nextIndex = Number(container.dataset.nextIndex);

            const refresh = () => {
                container.querySelectorAll('[data-service-card]').forEach((card, index) => {
                    card.querySelector('h3').textContent = `Service ${index + 1}`;
                });
            };

            addButton.addEventListener('click', () => {
                if (container.querySelectorAll('[data-service-card]').length >= 20) return;
                container.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__INDEX__',
                    nextIndex++));
                refresh();
            });
            container.addEventListener('click', (event) => {
                if (event.target.matches('[data-remove-service]')) {
                    event.target.closest('[data-service-card]').remove();
                    refresh();
                }
            });
        });
    </script>
@endpush
