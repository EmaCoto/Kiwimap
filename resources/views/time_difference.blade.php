<x-layouts.app :title="__('Diferencia Horaria')">
 
<div class="w-full">
    <h1 class="text-3xl font-extrabold mb-2 text-center">Diferencia Horaria</h1>
    <p class="text-gray-500 text-center">Calcula la diferencia de hora entre tu ubicación y la de tu paciente</p>

    {{-- GRID PRINCIPAL RESPONSIVE --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
        {{-- COLUMNA PRINCIPAL --}}
        <div class="space-y-6 lg:col-span-2 flex flex-col">

            <div>
                <div>
                    <label for="patientZone" class="block text-xs font-medium mb-1">
                        Ubicación del Paciente (Estado de EE. UU.)
                    </label>
                    <select
                        id="patientZone"
                        onchange="calculateTimeDifference()"
                        class="w-full border rounded p-2 text-sm"
                    ></select>
                </div>
            </div>

            <div>
                <label for="weekSelector" class="block text-xs font-medium mb-1">
                    Seleccionar Cita por Semana (basado en el día de hoy)
                </label>
                <select
                    id="weekSelector"
                    onchange="handleWeekSelection(this.value)"
                    class="w-full border rounded p-2 text-sm"
                ></select>
            </div>
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- FECHA con visual overlay Mes Día, Año -->
                <div class="relative">
                    <label for="targetDate" class="block text-xs font-medium mb-1">
                        Fecha de la Cita/Referencia
                    </label>
                    <input
                        type="date"
                        id="targetDate"
                        onchange="clearWeekSelection(); checkWeekend(); calculateTimeDifference(); paintPrettyDate();"
                        class="w-full border p-2 rounded text-sm bg-white"
                        style="color: transparent; caret-color: transparent;"
                    >
                    <!-- Texto formateado encima del input -->
                    <span id="prettyDateInside" class="pointer-events-none absolute top-7 left-3 text-sm text-gray-900">—</span>

                    <p id="weekStatus" class="text-sm mt-1 font-medium text-gray-700"></p>
                    <p class="text-sm mt-1 font-medium text-gray-300">Si seleccionan <strong>sábado o domingo</strong> en el calendario marcará automáticamente el <strong>lúnes</strong> siguiente</p>
                </div>

                <div>
                    {{-- AHORA ESTA ES LA HORA DEL PACIENTE --}}
                    <label for="myTimeInput" class="block text-xs font-medium mb-1">
                        Hora del Paciente para la cita
                    </label>
                    <input
                        type="time"
                        id="myTimeInput"
                        step="60"
                        class="w-full border rounded p-2 text-sm"
                        onchange="calculateTimeDifference()"
                    >
                </div>
            </div>

            <div>
                <div class="mt-10 bg-blue-200 p-3 pr-10 border-t-4 border-blue-600 w-full flex flex-col sm:flex-row sm:items-center gap-3 rounded">
                    <flux:icon name="information-circle" class="h-10 w-10 sm:mr-6" />
                    <div>
                        <h2 class="text-xl font-semibold mb-1">¡Estamos para atenderte!</h2>
                        <p class="text-gray-800">
                            De lunes a viernes, de 9:00 a.m. a 5:30 p.m. <br>
                            <span class="text-sm">Hora del Este (ET/EDT)</span>
                        </p>
                    </div>
                </div>

                <div class="mt-10 bg-blue-200 p-3 pr-10 border-t-4 border-blue-600 w-full flex flex-col sm:flex-row sm:items-center gap-3 rounded">
                    <flux:icon name="information-circle" class="h-10 w-10 sm:mr-6" />
                    <div>
                        <h2 class="text-xl font-semibold mb-1">¡Información!</h2>
                        <p class="text-gray-800">
                            No planeamos dar servicios en New York, Wisconsin y Kansas
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DE RESULTADOS --}}
        <div id="results" class="space-y-6 mt-4 lg:mt-0">
            <div id="myTimeCard" class="flex flex-col px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#6fa31c] to-[#123338] transition ease-in-out duration-300 text-sm hover:scale-105 font-semibold">
                <p class="text-sm font-semibold opacity-80">
                    <span id="myZoneName">...</span>
                </p>
                <p id="myTime" class="text-4xl font-bold mt-1">--:--</p>
                <p id="myDate" class="text-md opacity-90"></p>
            </div>

            <div id="patientTimeCard" class="flex flex-col px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#351d5b] to-[#31353d] transition ease-in-out duration-300 text-sm hover:scale-105 font-semibold">
                <p class="text-sm font-semibold opacity-80">
                    Hora del Paciente (<span id="patientZoneName">...</span>)
                </p>
                <p id="patientTime" class="text-4xl font-bold mt-1">--:--</p>
                <p id="patientDate" class="text-md opacity-90"></p>
            </div>

            <div id="differenceCard" class="bg-gray-100 p-4 rounded-lg shadow-md border-l-4">
                <p class="text-gray-600 font-semibold text-sm">Diferencia Horaria</p>
                <p id="timeDifference" class="text-xl font-medium text-gray-800 mt-0.5">Calculando...</p>
            </div>
        </div>
    </div>
    
