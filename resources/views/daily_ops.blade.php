<x-layouts.app :title="__('Daily Ops')">
    <div class="flex h-full w-full flex-1 flex-col gap-12 p-10 bg-[#f8fafb] dark:bg-[#05080a] rounded-lg font-sans transition-colors duration-500 perspective-[2000px]">

        {{-- Header: Solución definitiva al corte de la última letra --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6">
            <div class="relative group">
                <div class="absolute -left-6 top-0 h-full w-1.5 bg-linear-to-b from-[#351d5b] via-[#02a676] to-transparent rounded-full"></div>

                {{-- Añadimos pr-8 y eliminamos leading-none para dar espacio a la inclinación de la 'R' --}}
                <h1 class="text-3xl font-black text-[#123338] dark:text-white uppercase pr-10 py-">
                    Command <span class="text-transparent bg-clip-text bg-linear-to-r from-[#351d5b] to-[#02a676]">Center</span>
                </h1>

                <div class="flex items-center gap-3 mt-1">
                    <span class="px-2 py-0.5 bg-[#02a676]/10 text-[#02a676] text-[9px] font-bold rounded uppercase tracking-[0.3em]">Enterprise</span>
                    <div class="h-px w-24 bg-gray-200 dark:bg-white/10"></div>
                </div>
            </div>
        </div>

        {{-- Links Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

            @php
                $links = [
                    ['name' => 'Tebra', 'desc' => 'Patient Management', 'sub' => 'Secure Sign-In', 'color' => '#91D06C', 'url' => 'https://www.tebra.com/sign-in', 'img' => 'tebra.png'],
                    ['name' => 'Spruce', 'desc' => 'Communication', 'sub' => 'Health Portal', 'color' => '#02a676', 'url' => 'https://app.sprucehealth.com/login', 'img' => 'spruce.png'],
                    ['name' => 'Teams', 'desc' => 'Collaboration', 'sub' => 'Microsoft Office', 'color' => '#464eb8', 'url' => 'https://teams.microsoft.com/l/chat/19:fb9db99945b44030bae71e8b4606fb71@thread.v2/conversations?context=%7B%22contextType%22%3A%22chat%22%7D', 'img' => 'teams.png'],
                    ['name' => 'Outlook', 'desc' => 'Business Email', 'sub' => 'Email & Calendar', 'color' => '#0078d4', 'url' => 'https://outlook.office.com', 'img' => 'outlook.png'],
                    ['name' => 'Gmail', 'desc' => 'Workspace Mail', 'sub' => 'Google Workspace', 'color' => '#ea4335', 'url' => 'https://mail.google.com', 'img' => 'gmail.png'],
                    ['name' => 'Color Hunt', 'desc' => 'Color Palette Inspiration', 'sub' => 'Design Resources', 'color' => '#FFDE42', 'url' => 'https://colorhunt.co', 'img' => 'color_hunt.png'],
                    ['name' => 'Meta Business', 'desc' => 'Business Manager', 'sub' => 'Ads & Assets', 'color' => '#03AED2', 'url' => 'https://business.facebook.com/latest/home?asset_id=753148577872650&business_id=1560930404957347&ir_qe_exposed=1&nav_ref=fb_web_pplus_settings_menu', 'img' => 'meta.png'],
                    ];
            @endphp

            @foreach($links as $link)
            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer"
               style="--brand-color: {{ $link['color'] }};"
               class="group relative h-80 rounded-lg transition-all duration-500 [transform-style:preserve-3d] hover:[transform:rotateY(-8deg)_rotateX(4deg)]">

                {{-- Glass Card Base --}}
                <div class="absolute inset-0 bg-white dark:bg-[#123338]/20 backdrop-blur-xl border border-gray-100 dark:border-white/10 rounded-lg shadow-[0_15px_35px_-10px_rgba(0,0,0,0.05)] dark:shadow-[0_20px_50px_-15px_rgba(0,0,0,0.4)] transition-all"></div>

                {{-- Content --}}
                <div class="relative h-full flex flex-col items-center justify-center p-8 z-10 [transform:translateZ(50px)]">

                    {{-- Logo Container --}}
                    <div class="relative mb-6 transition-transform duration-500 group-hover:[transform:translateZ(30px)]">
                        <div class="absolute inset-0 opacity-10 blur-2xl group-hover:opacity-30 transition-opacity"
                             style="background-color: var(--brand-color);"></div>
                        <div class="relative w-24 h-24 rounded-2xl bg-white  shadow-xl flex items-center justify-center p-5 border border-gray-100 dark:border-white/5">
                            <img src="{{ asset('img/' . $link['img']) }}" alt="{{ $link['name'] }}" class="w-full h-full object-contain filter drop-shadow-sm">
                        </div>
                    </div>

                    {{-- Text Content --}}
                    <div class="text-center space-y-1">
                        <p class="text-[9px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.4em]">{{ $link['desc'] }}</p>
                        <h2 class="text-4xl font-black italic tracking-tighter text-[#123338] dark:text-white transition-colors duration-300 group-hover:[color:var(--brand-color)]">{{ $link['name'] }}</h2>
                    </div>

                    {{-- Raya Dinámica: Solo sale en Hover --}}
                    <div class="mt-6 flex flex-col items-center gap-2 overflow-hidden w-full">
                        <span class="text-[10px] font-bold text-gray-500 dark:text-white/40 uppercase tracking-widest">{{ $link['sub'] }}</span>
                        {{-- Esta es la raya que mencionas, ahora configurada para todas las cards --}}
                        <div class="h-0.5 w-0 group-hover:w-32 transition-all duration-500 ease-out rounded-full"
                             style="background-color: var(--brand-color); box-shadow: 0 0 8px var(--brand-color);"></div>
                    </div>
                </div>

                {{-- External Link Icon --}}
                <div class="absolute top-5 right-5 opacity-20 group-hover:opacity-100 transition-opacity duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#123338] dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </div>
            </a>
            @endforeach

        </div>

    </div>
</x-layouts.app>
