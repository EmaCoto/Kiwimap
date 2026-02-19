<div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl font-sans text-[#123338] dark:text-white transition-colors duration-300">

  {{-- Header: Estilo Ejecutivo --}}
  <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
    <div class="space-y-1">
      <div class="flex items-center gap-2">
        <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
        <h1 class="text-3xl font-black tracking-tighter uppercase italic">Convertidor de Unidades</h1>
      </div>
      <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3">Sistema de Conversión / Datos en Vivo</p>
    </div>
  </div>

  {{-- Grid de Convertidores --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="relative group p-8 rounded-lg bg-white dark:bg-[#123338]/30 border border-gray-100 dark:border-white/5 shadow-[0_15px_35px_-15px_rgba(0,0,0,0.05)] transition-all duration-300">
      <div class="relative z-10 flex flex-col items-start h-full">
        <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4">Longitud (Métrica a Imperial)</p>

        <div class="w-full space-y-4">
          <div>
            <label class="text-[9px] font-black uppercase tracking-widest text-[#02a676] mb-1 block">Metros (m)</label>
            <input type="number" id="inputMetros" placeholder="0.00"
              class="w-full bg-gray-50 dark:bg-[#123338] border-none text-4xl font-black italic tracking-tighter focus:ring-2 focus:ring-[#351d5b] rounded-xl p-4 transition-all"
              oninput="convertirLongitud()">
          </div>

          <div class="flex gap-4 mt-6">
            <div class="flex-1">
              <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Pies (ft)</p>
              <div id="resPies" class="text-4xl font-black italic tracking-tighter text-[#123338] dark:text-white">0</div>
            </div>
            <div class="flex-1 border-l border-gray-100 dark:border-white/5 pl-4">
              <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Pulgadas (in)</p>
              <div id="resPulgadas" class="text-4xl font-black italic tracking-tighter text-[#6fa31c]">0</div>
            </div>
          </div>
        </div>

        <div class="mt-8 flex items-center gap-2">
          <div class="h-1 w-8 rounded-full bg-[#351d5b]"></div>
          <p class="text-[9px] font-black text-gray-300 dark:text-gray-600 uppercase tracking-[0.2em]">Cálculo de Precisión Estándar</p>
        </div>
      </div>
    </div>

    <div class="relative group p-8 rounded-lg bg-white dark:bg-[#123338]/30 border border-gray-100 dark:border-white/5 shadow-[0_15px_35px_-15px_rgba(0,0,0,0.05)] transition-all duration-300">
      <div class="relative z-10 flex flex-col items-start h-full">
        <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4">Masa (Kilos a Libras)</p>

        <div class="w-full space-y-4">
          <div>
            <label class="text-[9px] font-black uppercase tracking-widest text-[#f56e2a] mb-1 block">Kilogramos (kg)</label>
            <input type="number" id="inputKilos" placeholder="0.00"
              class="w-full bg-gray-50 dark:bg-[#123338] border-none text-4xl font-black italic tracking-tighter focus:ring-2 focus:ring-[#c93d00] rounded-xl p-4 transition-all"
              oninput="convertirPeso()">
          </div>

          <div class="mt-6">
            <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Libras (lb)</p>
            <div id="resLibras" class="text-7xl font-black italic tracking-tighter text-[#123338] dark:text-white transition-transform group-hover:translate-x-2">
              0.00
            </div>
          </div>
        </div>

        <div class="mt-8 flex items-center gap-2">
          <div class="h-1 w-8 rounded-full bg-[#c93d00]"></div>
          <p class="text-[9px] font-black text-gray-300 dark:text-gray-600 uppercase tracking-[0.2em]">Factor: 1 kg ≈ 2.20462 lb</p>
        </div>
      </div>
    </div>

  </div>

  {{-- Footer Info --}}
  <div class="bg-white dark:bg-[#123338]/10 rounded-lg border border-gray-100 dark:border-white/5 p-4 flex justify-between items-center">
    <div class="flex items-center gap-4">
      <div class="h-2 w-2 rounded-full bg-[#02a676] animate-pulse shadow-[0_0_8px_#02a676]"></div>
      <h2 class="text-[10px] font-black uppercase tracking-widest italic opacity-60">Motor de conversión activo</h2>
    </div>
    <div class="text-[9px] font-black text-gray-400 uppercase">v1.0.0 Global</div>
  </div>
</div>

<script>
  function convertirLongitud() {
    const metros = document.getElementById('inputMetros').value;
    if (metros === '' || metros < 0) {
      document.getElementById('resPies').innerText = '0';
      document.getElementById('resPulgadas').innerText = '0';
      return;
    }

    // 1 metro = 39.3701 pulgadas
    const totalPulgadas = metros * 39.3701;
    const pies = Math.floor(totalPulgadas / 12);
    const pulgadasRestantes = (totalPulgadas % 12).toFixed(1);

    document.getElementById('resPies').innerText = pies;
    document.getElementById('resPulgadas').innerText = pulgadasRestantes;
  }

  function convertirPeso() {
    const kilos = document.getElementById('inputKilos').value;
    if (kilos === '' || kilos < 0) {
      document.getElementById('resLibras').innerText = '0.00';
      return;
    }

    // 1 kilo = 2.20462 libras
    const libras = (kilos * 2.20462).toFixed(2);
    document.getElementById('resLibras').innerText = libras;
  }
</script>