</div>

<script>
    const TIME_ZONE_GROUPS = [
        { 
            label: "Zona del Este (ET/EDT)", 
            states: [
                { name: "Connecticut", zone: "America/New_York" },
                { name: "Delaware", zone: "America/New_York" },
                { name: "Distrito de Columbia", zone: "America/New_York" },
                { name: "Florida (Mayoría)", zone: "America/New_York" },
                { name: "Georgia", zone: "America/New_York" },
                { name: "Indiana (Mayoría)", zone: "America/Indianapolis" },
                { name: "Kentucky (Este)", zone: "America/New_York" },
                { name: "Maine", zone: "America/New_York" },
                { name: "Maryland", zone: "America/New_York" },
                { name: "Massachusetts", zone: "America/New_York" },
                { name: "Michigan (Mayoría)", zone: "America/Detroit" },
                { name: "New Hampshire", zone: "America/New_York" },
                { name: "New Jersey", zone: "America/New_York" },
                { name: "Nueva York", zone: "America/New_York" },
                { name: "Carolina del Norte", zone: "America/New_York" },
                { name: "Ohio", zone: "America/New_York" },
                { name: "Pensilvania", zone: "America/New_York" },
                { name: "Rhode Island", zone: "America/New_York" },
                { name: "Carolina del Sur", zone: "America/New_York" },
                { name: "Tennessee (Este)", zone: "America/New_York" },
                { name: "Vermont", zone: "America/New_York" },
                { name: "Virginia", zone: "America/New_York" },
                { name: "Virginia Occidental", zone: "America/New_York" },
            ]
        },
        { 
            label: "Zona Central (CT/CDT)", 
            states: [
                { name: "Alabama", zone: "America/Chicago" },
                { name: "Arkansas", zone: "America/Chicago" },
                { name: "Illinois", zone: "America/Chicago" },
                { name: "Indiana (Oeste)", zone: "America/Chicago" },
                { name: "Iowa", zone: "America/Chicago" },
                { name: "Kansas (Mayoría)", zone: "America/Chicago" },
                { name: "Kentucky (Oeste)", zone: "America/Chicago" },
                { name: "Luisiana", zone: "America/Chicago" },
                { name: "Minesota", zone: "America/Chicago" },
                { name: "Misisipi", zone: "America/Chicago" },
                { name: "Misuri", zone: "America/Chicago" },
                { name: "Nebraska (Este)", zone: "America/Chicago" },
                { name: "Dakota del Norte (Mayoría)", zone: "America/Chicago" },
                { name: "Oklahoma", zone: "America/Chicago" },
                { name: "Dakota del Sur (Este)", zone: "America/Chicago" },
                { name: "Tennessee (Oeste)", zone: "America/Chicago" },
                { name: "Texas (Mayoría)", zone: "America/Chicago" },
                { name: "Wisconsin", zone: "America/Chicago" },
                { name: "Florida (Oeste)", zone: "America/Chicago" },
            ]
        },
        { 
            label: "Zona Montaña (MT/MDT)", 
            states: [
                { name: "Colorado", zone: "America/Denver" }, 
                { name: "Idaho (Sur)", zone: "America/Denver" },
                { name: "Montana", zone: "America/Denver" },
                { name: "Nuevo México", zone: "America/Denver" },
                { name: "Utah", zone: "America/Denver" },
                { name: "Wyoming", zone: "America/Denver" },
                { name: "Dakota del Norte (Oeste)", zone: "America/Denver" },
                { name: "Dakota del Sur (Oeste)", zone: "America/Denver" },
                { name: "Nebraska (Oeste)", zone: "America/Denver" },
            ]
        },
        { 
            label: "Zona Montaña (MST - Sin DST)", 
            states: [
                { name: "Arizona (Sin DST)", zone: "America/Phoenix" } 
            ]
        },
        { 
            label: "Zona Pacífico (PT/PDT)", 
            states: [
                { name: "California", zone: "America/Los_Angeles" }, 
                { name: "Nevada", zone: "America/Los_Angeles" },
                { name: "Oregón (Mayoría)", zone: "America/Los_Angeles" },
                { name: "Washington", zone: "America/Los_Angeles" },
                { name: "Idaho (Norte)", zone: "America/Los_Angeles" },
            ]
        },
        { 
            label: "Zona Alaska (AKT/AKDT)", 
            states: [
                { name: "Alaska (Mayoría)", zone: "America/Anchorage" }
            ]
        },
        { 
            label: "Zona Hawái (HST)", 
            states: [
                { name: "Hawái", zone: "Pacific/Honolulu" }
            ]
        }
    ];

    let intervalId = null;
    let selectedWeeks = null; // null = no elegido por el usuario; número = semanas elegidas

    function clearWeekSelection() {
        selectedWeeks = null;
        const weekSelector = document.getElementById('weekSelector');
        if (weekSelector) weekSelector.value = "";
    }

    // ======= Config visual del formato de fecha dentro del input =======
    const PRETTY_LOCALE = 'es-ES';
    const PRETTY_TZ     = 'America/Bogota';

    function paintPrettyDate() {
        const input = document.getElementById('targetDate');
        const out = document.getElementById('prettyDateInside');
        if (!input || !out) return;

        const iso = input.value; // "YYYY-MM-DD"
        if (!iso) { out.textContent = '—'; return; }

        const date = new Date(iso + 'T00:00:00');
        const formatted = new Intl.DateTimeFormat(PRETTY_LOCALE, {
            timeZone: PRETTY_TZ,
            year: 'numeric',
            month: PRETTY_LOCALE === 'en-US' ? 'short' : 'long',
            day: '2-digit'
        }).format(date);

        out.textContent = formatted;
    }
    // ================================================================

    function initApp() {
        populateSelectors();
        populateWeekSelector();
        setDefaultDate();
        setDefaultTime();
        checkWeekend();

        document.getElementById('myZoneName').textContent = 'Hora del Este (ET/EDT)'; 
        
        calculateTimeDifference();

        if (intervalId) clearInterval(intervalId);
        intervalId = setInterval(() => {
            const hasManualTime = !!document.getElementById('myTimeInput').value;
            if (!hasManualTime) calculateTimeDifference();
        }, 1000);
    }
    
    function setDefaultDate() {
        const targetDateInput = document.getElementById('targetDate');
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const todayString = `${yyyy}-${mm}-${dd}`;
        
        targetDateInput.min = todayString;
        targetDateInput.value = todayString;
        paintPrettyDate();
    }

    function setDefaultTime() {
        const myTimeInput = document.getElementById('myTimeInput');
        const now = new Date();
        const hh = String(now.getHours()).padStart(2, '0');
        const mi = String(now.getMinutes()).padStart(2, '0');
        myTimeInput.value = `${hh}:${mi}`;
    }

    function checkWeekend() {
        const targetDateInput = document.getElementById('targetDate');
        const selectedDate = new Date(targetDateInput.value + 'T00:00:00'); 
        const dayOfWeek = selectedDate.getDay();

        let message = '';
        
        if (dayOfWeek === 0 || dayOfWeek === 6) {
            let daysToAdd = 0;
            if (dayOfWeek === 6) { daysToAdd = 2; }
            else if (dayOfWeek === 0) { daysToAdd = 1; }
            
            const newDate = new Date(selectedDate.getTime() + (daysToAdd * 86400000));
            const yyyy = newDate.getFullYear();
            const mm = String(newDate.getMonth() + 1).padStart(2, '0');
            const dd = String(newDate.getDate()).padStart(2, '0');
            targetDateInput.value = `${yyyy}-${mm}-${dd}`;
            paintPrettyDate();
            message = "¡Los fines de semana están bloqueados! Se ajustó la fecha al próximo Lunes.";
        }

        const weekStatusEl = document.getElementById('weekStatus');
        if (message) {
             weekStatusEl.innerHTML = `<span class="text-red-600 font-bold">${message}</span>`;
             weekStatusEl.classList.remove('text-gray-700');
             setTimeout(() => { 
                 calculateTimeDifference(true);
             }, 3000);
        } else {
             weekStatusEl.textContent = '';
        }
    }

    function populateWeekSelector() {
        const weekSelector = document.getElementById('weekSelector');
        weekSelector.innerHTML = '<option value="" selected disabled>-- O selecciona una semana --</option>';
        for (let i = 1; i <= 12; i++) { 
            let optionLabel = (i === 1) ? `Próxima semana` : `Dentro de ${i} semanas`;
            weekSelector.innerHTML += `<option value="${i}">${optionLabel}</option>`;
        }
    }
    
    function handleWeekSelection(weeks) {
        const weekSelector = document.getElementById('weekSelector');
        const targetDateInput = document.getElementById('targetDate');

        const weeksInt = parseInt(weeks, 10);
        selectedWeeks = weeksInt;
        weekSelector.value = String(weeksInt);

        const today = new Date();
        const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate()); 
        const targetMs = todayStart.getTime() + (weeksInt * 7 * 86400000);
        const targetDate = new Date(targetMs);
        const yyyy = targetDate.getFullYear();
        const mm = String(targetDate.getMonth() + 1).padStart(2, '0');
        const dd = String(targetDate.getDate()).padStart(2, '0');
        targetDateInput.value = `${yyyy}-${mm}-${dd}`;

        checkWeekend();
        calculateTimeDifference(true);
        paintPrettyDate();

        weekSelector.value = String(selectedWeeks);
    }

    function populateSelectors() {
        const patientZoneSelect = document.getElementById('patientZone');
        patientZoneSelect.innerHTML = '';
        TIME_ZONE_GROUPS.forEach((group, groupIndex) => {
            const optgroupPatient = document.createElement('optgroup');
            optgroupPatient.label = group.label;

            group.states.forEach((state, stateIndex) => {
                const optionPatient = document.createElement('option');
                optionPatient.value = state.zone; 
                optionPatient.textContent = state.name; 
                if (groupIndex === 0 && stateIndex === 0) { // por defecto algo en ET
                    optionPatient.selected = true;
                }
                optgroupPatient.appendChild(optionPatient);
            });

            patientZoneSelect.appendChild(optgroupPatient);
        });
    }

    function getLocalTimeData(timeZone, dateObj) {
        const timeOptions = { 
            timeZone, hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true 
        };
        const dateOptions = {
            timeZone, weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        };

        const timeFormat = new Intl.DateTimeFormat('es-ES', timeOptions);
        const dateFormat = new Intl.DateTimeFormat('es-ES', dateOptions);

        const timeString = timeFormat.format(dateObj);
        const dateString = dateFormat.format(dateObj);

        return { 
            time: timeString,
            date: dateString
        };
    }

    // ---- Utilidades de zona horaria (precisas con DST para la fecha/hora elegida) ----
    function getTzOffsetMinutesAt(date, timeZone) {
        const dtf = new Intl.DateTimeFormat('en-US', {
            timeZone, hour12: false,
            year: 'numeric', month: '2-digit', day: '2-digit',
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        });
        const parts = dtf.formatToParts(date).reduce((acc, p) => { acc[p.type] = p.value; return acc; }, {});
        const asUTC = Date.UTC(parts.year, parts.month - 1, parts.day, parts.hour, parts.minute, parts.second);
        return (asUTC - date.getTime()) / 60000; // minutos
    }

    // Construye un Date (instante real) que corresponde a "YYYY-MM-DD HH:mm" en la zona indicada
    function makeZonedInstant(year, month, day, hour, minute, timeZone) {
        let guess = new Date(Date.UTC(year, month - 1, day, hour, minute, 0));
        const off1 = getTzOffsetMinutesAt(guess, timeZone);
        let utcMillis = Date.UTC(year, month - 1, day, hour, minute, 0) - (off1 * 60000);
        let result = new Date(utcMillis);
        const off2 = getTzOffsetMinutesAt(result, timeZone);
        if (off2 !== off1) {
            utcMillis = Date.UTC(year, month - 1, day, hour, minute, 0) - (off2 * 60000);
            result = new Date(utcMillis);
        }
        return result;
    }

    // AHORA LA HORA DE ENTRADA ES HORA DEL PACIENTE
    function calculateTimeDifference(forceWeekStatusUpdate = false) {
        const patientZoneSelect = document.getElementById('patientZone');
        const targetDateInput = document.getElementById('targetDate');
        const myTimeInput = document.getElementById('myTimeInput');

        const myZone = "America/New_York"; 
        const patientZone = patientZoneSelect.value || myZone;
        const selectedDateString = targetDateInput.value;

        if (!selectedDateString) return;

        // ---- Obtener hora base (HORA DEL PACIENTE) ----
        let hour, minute;
        if (myTimeInput.value) {
            const [hh, mm] = myTimeInput.value.split(':').map(Number);
            hour = hh; minute = mm;
        } else {
            const now = new Date();
            hour = now.getHours(); minute = now.getMinutes();
        }

        const [year, month, day] = selectedDateString.split('-').map(Number);

        // Instante real que corresponde a esa fecha/hora en la zona del PACIENTE
        const patientInstant = makeZonedInstant(year, month, day, hour, minute, patientZone);

        // Mostrar mi hora/fecha (ET) y la del paciente
        const myData = getLocalTimeData(myZone, patientInstant);
        const patientData = getLocalTimeData(patientZone, patientInstant);

        // Diferencia horaria paciente vs yo
        const offMy = getTzOffsetMinutesAt(patientInstant, myZone) / 60;
        const offPatient = getTzOffsetMinutesAt(patientInstant, patientZone) / 60;
        const diffHours = offPatient - offMy;

        let differenceText;
        if (diffHours === 0) {
            differenceText = "La hora es la misma (0 horas de diferencia).";
        } else if (diffHours > 0) {
            differenceText = `El paciente está ${Math.abs(diffHours).toFixed(1)} horas <span class="font-bold text-green-700">adelantado</span>.`;
        } else {
            differenceText = `El paciente está ${Math.abs(diffHours).toFixed(1)} horas <span class="font-bold text-red-700">atrasado</span>.`;
        }
        
        // Estado de semanas/días
        const today = new Date();
        const targetDate = new Date(selectedDateString + 'T00:00:00');
        const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        const diffTime = targetDate.getTime() - todayStart.getTime();
        const diffDays = Math.round(diffTime / 86400000); 

        let weekStatusText = '';
        const weekStatusEl = document.getElementById('weekStatus');
        weekStatusEl.classList.remove('text-red-600'); 
        weekStatusEl.classList.add('text-gray-700');

        if (diffDays === 0) {
            weekStatusText = 'Cita: Hoy.';
        } else if (diffDays > 0) {
            const weeks = diffDays / 7;
            if (diffDays < 7) {
                weekStatusText = `Cita: Dentro de ${diffDays} día(s).`;
            } else {
                const roundedWeeks = Math.round(weeks);
                weekStatusText = `Cita: Dentro de aproximadamente ${roundedWeeks} semana(s).`;
            }
        } else {
            weekStatusText = 'Cita: Fecha en el pasado.';
        }
        weekStatusEl.textContent = weekStatusText;
        
        // --- Sincronización del selector de semanas ---
        const weekSelector = document.getElementById('weekSelector');
        const todayDay = today.getDay();
        const targetDay = targetDate.getDay();
        if (selectedWeeks === null) {
            let syncValue = '';
            if (targetDay === todayDay && diffDays > 0 && diffDays % 7 === 0) {
                syncValue = (diffDays / 7).toString(); 
            }
            const matchedOption = Array.from(weekSelector.options).find(option => option.value === syncValue);
            if (matchedOption) {
                weekSelector.value = syncValue;
            }
        } else {
            weekSelector.value = String(selectedWeeks);
        }

        // Actualizar UI
        const patientZoneNameText = patientZoneSelect.options[patientZoneSelect.selectedIndex].text;
        document.getElementById('patientZoneName').textContent = patientZoneNameText;

        document.getElementById('myTime').textContent = myData.time;
        document.getElementById('myDate').textContent = myData.date.charAt(0).toUpperCase() + myData.date.slice(1);

        document.getElementById('patientTime').textContent = patientData.time;
        const pDateString = patientData.date;
        document.getElementById('patientDate').textContent = pDateString.charAt(0).toUpperCase() + pDateString.slice(1);

        document.getElementById('timeDifference').innerHTML = differenceText;
        
        const differenceCard = document.getElementById('differenceCard');
        differenceCard.classList.remove('border-green-400', 'border-red-400', 'border-gray-400');
        if (diffHours > 0) {
            differenceCard.classList.add('border-green-400');
        } else if (diffHours < 0) {
            differenceCard.classList.add('border-red-400');
        } else {
            differenceCard.classList.add('border-gray-400');
        }
    }

    // =========================
    // Bootstrap robusto SPA/BFCache
    // =========================
    function initOnce() {
        const root = document.getElementById('results'); 
        if (!root) return;
        if (root.dataset.inited === '1') return;
        root.dataset.inited = '1';
        try { initApp(); } catch (e) { console.error('initApp() error:', e); }
    }

    function cleanup() {
        if (intervalId) { clearInterval(intervalId); intervalId = null; }
        const root = document.getElementById('results');
        if (root) delete root.dataset.inited;
    }

    document.addEventListener('DOMContentLoaded', initOnce, { once: true });
    window.addEventListener('pageshow', (e) => { if (e.persisted) initOnce(); });
    document.addEventListener('turbo:load', () => { cleanup(); initOnce(); });
    document.addEventListener('livewire:navigated', () => { cleanup(); initOnce(); });
    window.addEventListener('pagehide', cleanup);
    window.addEventListener('beforeunload', cleanup);
</script>

</x-layouts.app>
