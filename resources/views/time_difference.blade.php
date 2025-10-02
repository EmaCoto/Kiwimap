<x-layouts.app :title="__('Diferencia Horaria')">
 
<div class="w-full">
    <h1 class="text-3xl font-extrabold mb-2 text-center">Diferencia Horaria</h1>
    <p class="text-gray-500 text-center">Calcula la diferencia de hora entre tu ubicación y la de tu paciente</p>

    <div class="grid grid-cols-3 gap-8 mt-8">
        <!-- Controles de Selección de Fecha y Semana -->
        <div class="space-y-6 col-span-2 flex flex-col">
            <!-- Selector por Semanas -->
            <div>
                <label for="weekSelector" class="block text-xs font-medium mb-1">
                    Seleccionar Cita por Semana (basado en el día de hoy)
                </label>
                <select id="weekSelector" onchange="handleWeekSelection(this.value)"
                        class="w-full border rounded p-2 text-sm">
                    <!-- Options populated by JS -->
                </select>
            </div>
        
            <!-- Selector de Fecha -->
            <div>
                <label for="targetDate" class="block text-xs font-medium mb-1">
                    Fecha de la Cita/Referencia
                </label>
                <input type="date" id="targetDate" onchange="checkWeekend(); calculateTimeDifference();"
                        class="w-full border rounded p-2 text-sm">
                <!-- Muestra la cantidad de semanas y mensajes de error/ajuste -->
                <p id="weekStatus" class="mt-2 text-sm font-medium text-gray-700"></p>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <!-- Mi Ubicación (Fijo: Hora del Este) -->
                <div>
                    <label class="block text-xs font-medium mb-1">
                        Mi Ubicación (Estado de EE. UU.)
                    </label>
                    <!-- Se muestra fijo como Hora del Este según la solicitud -->
                    <div class="w-full border rounded p-2 text-sm">
                        Hora del Este (ET/EDT)
                    </div>
                </div>
                
                <!-- Ubicación del Paciente -->
                <div>
                    <label for="patientZone" class="block text-xs font-medium mb-1">
                        Ubicación del Paciente (Estado de EE. UU.)
                    </label>
                    <select id="patientZone" onchange="calculateTimeDifference()"
                            class="w-full border rounded p-2 text-sm">
                        <!-- Opciones se llenarán con JS -->
                    </select>
                </div>
            </div>
        
        </div>

        <!-- Resultados -->
        <div id="results" class="space-y-6">
            <!-- Mi Hora Actual -->
            <div id="myTimeCard" class="flex flex-col px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#6fa31c] to-[#123338] transition ease-in-out duration-300 text-sm hover:scale-105  font-semibold">
                <p class="text-sm font-semibold opacity-80"><span id="myZoneName">...</span></p>
                <p id="myTime" class="text-4xl font-bold mt-1">--:--</p>
                <p id="myDate" class="text-md opacity-90"></p>
            </div>
            <!-- Hora del Paciente -->
            <div id="patientTimeCard" class="flex flex-col px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#351d5b] to-[#31353d] transition ease-in-out duration-300 text-sm hover:scale-105  font-semibold">
                <p class="text-sm font-semibold opacity-80">Hora del Paciente (<span id="patientZoneName">...</span>)</p>
                <p id="patientTime" class="text-4xl font-bold mt-1">--:--</p>
                <p id="patientDate" class="text-md opacity-90"></p>
            </div>
            <!-- Diferencia Horaria -->
            <div id="differenceCard" class="bg-gray-100 p-4 rounded-lg shadow-md border-l-4">
                <p class="text-gray-600 font-semibold text-sm">Diferencia Horaria</p>
                <p id="timeDifference" class="text-xl font-medium text-gray-800 mt-0.5">
                    Calculando...
                </p>
            </div>
        </div>
    </div>
    
</div>

