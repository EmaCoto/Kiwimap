<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
  {{-- Cards métricas --}}
  <div class="grid auto-rows-min gap-4 md:grid-cols-4">
    <div class="relative overflow-hidden rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t dark:bg-gradient-to-b from-[#6fa31c] to-[#123338] hover:bg-none transition ease-in-out duration-300 p-5">
      <p class="text-xs text-gray-300 dark:group-hover:text-gray-300 group-hover:text-neutral-500 mb-2">Estados operando</p>
      <div class="text-3xl text-gray-100 dark:group-hover:text-gray-100 group-hover:text-black font-semibold">{{ $operationalStates }}</div>
    </div>

    <div class="relative overflow-hidden rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t dark:bg-gradient-to-b from-[#6fa31c] to-[#123338] hover:bg-none transition ease-in-out duration-300 p-5">
      <p class="text-xs text-gray-300 dark:group-hover:text-gray-300 group-hover:text-neutral-500 mb-2">Doctores</p>
      <div class="text-3xl text-gray-100 dark:group-hover:text-gray-100 group-hover:text-black font-semibold">{{ $doctorsCount }}</div>
    </div>

    <div class="relative overflow-hidden rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t dark:bg-gradient-to-b from-[#6fa31c] to-[#123338] hover:bg-none transition ease-in-out duration-300 p-5">
      <p class="text-xs text-gray-300 dark:group-hover:text-gray-300 group-hover:text-neutral-500 mb-2">Licencias</p>
      <div class="text-3xl text-gray-100 dark:group-hover:text-gray-100 group-hover:text-black font-semibold">{{ $licensesCount }}</div>
      <div class="mt-3 flex gap-2 text-xs">
        <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">AC: {{ $byStatus['active'] }}</span>
        <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800">PD: {{ $byStatus['pending'] }}</span>
        <span class="px-2 py-0.5 rounded bg-rose-100 text-rose-800">VC: {{ $byStatus['expired'] }}</span>
      </div>
    </div>

    <div class="relative overflow-hidden rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t dark:bg-gradient-to-b from-[#6fa31c] to-[#123338] hover:bg-none transition ease-in-out duration-300 p-5">
      <p class="text-xs text-gray-300 dark:group-hover:text-gray-300 group-hover:text-neutral-500 mb-2">Próximas a vencer</p>
      <div class="text-3xl text-gray-100 dark:group-hover:text-gray-100 group-hover:text-black font-semibold">{{ $expiringSoonCount }}</div>
      <p class="mt-1 text-xs text-gray-300 group-hover:text-neutral-500">en {{ $soonDays }} días</p>
    </div>
  </div>

  {{-- Tabla: Próximas a vencer --}}
  <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    <div class="p-5 flex items-center justify-between">
      <h2 class="font-semibold">Licencias próximas a vencer</h2>
      <div class="flex items-center gap-2 text-sm">
        <span class="text-neutral-500">Rango:</span>
        <span class="px-2 py-0.5 rounded bg-neutral-100 dark:bg-neutral-800">{{ $soonDays }} días</span>
        {{-- Puedes convertir esto a input para cambiar soonDays vía URL/Livewire si quieres --}}
      </div>
    </div>

    <div class="overflow-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-neutral-100 dark:bg-neutral-900/30 text-left">
          <tr>
            <th class="p-3">Doctor</th>
            <th class="p-3">Estado</th>
            <th class="p-3">Expira</th>
            <th class="p-3">Status</th>
            <th class="p-3 w-28">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @forelse($expiringSoon as $l)
            <tr class="hover:bg-neutral-100 dark:hover:bg-neutral-900/20">
              <td class="p-3 whitespace-nowrap">
                {{ $l->doctor?->user?->name ?? '—' }}
              </td>
              <td class="p-3 whitespace-nowrap">
                {{ $l->state?->name }} ({{ $l->state?->code }})
              </td>
              <td class="p-3 whitespace-nowrap">
                {{ optional($l->expiration_date)->toDateString() ?? '—' }}
              </td>
              <td class="p-3">
                @php
                  $badge = [
                    'active' => 'bg-emerald-100 text-emerald-800',
                    'pending'=> 'bg-amber-100 text-amber-800',
                    'expired'=> 'bg-rose-100 text-rose-800'
                  ][$l->status] ?? 'bg-neutral-100 text-neutral-800';
                @endphp
                <span class="px-2 py-0.5 rounded text-xs {{ $badge }}">{{ ucfirst($l->status) }}</span>
              </td>
              <td class="p-3 text-right">
                  <a href="{{ route('licenses.edit', $l) }}" class="flex items-center space-x-1 text-blue-800 hover:text-blue-800/70 dark:text-white text-xs">
                      <flux:icon name="pencil-square" class="h-4 w-4" />
                      <span>Editar</span>
                  </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="p-6 text-center text-neutral-500">
                No hay licencias por vencer en los próximos {{ $soonDays }} días.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
