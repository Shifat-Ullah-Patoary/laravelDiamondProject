@extends('layouts.admin')

@section('title', 'Footer Settings | Diamond Group')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Footer Settings</h1>
            <p class="mt-2 text-sm text-slate-500">
                Edit the footer heading, description, and social media links shown on every public page.
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

        <form action="{{ route('admin.footer-settings.update') }}" method="POST"
            class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Footer Heading</label>
                <input id="title" name="title" type="text" value="{{ old('title', $settings->title) }}"
                    maxlength="255" required
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Footer Description</label>
                <textarea id="description" name="description" rows="4" maxlength="10000"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">{{ old('description', $settings->description) }}</textarea>
            </div>

            <div>
                <h2 class="mb-4 text-lg font-semibold text-slate-900">Social Media Links</h2>
                <div class="grid gap-5 sm:grid-cols-2">
                    @foreach ([
                        'facebook_url' => 'Facebook URL',
                        'instagram_url' => 'Instagram URL',
                        'linkedin_url' => 'LinkedIn URL',
                        'whatsapp_url' => 'WhatsApp URL',
                    ] as $field => $label)
                        <div>
                            <label for="{{ $field }}" class="mb-2 block text-sm font-semibold text-slate-700">
                                {{ $label }}
                            </label>
                            <input id="{{ $field }}" name="{{ $field }}" type="url"
                                value="{{ old($field, $settings->{$field}) }}" maxlength="2048"
                                placeholder="https://"
                                class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100">
                        </div>
                    @endforeach
                </div>
                <p class="mt-3 text-xs text-slate-500">
                    Leave a link empty to hide that social icon from the footer.
                </p>
            </div>

            <button type="submit"
                class="rounded-lg bg-cyan-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-cyan-700">
                Save Footer Settings
            </button>
        </form>
    </div>
@endsection
