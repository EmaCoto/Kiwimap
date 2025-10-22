<x-layouts.auth :title="__('404 - Página no encontrada')">
  <div class="max-w-lg mx-auto mt-16 p-6 rounded-xl border bg-white dark:bg-neutral-900">
    <h1 class="text-2xl font-semibold mb-2">Página no encontrada</h1>
    <p class="text-sm text-gray-600 dark:text-gray-300">
      Lo sentimos, la página que buscas no existe o fue movida.
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
</x-layouts.auth>
