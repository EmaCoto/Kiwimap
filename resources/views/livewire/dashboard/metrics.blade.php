<div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl">
  <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
    <div class="space-y-1">
      <div class="flex items-center gap-2">
        <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
        <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">{{ __('Control Center') }}</h1>
      </div>
      <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3">{{ __('System Monitoring / Live Data') }}</p>
    </div>

    @if(auth()->user()?->hasAnyRole(['Admin', 'Office Manager']))
      <button x-data @click.prevent="if (confirm(@js(__('Reset system cache?')))) { $wire.clearCaches() }"
        class="group relative px-8 py-3 rounded-lg bg-[#123338] dark:bg-white text-white dark:text-[#123338] text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-[#123338]/20">
        <div class="flex items-center gap-3">
          <flux:icon name="bolt" class="h-4 w-4 text-[#6fa31c] group-hover:animate-pulse" />
          <span>{{ __('Purge Cache Memory') }}</span>
        </div>
      </button>
    @endif
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    @php
      $cards = [
        ['label' => __('State Coverage'), 'val' => $operationalStates, 'sub' => __('Active Jurisdictions'), 'color' => '#6fa31c'],
        ['label' => __('Medical Staff'), 'val' => $doctorsCount, 'sub' => __('Registered Professionals'), 'color' => '#02a676'],
        ['label' => __('Licenses'), 'val' => $licensesCount, 'sub' => __('Visible Records'), 'color' => '#351d5b'],
        ['label' => __('Critical Risk'), 'val' => $expiringSoonCount, 'sub' => __('Next :days days', ['days' => $soonDays]), 'color' => '#c93d00'],
      ];
    @endphp

    @foreach($cards as $index => $c)
    <div class="relative group p-8 rounded-lg bg-white dark:bg-[#123338]/30 border border-gray-100 dark:border-white/5 shadow-[0_15px_35px_-15px_rgba(0,0,0,0.05)] transition-all duration-300 hover:shadow-[0_25px_50px_-12px_rgba(0,0,0,0.08)]">
      <div class="relative z-10 flex flex-col items-start h-full">
        <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4">{{ $c['label'] }}</p>

        <div class="text-7xl font-black tracking-tighter text-[#123338] dark:text-white italic leading-none transition-transform duration-500 group-hover:translate-x-2">
          {{ $c['val'] }}
        </div>

        <div class="flex-1 min-h-10"></div>

        <div class="w-full">
          @if($index === 2)
            <div class="grid grid-cols-3 gap-1 overflow-hidden rounded-lg h-1.5 bg-gray-100 dark:bg-white/5">
              <div class="bg-[#02a676]" style="width: 100%"></div>
              <div class="bg-[#f56e2a]" style="width: 100%"></div>
              <div class="bg-[#c93d00]" style="width: 100%"></div>
            </div>
            <div class="mt-3 flex justify-between">
              <div class="flex flex-col">
                <span class="text-[11px] font-black text-[#02a676]">{{ $byStatus['active'] }}</span>
                <span class="text-[7px] font-bold text-gray-400 uppercase">{{ __('Active') }}</span>
              </div>
              <div class="flex flex-col border-x border-gray-100 dark:border-white/5 px-4">
                <span class="text-[11px] font-black text-[#f56e2a]">{{ $byStatus['renovation'] }}</span>
                <span class="text-[7px] font-bold text-gray-400 uppercase">{{ __('Renew.') }}</span>
              </div>
              <div class="flex flex-col">
                <span class="text-[11px] font-black text-[#c93d00]">{{ $byStatus['expired'] }}</span>
                <span class="text-[7px] font-bold text-gray-400 uppercase">{{ __('Exp.') }}</span>
              </div>
            </div>
          @else
            <div class="flex items-center gap-2">
              <div class="h-1 w-8 rounded-full" style="background-color: {{ $c['color'] }}"></div>
              <p class="text-[9px] font-black text-gray-300 dark:text-gray-600 uppercase tracking-[0.2em]">{{ $c['sub'] }}</p>
            </div>
          @endif
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="bg-white dark:bg-[#123338]/10 rounded-lg shadow-2xl shadow-black/2 border border-gray-100 dark:border-white/5 overflow-hidden">
    <div class="p-8 flex items-center justify-between border-b border-gray-50 dark:border-white/5 bg-gray-50/20 dark:bg-white/2">
      <div class="flex items-center gap-4">
        <div class="h-2 w-2 rounded-full bg-[#c93d00] animate-pulse shadow-[0_0_8px_#c93d00]"></div>
        <h2 class="text-sm font-black text-[#123338] dark:text-white uppercase tracking-widest italic">{{ __('Expiration Analysis') }}</h2>
      </div>
      <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-[#123338] border border-gray-100 dark:border-white/5 shadow-sm">
        <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">{{ __('Alert Window:') }}</span>
        <span class="text-[10px] font-black text-[#f56e2a] uppercase italic">{{ __(':days Days', ['days' => $soonDays]) }}</span>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left">
        <thead>
          <tr class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-[0.2em]">
            <th class="px-8 py-5">{{ __('Provider Details') }}</th>
            <th class="px-8 py-5 text-center">{{ __('Jurisdiction') }}</th>
            <th class="px-8 py-5 text-center">{{ __('Due Date') }}</th>
            <th class="px-8 py-5 text-center">{{ __('Status') }}</th>
            <th class="px-8 py-5 text-right">{{ __('Actions') }}</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-white/5">
          @forelse($expiringSoon as $l)
            <tr class="group hover:bg-[#123338]/2 dark:hover:bg-white/2 transition-all duration-300">
              <td class="px-8 py-6">
                <div class="text-sm font-black text-[#123338] dark:text-gray-200 uppercase tracking-tighter italic group-hover:text-[#02a676] transition-colors leading-none">{{ $l->doctor?->user?->name ?? __('Unassigned') }}</div>
                <div class="text-[8px] font-bold text-gray-400 uppercase mt-1.5 tracking-widest">{{ __('Verified Staff') }}</div>
              </td>
              <td class="px-8 py-6 text-center">
                <span class="text-[10px] font-black text-[#123338] dark:text-white bg-gray-100 dark:bg-white/5 px-3 py-1 rounded-lg border border-black/5 dark:border-white/5">{{ $l->state?->code }}</span>
              </td>
              <td class="px-8 py-6 text-center text-xs font-mono font-black text-gray-500 dark:text-gray-400">
                {{ optional($l->expiration_date)->format('d . m . Y') ?? '--' }}
              </td>
              <td class="px-8 py-6">
                <div class="flex justify-center">
                  @php
                    $status = $l->normalized_status;
                    $statusColor = ['active' => '#02a676', 'renovation' => '#f56e2a', 'expired' => '#c93d00'][$status] ?? '#9ca3af';
                    $statusText = ['active' => __('Active'), 'renovation' => __('Renewal'), 'expired' => __('Expired')][$status] ?? $status;
                  @endphp
                  <div class="flex items-center gap-2 px-4 py-1.5 rounded-full border border-gray-100 dark:border-white/5 bg-white dark:bg-transparent shadow-sm">
                    <span class="h-1.5 w-1.5 rounded-full shadow-[0_0_5px_currentColor]" style="background-color: {{ $statusColor }}; color: {{ $statusColor }}"></span>
                    <span class="text-[8px] font-black uppercase text-gray-500 dark:text-gray-400 tracking-widest">{{ $statusText }}</span>
                  </div>
                </div>
              </td>
              <td class="px-8 py-6 text-right">
                <a href="{{ route('licenses.edit', $l) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-gray-50 dark:bg-white/5 text-gray-400 hover:bg-[#123338] hover:text-white dark:hover:bg-white dark:hover:text-[#123338] transition-all shadow-sm group-hover:scale-110">
                  <flux:icon name="pencil-square" class="h-4 w-4" />
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="p-24 text-center">
                <p class="text-[10px] font-black uppercase tracking-[0.5em] opacity-20 italic">{{ __('No Critical Alerts Detected') }}</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
