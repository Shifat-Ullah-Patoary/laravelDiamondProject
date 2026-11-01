@extends('layouts.admin')

@section('title', 'Team Page Settings | Diamond Group')

@section('content')
    <div class="mx-auto max-w-5xl">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Team Page Settings</h1>
            <p class="mt-2 text-sm text-slate-500">Update the founder section and add, edit, or remove team members.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.team-settings.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            @method('PUT')

            <section class="space-y-4 border-b border-slate-200 pb-8">
                <h2 class="text-lg font-bold text-slate-800">Team page content</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="section_header_top" class="mb-2 block text-sm font-semibold">Section label</label>
                        <input id="section_header_top" name="section_header_top" required
                            value="{{ old('section_header_top', $setting->section_header_top ?? 'Leadership') }}"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    </div>
                    <div>
                        <label for="section_header_middle" class="mb-2 block text-sm font-semibold">Founder heading</label>
                        <input id="section_header_middle" name="section_header_middle" required
                            value="{{ old('section_header_middle', $setting->section_header_middle ?? 'Meet Our Founder') }}"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    </div>
                </div>
                <div>
                    <label for="section_header_bottom" class="mb-2 block text-sm font-semibold">Founder introduction</label>
                    <textarea id="section_header_bottom" name="section_header_bottom" required rows="3"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3">{{ old('section_header_bottom', $setting->section_header_bottom ?? 'Strong leadership, clear vision and a commitment to excellence.') }}</textarea>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="member_heading" class="mb-2 block text-sm font-semibold">Members heading</label>
                        <input id="member_heading" name="member_heading" required
                            value="{{ old('member_heading', $setting->member_heading ?? 'Meet Our Team') }}"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    </div>
                    <div>
                        <label for="member_description" class="mb-2 block text-sm font-semibold">Members description</label>
                        <input id="member_description" name="member_description" required
                            value="{{ old('member_description', $setting->member_description ?? 'A team of talented individuals working together to deliver outstanding results.') }}"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    </div>
                </div>
            </section>

            <section class="space-y-4 border-b border-slate-200 pb-8">
                <h2 class="text-lg font-bold text-slate-800">Founder</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="founder_header_top" class="mb-2 block text-sm font-semibold">Founder label</label>
                        <input id="founder_header_top" name="founder_header_top" required
                            value="{{ old('founder_header_top', $setting->founder_header_top ?? 'Leadership & Vision') }}"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    </div>
                    <div>
                        <label for="founder_name" class="mb-2 block text-sm font-semibold">Name</label>
                        <input id="founder_name" name="founder_name" required
                            value="{{ old('founder_name', $setting->founder_name ?? 'Abdul Majid') }}"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    </div>
                    <div>
                        <label for="designation" class="mb-2 block text-sm font-semibold">Designation</label>
                        <input id="designation" name="designation" required
                            value="{{ old('designation', $setting->designation ?? 'Founder & Chairman') }}"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    </div>
                    <div>
                        <label for="founder_image" class="mb-2 block text-sm font-semibold">Founder image</label>
                        <input id="founder_image" name="founder_image" type="file" accept="image/*"
                            class="block w-full rounded-lg border border-slate-300 p-3 text-sm">
                    </div>
                </div>
                <div>
                    <label for="founder_description" class="mb-2 block text-sm font-semibold">Founder description</label>
                    <textarea id="founder_description" name="founder_description" required rows="4"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3">{{ old('founder_description', $setting->founder_description ?? 'Leading Diamond Group with a vision for growth, quality and customer satisfaction.') }}</textarea>
                </div>
            </section>

            <section>
                <div class="mb-4 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Team members</h2>
                        <p class="text-sm text-slate-500">Remove a member by clicking Remove, then save changes.</p>
                    </div>
                    <button id="add-member" type="button"
                        class="rounded-lg bg-cyan-600 px-4 py-2 text-sm font-semibold text-white hover:bg-cyan-700">Add member</button>
                </div>

                <div id="members" class="space-y-4">
                    @foreach (old('members', $setting->teamMembers ?? []) as $index => $member)
                        <div class="member-row rounded-xl border border-slate-200 p-4" data-member>
                            <input type="hidden" name="members[{{ $index }}][id]" value="{{ data_get($member, 'id') }}">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <input name="members[{{ $index }}][name]" required placeholder="Name"
                                    value="{{ data_get($member, 'name') }}" class="rounded-lg border border-slate-300 px-4 py-3">
                                <input name="members[{{ $index }}][position]" required placeholder="Position"
                                    value="{{ data_get($member, 'position') }}" class="rounded-lg border border-slate-300 px-4 py-3">
                            </div>
                            @if (data_get($member, 'image'))
                                <img src="{{ asset('storage/' . data_get($member, 'image')) }}" alt="{{ data_get($member, 'name') }}"
                                    class="mt-4 h-24 w-24 rounded-lg object-cover">
                            @endif
                            <label class="mt-4 block text-sm font-semibold text-slate-700">
                                Member image
                                <input name="members[{{ $index }}][image]" type="file" accept="image/*"
                                    class="mt-2 block w-full rounded-lg border border-slate-300 p-3 text-sm">
                            </label>
                            <textarea name="members[{{ $index }}][description]" rows="2" placeholder="Description"
                                class="mt-4 w-full rounded-lg border border-slate-300 px-4 py-3">{{ data_get($member, 'description') }}</textarea>
                            <button type="button" data-remove-member
                                class="mt-3 rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Remove</button>
                        </div>
                    @endforeach
                </div>
            </section>

            <button type="submit"
                class="rounded-lg bg-slate-900 px-6 py-3 font-semibold text-white hover:bg-slate-700">Save team page</button>
        </form>
    </div>

    <template id="member-template">
        <div class="member-row rounded-xl border border-slate-200 p-4" data-member>
            <input type="hidden" data-field="id">
            <div class="grid gap-4 sm:grid-cols-2">
                <input data-field="name" required placeholder="Name" class="rounded-lg border border-slate-300 px-4 py-3">
                <input data-field="position" required placeholder="Position" class="rounded-lg border border-slate-300 px-4 py-3">
            </div>
            <label class="mt-4 block text-sm font-semibold text-slate-700">
                Member image
                <input data-field="image" type="file" accept="image/*"
                    class="mt-2 block w-full rounded-lg border border-slate-300 p-3 text-sm">
            </label>
            <textarea data-field="description" rows="2" placeholder="Description"
                class="mt-4 w-full rounded-lg border border-slate-300 px-4 py-3"></textarea>
            <button type="button" data-remove-member
                class="mt-3 rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Remove</button>
        </div>
    </template>

    @push('scripts')
        <script>
            (() => {
                const container = document.getElementById('members');
                const template = document.getElementById('member-template');
                let nextIndex = container.querySelectorAll('[data-member]').length;

                const updateNames = (row, index) => {
                    row.querySelectorAll('[data-field]').forEach((field) => {
                        field.name = `members[${index}][${field.dataset.field}]`;
                    });
                };

                document.getElementById('add-member').addEventListener('click', () => {
                    const row = template.content.firstElementChild.cloneNode(true);
                    updateNames(row, nextIndex++);
                    container.appendChild(row);
                });

                container.addEventListener('click', (event) => {
                    if (event.target.matches('[data-remove-member]')) {
                        event.target.closest('[data-member]').remove();
                    }
                });
            })();
        </script>
    @endpush
@endsection
