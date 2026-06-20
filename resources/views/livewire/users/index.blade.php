<div class="p-8 space-y-8 bg-[#fcfcfc] dark:bg-[#0d1516] min-h-screen">
  <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 dark:border-white/5 pb-6">
    <div class="space-y-1">
        <div class="flex items-center gap-2">
            <span class="h-6 w-1 bg-[#351d5b] rounded-full"></span>
            <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">Directorio de Usuarios</h1>
        </div>
        <p class="text-[10px] font-black text-[#6fa31c] uppercase tracking-[0.3em] ml-3">Gestion de Accesos y Talento</p>
    </div>

    @can('create', \App\Models\User::class)
      <a href="{{ route('users.create') }}" class="flex items-center px-6 py-3 bg-gradient-to-t from-[#123338] to-[#1a444a] text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl hover:scale-105 active:scale-95 transition-all">
        <flux:icon name="user-plus" class="h-4 w-4 mr-2" />Agregar usuario
      </a>
    @endcan
  </div>

  @if (session('ok'))
    <div class="p-4 rounded-2xl bg-[#02a676]/10 border border-[#02a676]/20 text-[#02a676] text-[10px] font-black uppercase tracking-widest flex items-center">
        <flux:icon name="bell" class="h-4 w-4 mr-3" />{{ session('ok') }}
    </div>
  @endif
  @if (session('error'))
    <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 text-rose-600 text-[10px] font-black uppercase tracking-widest flex items-center">
        <flux:icon name="bell" class="h-4 w-4 mr-3" />{{ session('error') }}
    </div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end bg-white dark:bg-white/5 p-6 rounded-3xl border border-gray-100 dark:border-white/5 shadow-sm">
    <div>
        <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Filtrar por Rol</label>
        <select wire:model.live="roleName" class="w-full bg-gray-50 dark:bg-[#123338]/40 border-none rounded-xl p-3 text-xs font-bold focus:ring-2 focus:ring-[#6fa31c] transition-all">
            <option value="">Todos los niveles</option>
            @foreach($roles as $r)
                <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-3">
        <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Busqueda Maestra</label>
        <div class="relative">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="ID, nombre, email o rol..." class="w-full bg-gray-50 dark:bg-[#123338]/40 border-none rounded-xl p-3 pl-10 text-xs font-bold focus:ring-2 focus:ring-[#6fa31c] transition-all">
            <flux:icon name="magnifying-glass" class="absolute left-3 top-3 h-4 w-4 text-gray-400" />
        </div>
    </div>
  </div>

  <div class="flex justify-between items-center px-2">
    <button wire:click="clearFilters" class="group flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-[#123338] transition-colors hover:cursor-pointer active:text-white">
        <div class="h-8 w-8 rounded-lg bg-gray-100 dark:bg-white/5 flex items-center justify-center group-hover:bg-[#6fa31c] group-hover:text-white transition-all">
            <flux:icon name="paint-brush" class="h-4 w-4" />
        </div>
        Limpiar filtros
    </button>

    <div class="px-4 py-1 rounded-full bg-gray-100 dark:bg-white/5 text-[9px] font-black text-gray-500 uppercase tracking-tighter">
      Total Usuarios: <span class="text-[#123338] dark:text-white">{{ $users->total() }}</span>
    </div>
  </div>

  <div class="overflow-hidden rounded-3xl border border-gray-100 dark:border-white/5 bg-white dark:bg-white/5 shadow-sm">
    <div class="overflow-x-auto">
      <table class="min-w-full border-collapse">
        <thead>
          <tr class="bg-gray-50 dark:bg-[#123338]/40 border-b border-gray-100 dark:border-white/10 text-left">
            <th class="p-4 text-[9px] font-black text-gray-400 uppercase tracking-[0.2em]">ID</th>
            <th class="p-4 text-[9px] font-black text-gray-400 uppercase tracking-[0.2em]">Perfil</th>
            <th class="p-4 text-[9px] font-black text-gray-400 uppercase tracking-[0.2em]">Usuario</th>
            <th class="p-4 text-[9px] font-black text-gray-400 uppercase tracking-[0.2em]">Email</th>
            <th class="p-4 text-[9px] font-black text-gray-400 uppercase tracking-[0.2em]">Nivel / Roles</th>
            <th class="p-4 text-[9px] font-black text-gray-400 uppercase tracking-[0.2em]">Pais</th>
            <th class="p-4 text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-white/5">
          @forelse($users as $u)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors group">
              <td class="p-4 text-[11px] font-mono font-black text-gray-400 italic">#{{ $u->id }}</td>

              <td class="p-4">
                @php
                  $avatar = $u->avatar_url ?: 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=123338&color=ffffff';
                @endphp
                <img src="{{ $avatar }}" class="h-10 w-10 rounded-xl object-cover border border-gray-100 dark:border-white/10 shadow-sm transition-transform group-hover:scale-110">
              </td>

              <td class="p-4">
                <div class="text-[11px] font-black text-[#123338] dark:text-white uppercase italic tracking-tight">{{ $u->name }}</div>
                <div class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Perfil de usuario</div>
              </td>

              <td class="p-4 text-[11px] font-bold text-gray-500 lowercase">{{ $u->email }}</td>

              <td class="p-4">
                <div class="flex flex-wrap gap-1">
                  @forelse($u->roles as $role)
                    <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase tracking-tighter bg-[#351d5b]/10 text-[#351d5b] dark:bg-indigo-500/10 dark:text-indigo-300">
                        {{ $role->name }}
                    </span>
                  @empty
                    <span class="text-[9px] font-black text-gray-300 uppercase italic">Sin Rol</span>
                  @endforelse
                </div>
              </td>

              <td class="p-4">
                @php $flag = $u->country_flag_url; @endphp
                @if($flag)
                  <img src="{{ $flag }}" alt="{{ $u->country_code }}" class="h-auto w-6 block opacity-100 border-0 shadow-none ring-0">
                @else
                  <span class="text-[10px] font-black text-gray-300">-</span>
                @endif
              </td>

              <td class="p-4 text-right">
                <div class="flex items-center justify-end gap-2 opacity-40 group-hover:opacity-100 transition-opacity">
                  @can('update', $u)
                    <a href="{{ route('users.edit', $u) }}" class="p-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors" title="Editar">
                        <flux:icon name="pencil-square" class="h-4 w-4" />
                    </a>
                  @endcan

                  <button type="button" wire:click="$dispatch('open-user-details', { userId: {{ $u->id }} })" class="p-2 rounded-lg hover:bg-emerald-50 hover:text-emerald-600 transition-colors cursor-pointer" title="Ver detalles">
                      <flux:icon name="eye" class="h-4 w-4" />
                  </button>

                  @can('delete', $u)
                    <button x-data @click.prevent="if (confirm('Eliminar este usuario?')) { $wire.delete({{ $u->id }}) }" type="button" class="p-2 rounded-lg hover:bg-rose-50 hover:text-rose-600 transition-colors cursor-pointer" title="Eliminar">
                        <flux:icon name="trash" class="h-4 w-4" />
                    </button>
                  @endcan
                </div>
              </td>
            </tr>
          @empty
            <tr>
                <td colspan="7" class="p-10 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.5em]">No se encontraron usuarios</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <livewire:users.user-details-modal :key="'users-user-details-modal'" />

  <div class="pt-4">
    {{ $users->links() }}
  </div>
</div>