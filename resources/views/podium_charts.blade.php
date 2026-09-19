<x-layouts.app title="Charts in Podium">
    <div class="flex w-full flex-1 flex-col gap-8 rounded-3xl bg-[#fcfcfc] p-4 font-sans sm:p-6 lg:p-10 dark:bg-[#0d1516]">
        <header class="space-y-3 border-l-4 border-[#02a676] pl-4">
            <p class="text-xs font-bold tracking-widest text-[#02a676]">KiwiMEDSPA</p>
            <h1 class="text-3xl font-black text-[#123338] dark:text-white">Charts in Podium</h1>
            <p class="text-xs font-semibold text-[#02a676]">{{ trans_choice('podium.count', count($charts), ['count' => count($charts)]) }}</p>
        </header>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($charts as $chart)
                <a href="{{ route('podium.download', $chart['slug']) }}" download
                   aria-label="{{ __('podium.download') }}: {{ $chart['title'] }}"
                   class="group flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-[#02a676] hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#02a676] dark:border-white/10 dark:bg-[#123338]/20">
                    <div class="flex items-center justify-between gap-3">
                        <span class="rounded-xl bg-[#02a676]/10 p-3 text-[#02a676]">
                            <flux:icon name="book-open-text" class="size-5" />
                        </span>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">PDF · {{ trans_choice('podium.pages', $chart['page_count'], ['count' => $chart['page_count']]) }}</span>
                    </div>
                    <h2 class="text-base font-bold leading-snug text-[#123338] dark:text-white">{{ $chart['title'] }}</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('podium.source_pages', ['pages' => implode('–', array_unique([$chart['source_pages'][0], $chart['source_pages'][count($chart['source_pages']) - 1]]))]) }}</p>
                    <span class="mt-auto flex items-center justify-center gap-2 rounded-xl bg-[#02a676] px-4 py-2.5 text-sm font-bold text-white transition group-hover:bg-[#123338]">
                        <flux:icon name="arrow-down-tray" class="size-4" />
                        {{ __('podium.download') }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</x-layouts.app>
