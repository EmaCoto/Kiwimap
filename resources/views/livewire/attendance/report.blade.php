<div x-data="{ open:false }"
     x-on:open-attendance.window="if($event.detail.userId){open=true; $wire.open($event.detail)}"
     x-show="open"
     class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-white rounded-xl shadow-lg w-full max-w-3xl p-6">
    @if($user)
      <h2 class="text-xl font-semibold mb-3">Asistencia — {{ $user->name }}</h2>
      <table class="w-full text-sm border">
        <thead class="bg-neutral-100">
          <tr>
            <th class="p-2">Fecha</th>
            <th class="p-2">Entrada</th>
            <th class="p-2">Break</th>
            <th class="p-2">Lunch</th>
            <th class="p-2">Salida</th>
            <th class="p-2">Horas</th>
            <th class="p-2">Estado</th>
          </tr>
        </thead>
        <tbody>
          @forelse($attendances as $a)
            <tr>
              <td class="p-2">{{ $a->created_at->format('M d, Y') }}</td>
              <td class="p-2">{{ optional($a->clock_in)->format('H:i') ?? '—' }}</td>
              <td class="p-2">
                {{ optional($a->break_start)->format('H:i') ?? '—' }} /
                {{ optional($a->break_end)->format('H:i') ?? '—' }}
              </td>
              <td class="p-2">
                {{ optional($a->lunch_start)->format('H:i') ?? '—' }} /
                {{ optional($a->lunch_end)->format('H:i') ?? '—' }}
              </td>
              <td class="p-2">{{ optional($a->clock_out)->format('H:i') ?? '—' }}</td>
              <td class="p-2">{{ $a->worked_hours }}</td>
              <td class="p-2">{{ ucfirst($a->status) }}</td>
            </tr>
          @empty
            <tr><td colspan="7" class="p-4 text-center text-gray-500">Sin registros</td></tr>
          @endforelse
        </tbody>
      </table>
    @endif
    <div class="mt-4 flex justify-end">
      <button @click="open=false" class="px-4 py-2 bg-gray-900 text-white rounded">Cerrar</button>
    </div>
  </div>
</div>
