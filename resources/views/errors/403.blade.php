<x-layouts.app :title="__('403 - No autorizado')">
  <div class="max-w-lg mx-auto mt-16 p-6 rounded-xl border bg-white dark:bg-neutral-900">
    <h1 class="text-2xl font-semibold mb-2">Acceso denegado</h1>
    <p class="text-sm text-gray-600 dark:text-gray-300">
      No tienes autorización para acceder a esta página.
    </p>

    @if(session('error'))
      <div class="mt-4 p-3 rounded bg-rose-50 text-rose-700 text-sm">
        {{ session('error') }}
      </div>
    @endif

    <div class="mt-6 flex gap-3">
      <a href="{{ url()->previous() }}" class="px-3 py-2 text-sm rounded border">Volver</a>
      <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm rounded bg-gray-900 text-white">Ir al dashboard</a>
    </div>
  </div>
</x-layouts.app>