<script>
    // Definición de las zonas horarias de EE. UU. agrupadas por estados.
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
                // Arizona no utiliza el horario de verano (DST)
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
                // Hawái no usa el horario de verano (DST)
                { name: "Hawái", zone: "Pacific/Honolulu" }
            ]
        }
    ];

    let intervalId = null; // Para manejar la actualización en tiempo real de la hora

    /**
     * Inicializa la aplicación, llenando los selectores, configurando la fecha y el intervalo de actualización.
     */
    function initApp() {
        populateSelectors();
        populateWeekSelector(); // Llenar el selector de semanas con opciones dinámicas
        setDefaultDate();
        checkWeekend(); // Asegura que la fecha inicial no sea fin de semana
        
        // Fija el nombre de la zona del usuario en los resultados ya que el selector fue eliminado.
        document.getElementById('myZoneName').textContent = 'Hora del Este (ET/EDT)'; 
        
        calculateTimeDifference();
        
        // Actualiza la hora cada segundo, manteniendo la fecha seleccionada
        if (intervalId) clearInterval(intervalId);
        intervalId = setInterval(calculateTimeDifference, 1000);
    }
    
    /**
     * Establece la fecha del input a la fecha actual y la fecha mínima (hoy).
     */
    function setDefaultDate() {
        const targetDateInput = document.getElementById('targetDate');
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const todayString = `${yyyy}-${mm}-${dd}`;
        
        targetDateInput.min = todayString; // No permite seleccionar fechas pasadas
        targetDateInput.value = todayString;
    }

    /**
     * Bloquea sábados (6) y domingos (0). Si se selecciona un fin de semana,
     * la fecha se ajusta automáticamente al próximo lunes.
     */
    function checkWeekend() {
        const targetDateInput = document.getElementById('targetDate');
        // 'T00:00:00' es crucial para evitar problemas de zona horaria al crear la fecha
        const selectedDate = new Date(targetDateInput.value + 'T00:00:00'); 
        const dayOfWeek = selectedDate.getDay(); // 0 = Sunday, 6 = Saturday

        let message = '';
        
        if (dayOfWeek === 0 || dayOfWeek === 6) { // Domingo o Sábado
            // Calcular el próximo Lunes
            let daysToAdd = 0;
            if (dayOfWeek === 6) { // Sábado -> +2 días para el Lunes
                daysToAdd = 2;
            } else if (dayOfWeek === 0) { // Domingo -> +1 día para el Lunes
                daysToAdd = 1;
            }
            
            const newDate = new Date(selectedDate.getTime() + (daysToAdd * 24 * 60 * 60 * 1000));
            
            const yyyy = newDate.getFullYear();
            const mm = String(newDate.getMonth() + 1).padStart(2, '0');
            const dd = String(newDate.getDate()).padStart(2, '0');
            
            targetDateInput.value = `${yyyy}-${mm}-${dd}`;
            message = "¡Los fines de semana están bloqueados! Se ajustó la fecha al próximo Lunes.";
        }

        // Mostrar u ocultar el mensaje de error de fin de semana
        const weekStatusEl = document.getElementById('weekStatus');
        if (message) {
             weekStatusEl.innerHTML = `<span class="text-red-600 font-bold">${message}</span>`;
             weekStatusEl.classList.remove('text-gray-700');
             setTimeout(() => { 
                 // Después de mostrar el error, forzamos el cálculo normal de semanas
                 calculateTimeDifference(true);
             }, 3000);
        } else {
             // Si no hay mensaje de error, limpiar el texto y dejar que calculateTimeDifference lo rellene con el estado de la semana
             weekStatusEl.textContent = '';
        }
    }

    /**
     * Llena el selector de semanas con opciones genéricas (basadas en el día actual),
     * excluyendo la opción de "Esta semana (Hoy)".
     */
    function populateWeekSelector() {
        const weekSelector = document.getElementById('weekSelector');
        
        // Siempre comienza con el placeholder
        weekSelector.innerHTML = '<option value="" selected disabled>-- O selecciona una semana --</option>';

        // Generar opciones para las próximas 12 semanas, relativas al día actual.
        // i representa el número de semanas a añadir (1, 2, 3...)
        for (let i = 1; i <= 12; i++) { 
            
            let optionLabel;
            if (i === 1) {
                optionLabel = `Próxima semana`;
            } else {
                optionLabel = `Dentro de ${i} semanas`;
            }
            
            // El valor es el número de semanas a añadir
            weekSelector.innerHTML += `<option value="${i}">${optionLabel}</option>`;
        }
    }
    
    /**
     * Maneja la selección desde el selector de semanas y calcula la fecha objetivo.
     * @param {string} weeks - El número de semanas a añadir ('1' para próxima semana, etc.).
     */
    function handleWeekSelection(weeks) {
        const targetDateInput = document.getElementById('targetDate');
        const weeksInt = parseInt(weeks, 10);
        
        // 1. Obtener la fecha de inicio (Hoy, normalizado a medianoche)
        const today = new Date();
        const year = today.getFullYear();
        const month = today.getMonth();
        const day = today.getDate();
        // Creamos una fecha al inicio del día de hoy
        const todayStart = new Date(year, month, day); 
        
        // 2. Calcular la fecha objetivo (sumando semanas)
        const msInWeek = 7 * 24 * 60 * 60 * 1000;
        const targetMs = todayStart.getTime() + (weeksInt * msInWeek);
        const targetDate = new Date(targetMs);
        
        // 3. Formatear y establecer la fecha
        const yyyy = targetDate.getFullYear();
        const mm = String(targetDate.getMonth() + 1).padStart(2, '0');
        const dd = String(targetDate.getDate()).padStart(2, '0');
        const dateString = `${yyyy}-${mm}-${dd}`;
        
        targetDateInput.value = dateString;
        
        // Forzar el recálculo
        calculateTimeDifference();
    }

    /**
     * Llena el selector de la ubicación del paciente.
     * El selector de "Mi Ubicación" ha sido eliminado y reemplazado por un valor fijo.
     */
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

                // Establecer el valor predeterminado para el paciente (p.ej., California/Pacífico)
                if (groupIndex === 4 && stateIndex === 0) { 
                    optionPatient.selected = true;
                }
                
                optgroupPatient.appendChild(optionPatient);
            });

            patientZoneSelect.appendChild(optgroupPatient);
        });
    }

    /**
     * Obtiene la hora para una zona horaria específica basada en la fecha y la hora actual.
     */
    function getLocalTimeData(timeZone, baseDateTime) {
        
        // Opciones de formato de hora
        const timeOptions = { 
            timeZone: timeZone, 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit', 
            hour12: true 
        };
        
        // Opciones de formato de fecha
        const dateOptions = {
            timeZone: timeZone,
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };

        const timeFormat = new Intl.DateTimeFormat('es-ES', timeOptions);
        const dateFormat = new Intl.DateTimeFormat('es-ES', dateOptions);

        const timeString = timeFormat.format(baseDateTime);
        const dateString = dateFormat.format(baseDateTime);
        
        // --- Cálculo del Offset (incluyendo DST para la fecha seleccionada) ---
        
        // Usamos una hora de referencia (mediodía UTC) en la fecha seleccionada para obtener el offset correcto,
        // que incluye el horario de verano (DST) si aplica para esa fecha.
        const utcTimeAtSelectedDate = Date.UTC(
            baseDateTime.getFullYear(),
            baseDateTime.getMonth(),
            baseDateTime.getDate(),
            12, 0, 0
        );

        // Obtenemos la hora local de referencia en la zona objetivo
        const targetRefLocalString = new Date(utcTimeAtSelectedDate).toLocaleString("en-US", {
            timeZone: timeZone,
            hour12: false,
            year: 'numeric', month: 'numeric', day: 'numeric',
            hour: 'numeric', minute: 'numeric', second: 'numeric'
        });
        
        const targetRefLocalObj = new Date(targetRefLocalString);
        
        // Calculamos la diferencia en horas entre la hora local y UTC
        const offsetHours = (targetRefLocalObj.getTime() - utcTimeAtSelectedDate) / (1000 * 60 * 60);

        return { 
            time: timeString, // Hora formateada (ej: 03:24:41 p. m.)
            date: dateString, // Fecha formateada (ej: Jueves, 2 de octubre de 2025)
            offsetHours: offsetHours, // Offset de UTC en horas (ej: -4 para EDT)
            fullDate: baseDateTime // Objeto Date base
        };
    }
    
    /**
     * Calcula y muestra la diferencia horaria y la diferencia en semanas.
     * @param {boolean} forceWeekStatusUpdate - Si es true, ignora el checkWeekend() y actualiza el estado de la semana.
     */
    function calculateTimeDifference(forceWeekStatusUpdate = false) {
        const patientZoneSelect = document.getElementById('patientZone');
        const targetDateInput = document.getElementById('targetDate');

        // Mi Ubicación está ahora HARDCODEADA a Hora del Este
        const myZone = "America/New_York"; 
        const patientZone = patientZoneSelect.value;
        const selectedDateString = targetDateInput.value;
        
        if (!selectedDateString) {
            return;
        }
        
        // Bloqueo de fin de semana: Si no se está forzando la actualización, salimos si es fin de semana.
        if (!forceWeekStatusUpdate) {
            const selectedDate = new Date(selectedDateString + 'T00:00:00');
            if (selectedDate.getDay() === 0 || selectedDate.getDay() === 6) {
                return; 
            }
        }


        // 1. Crear el objeto Date base (usando la hora actual del navegador + la fecha seleccionada)
        const now = new Date();
        const [year, month, day] = selectedDateString.split('-').map(Number);
        const baseDateTime = new Date(year, month - 1, day, now.getHours(), now.getMinutes(), now.getSeconds());

        // 2. Obtener datos de la hora para ambas zonas
        const myData = getLocalTimeData(myZone, baseDateTime);
        const patientData = getLocalTimeData(patientZone, baseDateTime);

        // 3. Calcular la diferencia horaria en horas (usando los offsets DST específicos de la fecha)
        const diffHours = patientData.offsetHours - myData.offsetHours;
        
        let differenceText;
        if (diffHours === 0) {
            differenceText = "La hora es la misma (0 horas de diferencia).";
        } else if (diffHours > 0) {
            differenceText = `El paciente está ${Math.abs(diffHours).toFixed(1)} horas <span class="font-bold text-green-700">adelantado</span>.`;
        } else {
            differenceText = `El paciente está ${Math.abs(diffHours).toFixed(1)} horas <span class="font-bold text-red-700">atrasado</span>.`;
        }
        
        // 4. Calcular y mostrar la diferencia en semanas/días
        const today = new Date();
        const targetDate = new Date(selectedDateString + 'T00:00:00');
        const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());

        const diffTime = targetDate.getTime() - todayStart.getTime();
        const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24)); 

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
        
        // 5. Sincronizar el Selector de Semanas
        const weekSelector = document.getElementById('weekSelector');
        const todayDay = today.getDay();
        const targetDay = targetDate.getDay();
        
        let syncValue = '';

        // Sincronizar solo si el día de la semana coincide con el día de hoy Y es un múltiplo exacto de 7 (semanas completas)
        // Solo para semanas futuras (> 0 días)
        if (targetDay === todayDay && diffDays > 0 && diffDays % 7 === 0) {
            // diffDays / 7 nos da el número de semanas (1, 2, 3...)
            syncValue = (diffDays / 7).toString(); 
        }
        
        // Seleccionar la opción correspondiente, si no hay coincidencia se queda en el placeholder
        const matchedOption = Array.from(weekSelector.options).find(option => option.value === syncValue);
        if (matchedOption) {
            weekSelector.value = syncValue;
        } else {
            weekSelector.value = ""; // Desseleccionar si no hay coincidencia de semana exacta
        }
        
        // 6. Actualizar el UI de Zonas Horarias
        
        // El nombre de mi zona es fijo, pero actualizamos el nombre del paciente
        const patientZoneNameText = patientZoneSelect.options[patientZoneSelect.selectedIndex].text;
        document.getElementById('patientZoneName').textContent = patientZoneNameText;

        // Actualizar Mi Hora
        document.getElementById('myTime').textContent = myData.time;
        document.getElementById('myDate').textContent = myData.date.charAt(0).toUpperCase() + myData.date.slice(1);

        // Actualizar Hora del Paciente (USAMOS patientData, que ya tiene la hora formateada por Intl.DateTimeFormat)
        document.getElementById('patientTime').textContent = patientData.time;
        const pDateString = patientData.date;
        document.getElementById('patientDate').textContent = pDateString.charAt(0).toUpperCase() + pDateString.slice(1);


        // Actualizar Diferencia
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

    // Llama a initApp inmediatamente al cargar el script, simulando el 'onload' del body
    initApp();

</script>


</x-layouts.app>
