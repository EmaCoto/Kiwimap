<div x-data x-show="$wire.open" x-cloak class="fixed inset-0 z-50 flex items-start justify-center bg-black/30">
  <div class="mt-6 w-[700px] rounded-lg bg-white p-5 shadow">
    <div class="flex items-center justify-between mb-3">
      <h2 class="font-semibold">Perfil</h2>
      <button class="flex items-center rounded-lg hover:bg-gray-100" wire:click="close"><flux:icon name="x-circle" class="h-6 w-6" /></button>
    </div>

    @if($user)
      <div class="flex items-center gap-3 mb-10">
        <img
          src="{{ $user->avatar_url ?: 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=E5E7EB&color=111827' }}"
          class="h-12 w-12 rounded-full object-cover border"
          alt="Avatar"
        >
        <div class="text-sm">
          <div class="font-semibold">{{ $user->name }}</div>
          <div class="text-gray-600">{{ $user->email }}</div>
        </div>
        <div class="ms-auto">
          @if($user->country_flag_url)
            <img src="{{ $user->country_flag_url }}" alt="{{ strtoupper($user->country_code) }}" title="{{ strtoupper($user->country_code) }}">
          @endif
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 text-md">
        <div>
          <div class="text-xs font-bold ">Número de empleado</div>
          <div class="text-gray-800">{{ $user->employee_number ?: '—' }}</div>
        </div>

        <div>
          <div class="text-xs font-bold ">ID Badge</div>
          <div class="text-gray-800">{{ $user->has_id_badge ? 'Sí' : 'No' }}</div>
        </div>

        <div>
          <div class="text-xs font-bold ">Cumpleaños</div>
          <div class="text-gray-800">{{ $user->birthday_long ?: '—' }}</div>
        </div>

        <div>
          <div class="text-xs font-bold ">Aniversario Dr. Kiwimed</div>
          <div class="text-gray-800">{{ $user->anniversary_kiwimed_long ?: '—' }}</div>
        </div>

        <div>
          <div class="text-xs font-bold ">Aniversario Grupo Empresarial</div>
          <div class="text-gray-800">{{ $user->anniversary_group_long ?: '—' }}</div>
        </div>

        <div>
          <div class="text-xs font-bold ">País</div>
          <div class="text-gray-800">{{ strtoupper($user->country_code ?? '—') }}</div>
        </div>

        <div>
          <div class="text-xs font-bold ">Número Spruce</div>
          <div class="text-gray-800">{{ $user->spruce_number ?: '—' }}</div>
        </div>

        <div>
          <div class="text-xs font-bold ">Número Crecer</div>
          <div class="text-gray-800">{{ $user->crecer_number ?: '—' }}</div>
        </div>
      </div>
    @else
      <div class="p-4 text-center text-gray-500">Sin datos.</div>
    @endif
  </div>
</div>
