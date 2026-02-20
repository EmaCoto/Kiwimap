<div x-data x-init="$wire.setTz(Intl.DateTimeFormat().resolvedOptions().timeZone)" class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl">

    {{-- Executive Header --}}
    <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
                <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">{{ __('Attendance Tracker') }}</h1>
            </div>
            <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3">{{ $today }} — {{ __('TZ') }}: {{ $tz }}</p>
        </div>

        <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
            <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">{{ __('Current Status:') }}</span>
            <span class="text-[10px] font-black text-[#123338] dark:text-white italic uppercase">
                {{
                    [
                        'offline'    => __('Offline'),
                        'working'    => __('Working'),
                        'break1'     => __('On Break 1'),
                        'break2'     => __('On Break 2'),
                        'lunch'      => __('On Lunch'),
                        'clocked_out'=> __('Finished')
                    ][$status] ?? $status
                }}
            </span>
        </div>
    </div>

    {{-- Tactical Action Panel --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 px-2">
        {{-- Clock In --}}
        <button wire:click="clockIn" @disabled($closed || $a->clock_in)
            class="group relative px-4 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl flex flex-col items-center gap-2
            {{ ($closed || $a->clock_in) ? 'opacity-30 cursor-not-allowed bg-gray-100 text-gray-400' : 'bg-gradient-to-br from-[#123338] to-[#1a444a] text-white hover:scale-105 active:scale-95 shadow-[#123338]/20' }}">
            <flux:icon name="arrow-right-end-on-rectangle" class="h-5 w-5 text-[#6fa31c]" />
            <span>{{ __('Clock In') }}</span>
        </button>

        {{-- Breaks and Lunch --}}
        @php
            $buttons = [
                ['label' => __('Break 1 (Start)'), 'action' => 'break1Start', 'icon' => 'clock', 'disabled' => ($closed || $a->break1_start)],
                ['label' => __('Break 2 (Start)'), 'action' => 'break2Start', 'icon' => 'clock', 'disabled' => ($closed || $a->break2_start)],
                ['label' => __('Lunch (Start)'), 'action' => 'lunchStart', 'icon' => 'pause-circle', 'disabled' => ($closed || $a->lunch_start)],
            ];
        @endphp

        @foreach($buttons as $btn)
            <button wire:click="{{ $btn['action'] }}" @disabled($btn['disabled'])
                class="group px-4 py-4 rounded-2xl border border-gray-100 dark:border-white/5 text-[10px] font-black uppercase tracking-widest transition-all flex flex-col items-center gap-2
                {{ $btn['disabled'] ? 'opacity-30 cursor-not-allowed bg-transparent text-gray-300' : 'bg-white dark:bg-[#123338]/40 text-[#123338] dark:text-white hover:border-[#02a676] hover:bg-gray-50' }}">
                <flux:icon name="{{ $btn['icon'] }}" class="h-5 w-5 {{ $btn['disabled'] ? 'text-gray-300' : 'text-[#351d5b] dark:text-[#6fa31c]' }}" />
                <span class="text-center leading-tight">{{ $btn['label'] }}</span>
            </button>
        @endforeach

        {{-- Clock Out (Special Style) --}}
        <button wire:click="clockOut" @disabled($closed || !$a->clock_in || $a->clock_out)
            class="group px-4 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl flex flex-col items-center gap-2
            {{ ($closed || !$a->clock_in || $a->clock_out) ? 'opacity-30 cursor-not-allowed bg-gray-100 text-gray-400' : 'bg-gradient-to-br from-[#351d5b] to-[#2a174a] text-white hover:scale-105 active:scale-95 shadow-[#351d5b]/20' }}">
            <flux:icon name="arrow-right-start-on-rectangle" class="h-5 w-5 text-[#f56e2a]" />
            <span>{{ __('Clock Out') }}</span>
        </button>

        {{-- End Buttons --}}
        @php
            $ends = [
                ['label' => __('Break 1 (End)'), 'action' => 'break1End', 'icon' => 'clock', 'disabled' => ($closed || !$a->break1_start || $a->break1_end)],
                ['label' => __('Break 2 (End)'), 'action' => 'break2End', 'icon' => 'clock', 'disabled' => ($closed || !$a->break2_start || $a->break2_end)],
                ['label' => __('Lunch (End)'), 'action' => 'lunchEnd', 'icon' => 'play-circle', 'disabled' => ($closed || !$a->lunch_start || $a->lunch_end)],
            ];
        @endphp

        @foreach($ends as $btn)
            <button wire:click="{{ $btn['action'] }}" @disabled($btn['disabled'])
                class="group px-4 py-4 rounded-2xl border border-dashed border-gray-200 dark:border-white/10 text-[10px] font-black uppercase tracking-widest transition-all flex flex-col items-center gap-2
                {{ $btn['disabled'] ? 'opacity-30 cursor-not-allowed bg-transparent text-gray-300' : 'bg-white dark:bg-[#123338]/20 text-[#123338] dark:text-white hover:border-[#6fa31c]' }}">
                <flux:icon name="{{ $btn['icon'] }}" class="h-5 w-5 {{ $btn['disabled'] ? 'text-gray-200' : 'text-[#02a676]' }}" />
                <span class="text-center leading-tight">{{ $btn['label'] }}</span>
            </button>
        @endforeach
    </div>

    {{-- Time Log Section: Executive Report Style --}}
    <div class="mt-4 space-y-6">
        <div class="flex items-center gap-4 px-2">
            <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.3em]">{{ __('Today’s Time Log') }}</h2>
            <div class="h-[1px] flex-1 bg-gray-100 dark:bg-white/5"></div>
        </div>

        @php $get = fn($col) => $a->getRawTime($col)?->format('H:i:s') ?? '—'; @endphp

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 px-2">
            {{-- Time Cards --}}
            @php
                $metrics = [
                    ['title' => __('Clock In / Clock Out'), 'icon' => 'home-modern', 'val1' => 'IN: '.$get('clock_in'), 'val2' => 'OUT: '.$get('clock_out')],
                    ['title' => __('Break 1'), 'icon' => 'clock', 'val1' => 'IN: '.$get('break1_start'), 'val2' => 'OUT: '.$get('break1_end')],
                    ['title' => __('Break 2'), 'icon' => 'clock', 'val1' => 'IN: '.$get('break2_start'), 'val2' => 'OUT: '.$get('break2_end')],
                    ['title' => __('Lunch'), 'icon' => 'pause-circle', 'val1' => 'IN: '.$get('lunch_start'), 'val2' => 'OUT: '.$get('lunch_end')],
                ];
            @endphp

            @foreach($metrics as $m)
            <div class="group p-5 rounded-2xl bg-white dark:bg-[#123338]/10 border border-gray-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <div class="h-8 w-8 rounded-lg bg-[#123338] flex items-center justify-center">
                        <flux:icon name="{{ $m['icon'] }}" class="h-4 w-4 text-[#6fa31c]" />
                    </div>
                    <span class="text-[9px] font-black text-[#123338] dark:text-gray-400 uppercase tracking-widest">{{ $m['title'] }}</span>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-mono font-black text-[#02a676]">{{ $m['val1'] }}</p>
                    <p class="text-[10px] font-mono font-black text-[#123338] dark:text-white">{{ $m['val2'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Total Hours Footer --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-2 pt-4">
            <div class="bg-[#123338] p-6 rounded-2xl flex justify-between items-center shadow-2xl shadow-[#123338]/20">
                <div>
                    <span class="text-[9px] font-black text-[#6fa31c] uppercase tracking-[0.3em]">{{ __('Workload Today') }}</span>
                    <p class="text-3xl font-black text-white italic tracking-tighter mt-1">{{ $todayHHMM }}</p>
                </div>
                <flux:icon name="briefcase" class="h-10 w-10 text-white/10" />
            </div>

            <div class="bg-[#351d5b] p-6 rounded-2xl flex justify-between items-center shadow-2xl shadow-[#351d5b]/20">
                <div>
                    <span class="text-[9px] font-black text-white/50 uppercase tracking-[0.3em]">{{ __('Shift Status') }}</span>
                    <p class="text-xl font-black text-white uppercase italic tracking-tighter mt-1">
                        {{ $status == 'clocked_out' ? __('COMPLETED') : __('IN PROGRESS') }}
                    </p>
                </div>
                <flux:icon name="check-badge" class="h-10 w-10 text-white/10" />
            </div>
        </div>

        {{-- Overtime --}}
        <div class="mt-8 px-2">
            <div class="flex items-center gap-4 mb-3">
                <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.3em]">
                    {{ __('Overtime') }}
                </h2>
                <div class="h-[1px] flex-1 bg-gray-100 dark:bg-white/5"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label class="text-[9px] font-black text-gray-400 uppercase">{{ __('From') }}</label>
                    <input type="time"
                        wire:model="overtimeStart"
                        class="w-full rounded-xl border border-gray-200 p-2 text-sm">
                </div>

                <div>
                    <label class="text-[9px] font-black text-gray-400 uppercase">{{ __('To') }}</label>
                    <input type="time"
                        wire:model="overtimeEnd"
                        class="w-full rounded-xl border border-gray-200 p-2 text-sm">
                </div>

                <button wire:click="saveOvertime"
                        class="px-4 py-3 rounded-2xl bg-[#6fa31c] text-white text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-all">
                    {{ __('Save Overtime') }}
                </button>
            </div>

            @if($a->overtime_seconds > 0)
                <p class="mt-3 text-[11px] font-mono font-black text-[#6fa31c]">
                    {{ __('Overtime recorded:') }} {{ $a->overtime_hhmm }}
                </p>
            @endif
        </div>

    </div>
</div>
