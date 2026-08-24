<x-layouts.app :title="__('measurement_converter')">
    <div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl font-sans text-white transition-colors duration-300">

    {{-- Header: Executive Style --}}
    <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
                <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">{{ __('Precision Converter') }}</h1>
            </div>
            <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3">{{ __('System Metrics / Unit Analysis') }}</p>
        </div>
    </div>

    {{-- Converter Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="relative group p-8 rounded-lg bg-white dark:bg-[#123338]/30 border border-gray-100 dark:border-white/5 shadow-[0_15px_35px_-15px_rgba(0,0,0,0.05)] transition-all duration-300">
            <div class="relative z-10 flex flex-col items-start h-full">
                <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4">{{ __('Length (Metric to Imperial)') }}</p>

                <div class="w-full space-y-4">
                    <div>
                        <label class="text-[9px] font-black uppercase tracking-widest text-[#02a676] mb-1 block">{{ __('Meters (m)') }}</label>
                        <input type="number" id="inputMetros" placeholder="0.00" step="0.01"
                        class="w-full bg-gray-50 dark:bg-[#123338] border-none text-4xl font-black italic tracking-tighter text-[#123338] dark:text-white focus:ring-2 focus:ring-[#351d5b] rounded-xl p-4 transition-all"
                        oninput="convertirLongitud()">
                    </div>

                    <div class="flex flex-col gap-4 mt-6">
                        <div class="flex justify-between items-end border-b border-gray-100 dark:border-white/5 pb-2">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Feet (ft)') }}</p>
                        <div id="resPies" class="text-5xl font-black italic tracking-tighter text-[#123338] dark:text-white">0.00</div>
                        </div>
                        <div class="flex justify-between items-end">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Inches (in)') }}</p>
                        <div id="resPulgadas" class="text-5xl font-black italic tracking-tighter text-[#6fa31c] dark:text-white">0.00</div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center gap-2">
                    <div class="h-1 w-8 rounded-full bg-[#351d5b]"></div>
                    <p class="text-[9px] font-black text-gray-500 dark:text-gray-100 uppercase tracking-[0.2em]">{{ __('High Fidelity Conversion') }}</p>
                </div>
            </div>
        </div>

        <div class="relative group p-8 rounded-lg bg-white dark:bg-[#123338]/30 border border-gray-100 dark:border-white/5 shadow-[0_15px_35px_-15px_rgba(0,0,0,0.05)] transition-all duration-300">
            <div class="relative z-10 flex flex-col items-start h-full">
                <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4">{{ __('Mass (Kilograms to Pounds)') }}</p>

                <div class="w-full space-y-4">
                    <div>
                        <label class="text-[9px] font-black uppercase tracking-widest text-[#f56e2a] mb-1 block">{{ __('Kilograms (kg)') }}</label>
                        <input type="number" id="inputKilos" placeholder="0.00" step="0.01"
                        class="w-full bg-gray-50 dark:bg-[#123338] border-none text-4xl font-black italic tracking-tighter text-[#123338] dark:text-white focus:ring-2 focus:ring-[#c93d00] rounded-xl p-4 transition-all"
                        oninput="convertirPeso()">
                    </div>

                    <div class="mt-6">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1 tracking-widest">{{ __('Pounds (lb)') }}</p>
                        <div id="resLibras" class="text-7xl font-black italic tracking-tighter text-[#123338] dark:text-white transition-transform group-hover:translate-x-2">0.00</div>
                    </div>
                </div>

                <div class="mt-8 flex items-center gap-2">
                    <div class="h-1 w-8 rounded-full bg-[#c93d00]"></div>
                    <p class="text-[9px] font-black text-gray-500 dark:text-gray-100 uppercase tracking-[0.2em]">{{ __('Constant: 2.20462 lb/kg') }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Header: Executive Style --}}
    <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
                <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">{{ __('Body Mass Index (BMI)') }}</h1>
            </div>
            <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3">{{ __('System Metrics / Unit Analysis') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <section class="lg:col-span-3 rounded-lg bg-white dark:bg-[#123338]/30 border border-gray-100 dark:border-white/5 p-6 md:p-8 shadow-[0_15px_35px_-15px_rgba(0,0,0,0.05)]" aria-labelledby="bmi-title">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 id="bmi-title" class="text-lg font-black text-[#123338] dark:text-white uppercase">{{ __('BMI Calculator') }}</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">{{ __('Enter the patient height and weight.') }}</p>
                </div>
                <div class="inline-flex self-start rounded-xl bg-gray-100 dark:bg-[#0d1516] p-1" role="group" aria-label="{{ __('Unit system') }}">
                    <button type="button" id="bmiMetricButton" class="rounded-lg px-4 py-2 text-[10px] font-black uppercase tracking-widest bg-[#351d5b] text-white" aria-pressed="true">{{ __('Metric') }}</button>
                    <button type="button" id="bmiImperialButton" class="rounded-lg px-4 py-2 text-[10px] font-black uppercase tracking-widest text-gray-500 dark:text-gray-300" aria-pressed="false">{{ __('Imperial') }}</button>
                </div>
            </div>
            <form id="bmiForm" novalidate>
                <div id="bmiMetricFields" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="bmiWeightKg" class="text-[9px] font-black uppercase tracking-widest text-[#02a676] mb-1 block">{{ __('Weight (kg)') }}</label>
                        <input type="number" id="bmiWeightKg" min="1" max="500" step="0.1" inputmode="decimal" placeholder="70.0" class="w-full bg-gray-50 dark:bg-[#123338] border-none text-3xl font-black italic text-[#123338] dark:text-white focus:ring-2 focus:ring-[#351d5b] rounded-xl p-4">
                    </div>
                    <div>
                        <label for="bmiHeightCm" class="text-[9px] font-black uppercase tracking-widest text-[#02a676] mb-1 block">{{ __('Height (cm)') }}</label>
                        <input type="number" id="bmiHeightCm" min="30" max="275" step="0.1" inputmode="decimal" placeholder="170.0" class="w-full bg-gray-50 dark:bg-[#123338] border-none text-3xl font-black italic text-[#123338] dark:text-white focus:ring-2 focus:ring-[#351d5b] rounded-xl p-4">
                    </div>
                </div>
                <div id="bmiImperialFields" class="hidden grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="bmiWeightLb" class="text-[9px] font-black uppercase tracking-widest text-[#02a676] mb-1 block">{{ __('Weight (lb)') }}</label>
                        <input type="number" id="bmiWeightLb" min="2" max="1100" step="0.1" inputmode="decimal" placeholder="154.0" class="w-full bg-gray-50 dark:bg-[#123338] border-none text-3xl font-black italic text-[#123338] dark:text-white focus:ring-2 focus:ring-[#351d5b] rounded-xl p-4">
                    </div>
                    <div>
                        <label for="bmiHeightFt" class="text-[9px] font-black uppercase tracking-widest text-[#02a676] mb-1 block">{{ __('Height (ft)') }}</label>
                        <input type="number" id="bmiHeightFt" min="1" max="9" step="1" inputmode="numeric" placeholder="5" class="w-full bg-gray-50 dark:bg-[#123338] border-none text-3xl font-black italic text-[#123338] dark:text-white focus:ring-2 focus:ring-[#351d5b] rounded-xl p-4">
                    </div>
                    <div>
                        <label for="bmiHeightIn" class="text-[9px] font-black uppercase tracking-widest text-[#02a676] mb-1 block">{{ __('Additional inches (in)') }}</label>
                        <input type="number" id="bmiHeightIn" min="0" max="11.9" step="0.1" inputmode="decimal" placeholder="7" class="w-full bg-gray-50 dark:bg-[#123338] border-none text-3xl font-black italic text-[#123338] dark:text-white focus:ring-2 focus:ring-[#351d5b] rounded-xl p-4">
                    </div>
                </div>
                <div class="flex items-center justify-between gap-4 mt-5">
                    <p id="bmiError" class="text-xs font-bold text-red-600 dark:text-red-400" role="alert" aria-live="polite"></p>
                    <button type="reset" class="ml-auto rounded-xl border border-gray-200 dark:border-white/10 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-gray-500 dark:text-gray-200">{{ __('Clear') }}</button>
                </div>
            </form>
        </section>
        <section class="lg:col-span-2 rounded-lg bg-[#123338] dark:bg-[#351d5b]/40 p-6 md:p-8 flex flex-col justify-between" aria-live="polite" aria-atomic="true">
            <div>
                <p class="text-[10px] font-black text-[#7bdcb5] uppercase tracking-widest">{{ __('Calculated BMI') }}</p>
                <div id="bmiResult" class="text-7xl font-black italic tracking-tighter text-white mt-2">--</div>
                <div id="bmiCategory" class="inline-flex mt-3 rounded-full bg-white/10 px-3 py-1 text-xs font-black uppercase tracking-widest text-white">{{ __('Waiting for data') }}</div>
            </div>
            <div class="mt-8 border-t border-white/10 pt-5">
                <p class="text-xs leading-relaxed text-gray-300">{{ __('Adult BMI categories: underweight below 18.5, healthy weight 18.5–24.9, overweight 25.0–29.9, and obesity 30.0 or above.') }}</p>
                <p class="text-[10px] leading-relaxed text-gray-400 mt-3">{{ __('BMI is a screening measure and does not replace clinical assessment. These categories are intended for adults and are not applicable to pregnancy or pediatric patients.') }}</p>
            </div>
        </section>
    </div>

    {{-- Footer Info --}}
    <div class="bg-white dark:bg-[#123338]/10 rounded-lg border border-gray-100 dark:border-white/5 p-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <div class="h-2 w-2 rounded-full bg-[#02a676] animate-pulse shadow-[0_0_8px_#02a676]"></div>
            <h2 class="text-[10px] font-black uppercase tracking-widest italic text-gray-400 dark:text-white">{{ __('Active Processing Engine') }}</h2>
        </div>
    </div>
    </div>

    <script>
    function convertirLongitud() {
        const metros = document.getElementById('inputMetros').value;
        const resPies = document.getElementById('resPies');
        const resPulgadas = document.getElementById('resPulgadas');

        if (metros === '' || metros < 0) {
        resPies.innerText = '0.00';
        resPulgadas.innerText = '0.00';
        return;
        }

        // 1 meter = 3.28084 feet
        const feetTotal = (metros * 3.28084).toFixed(2);
        // 1 meter = 39.3701 inches
        const inchesTotal = (metros * 39.3701).toFixed(2);

        resPies.innerText = feetTotal;
        resPulgadas.innerText = inchesTotal;
    }

    function convertirPeso() {
        const kilos = document.getElementById('inputKilos').value;
        const resLibras = document.getElementById('resLibras');

        if (kilos === '' || kilos < 0) {
        resLibras.innerText = '0.00';
        return;
        }

        const libras = (kilos * 2.20462).toFixed(2);
        resLibras.innerText = libras;
    }

    (() => {
        const form = document.getElementById('bmiForm');
        if (!form) return;
        const el = Object.fromEntries(['MetricButton','ImperialButton','MetricFields','ImperialFields','WeightKg','HeightCm','WeightLb','HeightFt','HeightIn','Result','Category','Error'].map(name => [name.charAt(0).toLowerCase() + name.slice(1), document.getElementById(`bmi${name}`)]));
        const message = {
            waiting: @js(__('Waiting for data')), invalid: @js(__('Enter valid values within the indicated ranges.')),
            underweight: @js(__('Underweight')), healthy: @js(__('Healthy weight')), overweight: @js(__('Overweight')),
            obesityOne: @js(__('Obesity class I')), obesityTwo: @js(__('Obesity class II')), obesityThree: @js(__('Obesity class III')),
        };
        let system = 'metric';
        const clearResult = (error = '') => { el.result.textContent = '--'; el.category.textContent = message.waiting; el.error.textContent = error; };
        const classify = bmi => bmi < 18.5 ? message.underweight : bmi < 25 ? message.healthy : bmi < 30 ? message.overweight : bmi < 35 ? message.obesityOne : bmi < 40 ? message.obesityTwo : message.obesityThree;
        const calculate = () => {
            let bmi, hasInput, valid;
            if (system === 'metric') {
                const weight = Number(el.weightKg.value), height = Number(el.heightCm.value);
                hasInput = el.weightKg.value !== '' || el.heightCm.value !== '';
                valid = weight >= 1 && weight <= 500 && height >= 30 && height <= 275;
                bmi = weight / ((height / 100) ** 2);
            } else {
                const weight = Number(el.weightLb.value), feet = Number(el.heightFt.value), inches = el.heightIn.value === '' ? 0 : Number(el.heightIn.value), totalInches = feet * 12 + inches;
                hasInput = el.weightLb.value !== '' || el.heightFt.value !== '' || el.heightIn.value !== '';
                valid = weight >= 2 && weight <= 1100 && feet >= 1 && feet <= 9 && inches >= 0 && inches < 12;
                bmi = 703 * weight / (totalInches ** 2);
            }
            if (!valid || !Number.isFinite(bmi)) return clearResult(hasInput ? message.invalid : '');
            el.error.textContent = ''; el.result.textContent = bmi.toFixed(1); el.category.textContent = classify(bmi);
        };
        const selectSystem = selected => {
            system = selected; const metric = selected === 'metric';
            el.metricFields.classList.toggle('hidden', !metric); el.imperialFields.classList.toggle('hidden', metric);
            el.metricButton.setAttribute('aria-pressed', String(metric)); el.imperialButton.setAttribute('aria-pressed', String(!metric));
            for (const [button, active] of [[el.metricButton, metric], [el.imperialButton, !metric]]) { button.classList.toggle('bg-[#351d5b]', active); button.classList.toggle('text-white', active); }
            calculate();
        };
        el.metricButton.addEventListener('click', () => selectSystem('metric'));
        el.imperialButton.addEventListener('click', () => selectSystem('imperial'));
        form.addEventListener('input', calculate);
        form.addEventListener('reset', () => setTimeout(() => clearResult(), 0));
    })();
    </script>
</x-layouts.app>
