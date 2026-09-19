<x-layouts.app :title="__('resources.title')">
    <div class="flex w-full flex-1 flex-col gap-8 rounded-3xl bg-[#fcfcfc] p-4 font-sans sm:p-6 lg:p-10 dark:bg-[#0d1516]">
        <header class="space-y-3 border-l-4 border-[#02a676] pl-4">
            <p class="text-xs font-bold tracking-widest text-[#02a676]">KiwiMEDSPA</p>
            <h1 class="text-3xl font-black text-[#123338] dark:text-white">{{ __('resources.title') }}</h1>
            <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('resources.intro') }}</p>
        </header>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            @foreach (config('resources') as $key => $document)
                <article class="flex flex-col gap-6 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8 dark:border-white/10 dark:bg-[#123338]/20">
                    <div class="flex items-center justify-between gap-4">
                        <div class="rounded-2xl bg-[#02a676]/10 p-4 text-[#02a676]">
                            <flux:icon name="book-open-text" class="h-8 w-8" />
                        </div>
                        <span class="rounded-lg bg-[#351d5b]/5 px-3 py-1 text-xs font-bold text-[#351d5b] dark:bg-white/10 dark:text-white">{{ $document['format'] }}</span>
                    </div>
                    <h2 class="text-xl font-bold text-[#123338] dark:text-white">{{ __($document['title']) }}</h2>
                    @if ($document['format'] !== 'PDF')
                        <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-300">{{ __('resources.presentation_note') }}</p>
                    @endif
                    <div class="mt-auto flex flex-wrap gap-3 pt-2">
                        @if ($document['format'] === 'PDF')
                            <a href="{{ route('resources.file', $key) }}" target="_blank" rel="noopener noreferrer" class="rounded-xl bg-[#351d5b] px-5 py-3 text-sm font-bold text-white transition-colors hover:bg-[#123338] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#02a676]">{{ __('resources.view') }}</a>
                        @endif
                        <a href="{{ route('resources.file', ['resource' => $key, 'download' => 1]) }}" class="rounded-xl bg-[#02a676] px-5 py-3 text-sm font-bold text-white transition-colors hover:bg-[#123338] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#02a676]">{{ __('resources.download') }}</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-layouts.app>
