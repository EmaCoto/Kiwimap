<div class="p-6 space-y-6">
  <div class="flex items-center justify-between gap-3">
    <h1 class="text-xl font-semibold">Usuarios</h1>
    @can('create', \App\Models\User::class)
      <a href="{{ route('users.create') }}" class="flex items-center px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#6fa31c] to-[#123338] transition ease-in-out duration-300 text-sm hover:scale-105  font-semibold">
        <flux:icon name="user-plus" class="h-4 w-4 mr-2" />Agregar usuario
      </a>
    @endcan
  </div>

  @if (session('ok'))
    <div class="p-3 rounded border-l-2 border-green-800 bg-green-100 text-green-800 text-sm flex items-center"><flux:icon name="bell" class="h-4 w-4 mr-4" />{{ session('ok') }}</div>
  @endif
  @if (session('error'))
    <div class="p-3 rounded border-l-2 border-rose-800 bg-rose-100 text-rose-800 text-sm flex items-center"><flux:icon name="bell" class="h-4 w-4 mr-4" />{{ session('error') }}</div>
  @endif

  {{-- CONTENEDOR DE FILTROS ACTUALIZADO --}}
  <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
    {{-- FILTRO POR ROL (NUEVO) --}}
    <div>
        <label class="block text-xs font-medium mb-1">Rol</label>
        <select wire:model.live="roleName" class="w-full border rounded p-2 text-sm">
            <option value="" class="dark:text-black">Todos</option>
            @foreach($roles as $r)
                <option value="{{ $r->name }}" class="dark:text-black">{{ ucfirst($r->name) }}</option>
            @endforeach
        </select>
    </div>

    {{-- BÚSQUEDA GENERAL (Expandido a 3 columnas)--}}
    <div class="md:col-span-3">
        <label class="block text-xs font-medium mb-1">Buscar</label>
        {{-- Placeholder actualizado para incluir ID y rol --}}
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="ID, nombre, email o rol…" class="w-full border rounded p-2 text-sm">
    </div>
  </div>

  <div class="flex justify-between items-center">
    {{-- BOTÓN DE LIMPIAR FILTROS (usando el nuevo método) --}}
    <button wire:click="clearFilters" class="bg-white dark:bg-transparent text-center w-42 rounded-2xl h-14 relative text-black text-sm font-semibold group cursor-pointer" type="button">
        <div class="bg-gradient-to-b active:bg-gradient-to-t from-[#6fa31c] to-[#123338] rounded-lg h-10 w-1/5 flex items-center justify-center absolute left-1 top-[10px] group-hover:w-[150px] z-10 hover:shadow transform duration-500 ease-in-out">
            <flux:icon name="paint-brush" class="h-4 w-4 text-white" />
        </div>
        <p class="translate-x-2 dark:text-white">Limpiar filtro</p>
    </button>
    
    <div class="text-xs text-gray-500">
      Total: {{ $users->total() }}
    </div>
  </div>


  <div class="overflow-auto rounded border">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 text-left dark:text-black">
        <tr>
          <th class="p-2">ID</th> {{-- NUEVA COLUMNA ID --}}
          <th class="p-2">Foto</th> {{-- NUEVA COLUMNA FOTO --}}
          <th class="p-2">Nombre</th>
          <th class="p-2">Email</th>
          <th class="p-2">Roles</th>
          <th class="p-2">País</th>
          <th class="p-2 w-36">Acciones</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse($users as $u)
          <tr class="hover:bg-gray-100 dark:hover:text-black">
            <td class="p-2 whitespace-nowrap">{{ $u->id }}</td> {{-- ID del Usuario --}}
            
            {{-- CELDA DE LA FOTO --}}
            <td class="p-2 whitespace-nowrap">
                @php 
                    $src = $u->avatar_url; 
                    $placeholder = 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=E5E7EB&color=111827';
                @endphp
                <img
                    src="{{ $src ?: $placeholder }}"
                    alt="{{ $u->name }} Avatar"
                    class="h-8 w-8 rounded-full object-cover border"
                >
            </td>

            <td class="p-2 whitespace-nowrap">
              <button
                type="button"
                wire:click="$dispatch('open-attendance', { userId: {{ $u->id }} })"
                class="hover:cursor-pointer hover:text-[#4b4a4a] font-medium">
                {{ $u->name }}
              </button>
            </td>
            <td class="p-2">{{ $u->email }}</td>
            <td class="p-2 whitespace-nowrap">
                {{-- Muestra los roles con estilo --}}
                @forelse($u->roles as $role)
                    <span class="px-2 py-0.5 rounded text-xs bg-indigo-100 text-indigo-800">{{ ucfirst($role->name) }}</span>
                @empty
                    <span class="text-xs text-gray-500">—</span>
                @endforelse
            </td>

            <td class="p-2 whitespace-nowrap">
              @php $flag = $u->country_flag_url; @endphp
              @if($flag)
                <img src="{{ $flag }}" alt="{{ strtoupper($u->country_code) }}" title="{{ strtoupper($u->country_code) }}">
              @else
                <span class="text-xs text-gray-500">—</span>
              @endif
            </td>


            <td class="p-2 align-middle">
              <div class="flex items-center space-x-2">
                @can('update', $u)
                  <a href="{{ route('users.edit', $u) }}" class="text-blue-600 hover:text-black text-xs"><flux:icon name="pencil-square" class="h-4 w-4" /></a>
                @endcan
                <button type="button" class="text-green-700 hover:text-black text-xs cursor-pointer" wire:click="$dispatch('open-user-details', { userId: {{ $u->id }} })" title="Ver detalles"><flux:icon name="eye" class="h-4 w-4" /></button>
                @can('delete', $u)
                  <button x-data @click.prevent="if (confirm('¿Eliminar este usuario?')) { $wire.delete({{ $u->id }}) }" type="button" class="text-rose-600 hover:text-black text-xs cursor-pointer"> <flux:icon name="trash" class="h-4 w-4" /> </button>
                @endcan
              </div>
            </td>

          </tr>
        @empty
          {{-- El colspan debe ser 6 --}}
          <tr><td colspan="6" class="p-4 text-center text-gray-500">Sin resultados.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <livewire:users.attendance-modal :key="'users-attendance-modal'" />
  <livewire:users.user-details-modal :key="'users-user-details-modal'" />

  <div>
    {{ $users->links() }}
  </div>
</div>