<footer class="bg-slate-950 px-6 py-8 text-sm text-slate-400">
    <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 md:flex-row">

        {{-- Left: Copyright --}}
        <div class="text-center md:text-left">
            <p class="mb-1">
            &copy; {{ date('Y') }} <strong class="text-white">{{ $footerSettings->title }}</strong>. All rights reserved.
            </p>
            <p class="text-xs text-slate-500">
            {{ $footerSettings->description }}
            </p>
        </div>

        {{-- Right: Social icons --}}
        <div class="flex gap-3">
            {{-- Facebook --}}
            @if ($footerSettings->facebook_url)
            <a href="{{ $footerSettings->facebook_url }}" target="_blank" rel="noopener noreferrer"
               aria-label="Facebook"
               class="flex h-9 w-9 items-center justify-center rounded-md border border-slate-800 text-slate-400 transition hover:border-cyan-500 hover:bg-slate-900 hover:text-cyan-400">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94Z"/>
                </svg>
            </a>
            @endif

            {{-- Instagram --}}
            @if ($footerSettings->instagram_url)
            <a href="{{ $footerSettings->instagram_url }}" target="_blank" rel="noopener noreferrer"
               aria-label="Instagram"
               class="flex h-9 w-9 items-center justify-center rounded-md border border-slate-800 text-slate-400 transition hover:border-cyan-500 hover:bg-slate-900 hover:text-cyan-400">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41-.56-.22-.96-.48-1.38-.9-.42-.42-.68-.82-.9-1.38-.16-.42-.36-1.06-.41-2.23C2.17 15.58 2.16 15.2 2.16 12s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41C8.42 2.17 8.8 2.16 12 2.16Zm0 1.62c-3.15 0-3.52.01-4.76.07-1.15.05-1.77.24-2.18.4-.55.21-.94.47-1.35.88-.41.41-.67.8-.88 1.35-.16.41-.35 1.03-.4 2.18-.06 1.24-.07 1.61-.07 4.76s.01 3.52.07 4.76c.05 1.15.24 1.77.4 2.18.21.55.47.94.88 1.35.41.41.8.67 1.35.88.41.16 1.03.35 2.18.4 1.24.06 1.61.07 4.76.07s3.52-.01 4.76-.07c1.15-.05 1.77-.24 2.18-.4.55-.21.94-.47 1.35-.88.41-.41.67-.8.88-1.35.16-.41.35-1.03.4-2.18.06-1.24.07-1.61.07-4.76s-.01-3.52-.07-4.76c-.05-1.15-.24-1.77-.4-2.18a3.63 3.63 0 0 0-.88-1.35 3.63 3.63 0 0 0-1.35-.88c-.41-.16-1.03-.35-2.18-.4-1.24-.06-1.61-.07-4.76-.07Zm0 2.76a5.46 5.46 0 1 1 0 10.92 5.46 5.46 0 0 1 0-10.92Zm0 9a3.54 3.54 0 1 0 0-7.08 3.54 3.54 0 0 0 0 7.08Zm6.95-9.21a1.28 1.28 0 1 1-2.56 0 1.28 1.28 0 0 1 2.56 0Z"/>
                </svg>
            </a>
            @endif

            {{-- LinkedIn --}}
            @if ($footerSettings->linkedin_url)
            <a href="{{ $footerSettings->linkedin_url }}" target="_blank" rel="noopener noreferrer"
               aria-label="LinkedIn"
               class="flex h-9 w-9 items-center justify-center rounded-md border border-slate-800 text-slate-400 transition hover:border-cyan-500 hover:bg-slate-900 hover:text-cyan-400">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.45 20.45h-3.55v-5.57c0-1.33-.03-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.45v6.29ZM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12ZM7.12 20.45H3.56V9h3.56v11.45ZM22.22 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.73C24 .77 23.2 0 22.22 0Z"/>
                </svg>
            </a>
            @endif

            {{-- WhatsApp --}}
            @if ($footerSettings->whatsapp_url)
            <a href="{{ $footerSettings->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
               aria-label="WhatsApp"
               class="flex h-9 w-9 items-center justify-center rounded-md border border-slate-800 text-slate-400 transition hover:border-cyan-500 hover:bg-slate-900 hover:text-cyan-400">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.06 2.87 1.21 3.07.15.2 2.09 3.2 5.06 4.49.71.31 1.26.49 1.69.63.71.23 1.35.19 1.86.12.57-.09 1.76-.72 2.01-1.42.25-.7.25-1.29.17-1.42-.07-.13-.27-.2-.57-.35ZM12.04 21.78h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 0 1-1.51-5.25c0-5.45 4.44-9.88 9.89-9.88 2.64 0 5.12 1.03 6.99 2.9a9.82 9.82 0 0 1 2.89 6.99c0 5.45-4.44 9.88-9.88 9.88ZM20.52 3.45A11.81 11.81 0 0 0 12.04 0C5.5 0 .18 5.32.18 11.86c0 2.09.55 4.13 1.59 5.93L0 24l6.36-1.67a11.85 11.85 0 0 0 5.67 1.44h.01c6.54 0 11.86-5.32 11.86-11.86 0-3.17-1.23-6.15-3.38-8.46Z"/>
                </svg>
            </a>
            @endif

        
        </div>

    </div>
</footer>