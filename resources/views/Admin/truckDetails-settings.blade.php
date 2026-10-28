@extends('layouts.admin')

@section('title', 'Truck Details Settings | Diamond Group')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Truck Details Page Settings</h1>
            <p class="mt-2 text-sm text-slate-500">
                Edit the page header and add, update, or remove vehicle sections.
            </p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
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

        <form action="{{ route('admin.truckDetails-settings.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            @method('PUT')

            <section class="space-y-4 border-b border-slate-200 pb-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Page Header</h2>
                    <p class="text-xs text-slate-500">Manage the top banner heading, description, and background.</p>
                </div>

                <div>
                    <label for="header_badge" class="mb-2 block text-sm font-semibold text-slate-700">Header Badge</label>
                    <input id="header_badge" name="header_badge" type="text"
                        value="{{ old('header_badge', $setting->header_badge ?? 'Transport Services') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="header_title_part_1" class="mb-2 block text-sm font-semibold text-slate-700">
                            Heading (Part 1)
                        </label>
                        <input id="header_title_part_1" name="header_title_part_1" type="text" required
                            value="{{ old('header_title_part_1', $setting->header_title_part_1 ?? 'Reliable transport solutions') }}"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    </div>

                    <div>
                        <label for="header_title_part_2" class="mb-2 block text-sm font-semibold text-slate-700">
                            Heading Highlight (Part 2)
                        </label>
                        <input id="header_title_part_2" name="header_title_part_2" type="text" required
                            value="{{ old('header_title_part_2', $setting->header_title_part_2 ?? 'for your business.') }}"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    </div>
                </div>

                <div>
                    <label for="header_description" class="mb-2 block text-sm font-semibold text-slate-700">
                        Header Description
                    </label>
                    <textarea id="header_description" name="header_description" rows="3" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">{{ old('header_description', $setting->header_description ?? 'Diamond Group provides practical transport solutions to help businesses move goods and materials efficiently.') }}</textarea>
                </div>

                <div>
                    <label for="header_image" class="mb-2 block text-sm font-semibold text-slate-700">
                        Header Background Image
                    </label>
                    @if ($setting->header_image)
                        <img src="{{ asset('storage/' . $setting->header_image) }}" alt="Current header background"
                            class="mb-4 max-h-64 w-full rounded-xl border border-slate-200 object-cover">
                    @endif
                    <input id="header_image" name="header_image" type="file"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        class="block w-full rounded-lg border border-slate-300 p-3 text-sm text-slate-600 file:mr-4 file:rounded-md file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:font-semibold">
                </div>
            </section>

            <section class="space-y-4 border-b border-slate-200 pb-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Vehicle Sections</h2>
                        <p class="text-xs text-slate-500">Add up to 20 sections. Removing a section takes effect when you save.</p>
                    </div>
                    <button id="add-vehicle-section" type="button"
                        class="rounded-lg border border-cyan-600 px-4 py-2 text-sm font-semibold text-cyan-700 transition hover:bg-cyan-50">
                        Add Vehicle
                    </button>
                </div>

                <div id="vehicle-sections" class="space-y-6" data-next-index="{{ $vehicleSections->count() }}">
                    @foreach ($vehicleSections as $index => $vehicleSection)
                        <section data-vehicle-card class="space-y-4 rounded-xl border border-slate-200 p-4 sm:p-6">
                            <input type="hidden" name="vehicles[{{ $index }}][id]" value="{{ $vehicleSection->id }}">

                            <div class="flex items-center justify-between gap-3">
                                <h3 class="font-semibold text-slate-800">Vehicle {{ $loop->iteration }}</h3>
                                <button type="button" data-remove-vehicle
                                    class="rounded-lg px-3 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50">
                                    Remove
                                </button>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="vehicle-{{ $index }}-badge"
                                        class="mb-2 block text-sm font-semibold text-slate-700">Section Badge</label>
                                    <input id="vehicle-{{ $index }}-badge" name="vehicles[{{ $index }}][badge]"
                                        type="text" value="{{ old("vehicles.$index.badge", $vehicleSection->badge) }}"
                                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                                </div>
                                <div>
                                    <label for="vehicle-{{ $index }}-title"
                                        class="mb-2 block text-sm font-semibold text-slate-700">Vehicle Heading</label>
                                    <input id="vehicle-{{ $index }}-title" name="vehicles[{{ $index }}][title]"
                                        type="text" required
                                        value="{{ old("vehicles.$index.title", $vehicleSection->title) }}"
                                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                                </div>
                            </div>

                            <div>
                                <label for="vehicle-{{ $index }}-subtitle"
                                    class="mb-2 block text-sm font-semibold text-slate-700">Vehicle Subtitle</label>
                                <input id="vehicle-{{ $index }}-subtitle"
                                    name="vehicles[{{ $index }}][subtitle]" type="text"
                                    value="{{ old("vehicles.$index.subtitle", $vehicleSection->subtitle) }}"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                            </div>

                            <div>
                                <label for="vehicle-{{ $index }}-description-1"
                                    class="mb-2 block text-sm font-semibold text-slate-700">Description (Paragraph 1)</label>
                                <textarea id="vehicle-{{ $index }}-description-1"
                                    name="vehicles[{{ $index }}][description_1]" rows="3" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">{{ old("vehicles.$index.description_1", $vehicleSection->description_1) }}</textarea>
                            </div>

                            <div>
                                <label for="vehicle-{{ $index }}-description-2"
                                    class="mb-2 block text-sm font-semibold text-slate-700">Description (Paragraph 2)</label>
                                <textarea id="vehicle-{{ $index }}-description-2"
                                    name="vehicles[{{ $index }}][description_2]" rows="3" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">{{ old("vehicles.$index.description_2", $vehicleSection->description_2) }}</textarea>
                            </div>

                            <div>
                                <label for="vehicle-{{ $index }}-image"
                                    class="mb-2 block text-sm font-semibold text-slate-700">Vehicle Image</label>
                                @if ($vehicleSection->image)
                                    <img src="{{ asset('storage/' . $vehicleSection->image) }}"
                                        alt="Current image for {{ $vehicleSection->title }}"
                                        class="mb-4 max-h-64 rounded-xl border border-slate-200 object-cover">
                                @endif
                                <input id="vehicle-{{ $index }}-image"
                                    name="vehicles[{{ $index }}][image]" type="file"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                    class="block w-full rounded-lg border border-slate-300 p-3 text-sm text-slate-600 file:mr-4 file:rounded-md file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:font-semibold">
                            </div>
                        </section>
                    @endforeach
                </div>
            </section>

            <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6">
                <button type="submit"
                    class="rounded-lg bg-cyan-600 px-6 py-3 font-semibold text-white transition hover:bg-cyan-700">
                    Save Changes
                </button>
                <a href="{{ route('transportDetails') }}" target="_blank"
                    class="rounded-lg border border-slate-300 px-6 py-3 font-semibold text-slate-700 transition hover:bg-slate-50">
                    View Truck Details Page
                </a>
            </div>
        </form>

        <template id="vehicle-section-template">
            <section data-vehicle-card class="space-y-4 rounded-xl border border-slate-200 p-4 sm:p-6">
                <input type="hidden" name="vehicles[__INDEX__][id]" value="">

                <div class="flex items-center justify-between gap-3">
                    <h3 class="font-semibold text-slate-800">New Vehicle</h3>
                    <button type="button" data-remove-vehicle
                        class="rounded-lg px-3 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50">
                        Remove
                    </button>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="vehicle-__INDEX__-badge"
                            class="mb-2 block text-sm font-semibold text-slate-700">Section Badge</label>
                        <input id="vehicle-__INDEX__-badge" name="vehicles[__INDEX__][badge]" type="text"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    </div>
                    <div>
                        <label for="vehicle-__INDEX__-title"
                            class="mb-2 block text-sm font-semibold text-slate-700">Vehicle Heading</label>
                        <input id="vehicle-__INDEX__-title" name="vehicles[__INDEX__][title]" type="text" required
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                    </div>
                </div>

                <div>
                    <label for="vehicle-__INDEX__-subtitle"
                        class="mb-2 block text-sm font-semibold text-slate-700">Vehicle Subtitle</label>
                    <input id="vehicle-__INDEX__-subtitle" name="vehicles[__INDEX__][subtitle]" type="text"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                </div>

                <div>
                    <label for="vehicle-__INDEX__-description-1"
                        class="mb-2 block text-sm font-semibold text-slate-700">Description (Paragraph 1)</label>
                    <textarea id="vehicle-__INDEX__-description-1" name="vehicles[__INDEX__][description_1]"
                        rows="3" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"></textarea>
                </div>

                <div>
                    <label for="vehicle-__INDEX__-description-2"
                        class="mb-2 block text-sm font-semibold text-slate-700">Description (Paragraph 2)</label>
                    <textarea id="vehicle-__INDEX__-description-2" name="vehicles[__INDEX__][description_2]"
                        rows="3" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100"></textarea>
                </div>

                <div>
                    <label for="vehicle-__INDEX__-image"
                        class="mb-2 block text-sm font-semibold text-slate-700">Vehicle Image</label>
                    <input id="vehicle-__INDEX__-image" name="vehicles[__INDEX__][image]" type="file"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        class="block w-full rounded-lg border border-slate-300 p-3 text-sm text-slate-600 file:mr-4 file:rounded-md file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:font-semibold">
                </div>
            </section>
        </template>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('vehicle-sections');
            const addButton = document.getElementById('add-vehicle-section');
            const template = document.getElementById('vehicle-section-template');
            let nextIndex = Number(container.dataset.nextIndex);

            // Toast helper
            function showToast(message, type = 'success') {
                const colors = {
                    success: 'bg-green-600 border-green-700',
                    error: 'bg-red-600 border-red-700',
                    info: 'bg-slate-800 border-slate-900',
                };

                const toast = document.createElement('div');
                toast.className = `pointer-events-auto rounded-lg border px-5 py-3 text-sm font-semibold text-white shadow-lg transition-all duration-300 ${colors[type] || colors.info}`;
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-8px)';
                toast.textContent = message;

                const wrapper = document.getElementById('toast-container');
                wrapper.appendChild(toast);

                // Fade in
                requestAnimationFrame(() => {
                    toast.style.opacity = '1';
                    toast.style.transform = 'translateY(0)';
                });

                // Fade out & remove
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-8px)';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            addButton.addEventListener('click', () => {
                const currentCount = container.querySelectorAll('[data-vehicle-card]').length;

                if (currentCount >= 20) {
                    showToast('You can add up to 20 vehicle sections.', 'error');
                    return;
                }

                // Confirmation before adding
                const confirmed = window.confirm(
                    `Are you sure you want to add a new vehicle section? (${currentCount + 1} of 20)`
                );
                if (!confirmed) {
                    return;
                }

                const section = template.content.cloneNode(true);
                const sectionMarkup = section.querySelector('[data-vehicle-card]');
                sectionMarkup.innerHTML = sectionMarkup.innerHTML.replaceAll('__INDEX__', String(nextIndex));
                nextIndex += 1;
                container.append(sectionMarkup);

                showToast('Vehicle section added.', 'success');
            });

            container.addEventListener('click', (event) => {
                const removeButton = event.target.closest('[data-remove-vehicle]');
                if (!removeButton) {
                    return;
                }

                const card = removeButton.closest('[data-vehicle-card]');
                const vehicleName = card.querySelector('h3')?.textContent?.trim() || 'this vehicle section';

                // Confirmation before removing
                const confirmed = window.confirm(
                    `Are you sure you want to remove "${vehicleName}"? This will take effect when you save.`
                );
                if (!confirmed) {
                    return;
                }

                card.remove();
                showToast(`${vehicleName} removed. Save changes to apply.`, 'info');
            });
        });
    </script>

    {{-- Toast container --}}
    <div id="toast-container"
        class="pointer-events-none fixed top-4 right-4 z-50 flex w-full max-w-sm flex-col gap-2"></div>
@endpush