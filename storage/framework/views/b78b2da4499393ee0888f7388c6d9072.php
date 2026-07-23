<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => __('Time Difference')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Time Difference'))]); ?>

    <div class="w-full">
        <h1 class="text-3xl font-extrabold mb-2 text-center"><?php echo e(__('Time Difference')); ?></h1>
        <p class="text-gray-500 text-center"><?php echo e(__('Calculate the time difference between your location and your patient’s location')); ?></p>

        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
            
            <div class="space-y-6 lg:col-span-2 flex flex-col">

                
                <div class="relative">
                    <label class="block text-xs font-medium mb-1">
                        <?php echo e(__('Patient Location (U.S. State)')); ?>

                    </label>

                    <div onclick="toggleStatePicker()" id="statePickerTrigger"
                        class="w-full border rounded p-2 text-sm bg-white dark:bg-white text-black flex justify-between items-center cursor-pointer shadow-sm">
                        <span id="selectedStateLabel"><?php echo e(__('Select State...')); ?></span>
                        <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => 'chevron-down','class' => 'h-4 w-4 text-gray-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chevron-down','class' => 'h-4 w-4 text-gray-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $attributes = $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $component = $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
                    </div>

                    <div id="statePickerPanel" class="hidden absolute z-50 w-full mt-1 bg-white border rounded shadow-xl overflow-hidden">
                        <div class="p-2 border-b bg-gray-50">
                            <input type="text" id="stateSearch" placeholder="<?php echo e(__('Search state...')); ?>" onkeyup="filterStates()"
                                class="w-full border rounded px-3 py-1.5 text-sm outline-none focus:ring-2 focus:ring-blue-500 text-black">
                        </div>
                        <div id="statesList" class="max-h-60 overflow-y-auto p-1">
                            
                        </div>
                    </div>

                    
                    <select id="patientZone" onchange="calculateTimeDifference()" class="hidden"></select>
                </div>

                <div>
                    <label for="weekSelector" class="block text-xs font-medium mb-1">
                        <?php echo e(__('Select Appointment by Week (based on today)')); ?>

                    </label>
                    <select
                        id="weekSelector"
                        onchange="handleWeekSelection(this.value)"
                        class="w-full border rounded p-2 text-sm dark:text-black dark:bg-white"
                    ></select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="targetDate" class="block text-xs font-medium mb-1">
                            <?php echo e(__('Appointment/Reference Date')); ?>

                        </label>

                        <button
                            type="button"
                            onclick="openNativeDatePicker()"
                            class="w-full border p-2 rounded text-sm bg-white dark:bg-white text-left flex items-center justify-between"
                        >
                            <span id="targetDateDisplayText" class="text-gray-900 dark:text-black text-sm truncate">—</span>
                            <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => 'calendar','class' => 'h-5 w-5 text-gray-500 dark:text-black ml-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'calendar','class' => 'h-5 w-5 text-gray-500 dark:text-black ml-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $attributes = $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $component = $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
                        </button>

                        <input type="date" id="targetDate" class="sr-only" onchange="onTargetDateChange()">

                        <p id="weekStatus" class="text-sm mt-1 font-medium text-gray-700 dark:text-gray-500"></p>
                        <p class="text-[11px] mt-1 text-gray-400 italic">
                            <?php echo __('If you select <strong>Saturday or Sunday</strong>, it will adjust to the following <strong>Monday</strong>.'); ?>

                        </p>
                    </div>

                    <div>
                        <label for="myTimeInput" class="block text-xs font-medium mb-1">
                            <?php echo e(__('Patient time for the appointment')); ?>

                        </label>
                        <input
                            type="time"
                            id="myTimeInput"
                            step="60"
                            class="w-full border rounded p-2 text-sm dark:text-black dark:bg-white"
                            onchange="calculateTimeDifference()"
                        >
                    </div>
                </div>

                
                <div class="space-y-4">
                    <div class="bg-blue-100 p-4 border-l-4 border-blue-600 rounded flex items-start gap-3">
                        <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => 'information-circle','class' => 'h-6 w-6 text-blue-600 mt-0.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'information-circle','class' => 'h-6 w-6 text-blue-600 mt-0.5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $attributes = $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $component = $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
                        <div>
                            <h2 class="text-lg font-semibold text-blue-900"><?php echo e(__('We’re here to help!')); ?></h2>
                            <p class="text-blue-800 text-sm">
                                <?php echo __('Monday to Friday, 9:00 a.m. to 5:30 p.m.<br><span class="font-medium text-xs">Eastern Time (ET/EDT)</span>'); ?>

                            </p>
                        </div>
                    </div>

                    <div class="bg-orange-100 p-4 border-l-4 border-orange-500 rounded flex items-start gap-3">
                        <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => 'exclamation-triangle','class' => 'h-6 w-6 text-orange-600 mt-0.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'exclamation-triangle','class' => 'h-6 w-6 text-orange-600 mt-0.5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $attributes = $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $component = $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
                        <div>
                            <h2 class="text-lg font-semibold text-orange-900"><?php echo e(__('Important Information!')); ?></h2>
                            <p class="text-orange-800 text-sm">
                                <?php echo e(__('We do not plan to provide services in New York, Wisconsin, and Kansas.')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div id="results" class="space-y-6 mt-4 lg:mt-0">
                <div id="myTimeCard" class="flex flex-col px-4 py-3 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#6fa31c] to-[#123338] transition ease-in-out duration-300 text-sm hover:scale-105 font-semibold">
                    <p class="text-sm font-semibold opacity-80">
                        <span id="myZoneName">...</span>
                    </p>
                    <p id="myTime" class="text-4xl font-bold mt-1">--:--</p>
                    <p id="myDate" class="text-md opacity-90"></p>
                </div>

                <div id="patientTimeCard" class="flex flex-col px-4 py-3 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#351d5b] to-[#31353d] transition ease-in-out duration-300 text-sm hover:scale-105 font-semibold">
                    <p class="text-sm font-semibold opacity-80">
                        <?php echo e(__('Patient Time')); ?> (<span id="patientZoneName">...</span>)
                    </p>
                    <p id="patientTime" class="text-4xl font-bold mt-1">--:--</p>
                    <p id="patientDate" class="text-md opacity-90"></p>
                </div>

                <div id="differenceCard" class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-gray-300">
                    <p class="text-gray-500 font-semibold text-xs uppercase tracking-wider"><?php echo e(__('Time Difference')); ?></p>
                    <p id="timeDifference" class="text-lg font-medium text-gray-800 mt-1"><?php echo e(__('Calculating...')); ?></p>
                </div>

                
                <div class="mt-3">
                    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">
                        <table class="min-w-full text-xs">
                            <thead class="bg-gray-50 text-gray-700">
                                <tr>
                                    <th class="px-3 py-2 font-semibold text-center"><?php echo e(__('Months')); ?></th>
                                    <th class="px-3 py-2 font-semibold text-center"><?php echo e(__('Weeks')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-gray-800">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($w = 4; $w <= 52; $w += 4): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-3 py-2 text-center border-r"><?php echo e(intval($w / 4)); ?> <?php echo e((intval($w / 4) === 1) ? __('month') : __('months')); ?></td>
                                        <td class="px-3 py-2 text-center font-medium"><?php echo e($w); ?> <?php echo e(__('weeks')); ?></td>
                                    </tr>
                                <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- TRANSLATABLE STRINGS (INJECTED FROM BLADE; NO LOGIC CHANGES) ---
        const T = {
            easternTimeLabel: <?php echo json_encode(__('Eastern Time (ET/EDT)'), 15, 512) ?>,
            selectStatePlaceholder: <?php echo json_encode(__('Select State...'), 15, 512) ?>,
            weekPlaceholder: <?php echo json_encode(__('-- Or select a week --'), 15, 512) ?>,
            nextWeek: <?php echo json_encode(__('Next week'), 15, 512) ?>,
            inWeeksPrefix: <?php echo json_encode(__('In '), 15, 512) ?>,
            inWeeksSuffix: <?php echo json_encode(__(' weeks'), 15, 512) ?>,
            weekendsNotAllowedAdjusted: <?php echo json_encode(__('Weekends not allowed! Adjusted to Monday.'), 15, 512) ?>,
            sameTime: <?php echo json_encode(__('The time is the same.'), 15, 512) ?>,
            patientAhead: <?php echo json_encode(__('ahead'), 15, 512) ?>,
            patientBehind: <?php echo json_encode(__('behind'), 15, 512) ?>,
            patientIs: <?php echo json_encode(__('The patient is '), 15, 512) ?>,
            hours: <?php echo json_encode(__(' hours '), 15, 512) ?>,
            appointmentToday: <?php echo json_encode(__('Appointment: Today.'), 15, 512) ?>,
            appointmentInPrefix: <?php echo json_encode(__('Appointment: In '), 15, 512) ?>,
            daySuffix: <?php echo json_encode(__(' day(s).'), 15, 512) ?>,
            weekSuffix: <?php echo json_encode(__(' week(s).'), 15, 512) ?>,
            appointmentPast: <?php echo json_encode(__('Appointment: Past.'), 15, 512) ?>
        };

        // Keep your time zone constants exactly the same (zones unchanged)
        const TIME_ZONE_GROUPS = [
            { label: "Eastern Time Zone (ET/EDT)", states: [{ name: "Connecticut", zone: "America/New_York" }, { name: "Delaware", zone: "America/New_York" }, { name: "District of Columbia", zone: "America/New_York" }, { name: "Florida (Most)", zone: "America/New_York" }, { name: "Georgia", zone: "America/New_York" }, { name: "Indiana (Most)", zone: "America/Indianapolis" }, { name: "Kentucky (East)", zone: "America/New_York" }, { name: "Maine", zone: "America/New_York" }, { name: "Maryland", zone: "America/New_York" }, { name: "Massachusetts", zone: "America/New_York" }, { name: "Michigan (Most)", zone: "America/Detroit" }, { name: "New Hampshire", zone: "America/New_York" }, { name: "New Jersey", zone: "America/New_York" }, { name: "New York", zone: "America/New_York" }, { name: "North Carolina", zone: "America/New_York" }, { name: "Ohio", zone: "America/New_York" }, { name: "Pennsylvania", zone: "America/New_York" }, { name: "Rhode Island", zone: "America/New_York" }, { name: "South Carolina", zone: "America/New_York" }, { name: "Tennessee (East)", zone: "America/New_York" }, { name: "Vermont", zone: "America/New_York" }, { name: "Virginia", zone: "America/New_York" }, { name: "West Virginia", zone: "America/New_York" }] },
            { label: "Central Time Zone (CT/CDT)", states: [{ name: "Alabama", zone: "America/Chicago" }, { name: "Arkansas", zone: "America/Chicago" }, { name: "Illinois", zone: "America/Chicago" }, { name: "Indiana (West)", zone: "America/Chicago" }, { name: "Iowa", zone: "America/Chicago" }, { name: "Kansas (Most)", zone: "America/Chicago" }, { name: "Kentucky (West)", zone: "America/Chicago" }, { name: "Louisiana", zone: "America/Chicago" }, { name: "Minnesota", zone: "America/Chicago" }, { name: "Mississippi", zone: "America/Chicago" }, { name: "Missouri", zone: "America/Chicago" }, { name: "Nebraska (East)", zone: "America/Chicago" }, { name: "North Dakota (Most)", zone: "America/Chicago" }, { name: "Oklahoma", zone: "America/Chicago" }, { name: "South Dakota (East)", zone: "America/Chicago" }, { name: "Tennessee (West)", zone: "America/Chicago" }, { name: "Texas (Most)", zone: "America/Chicago" }, { name: "Wisconsin", zone: "America/Chicago" }, { name: "Florida (West)", zone: "America/Chicago" }] },
            { label: "Mountain Time Zone (MT/MDT)", states: [{ name: "Colorado", zone: "America/Denver" }, { name: "Idaho (South)", zone: "America/Denver" }, { name: "Montana", zone: "America/Denver" }, { name: "New Mexico", zone: "America/Denver" }, { name: "Utah", zone: "America/Denver" }, { name: "Wyoming", zone: "America/Denver" }, { name: "North Dakota (West)", zone: "America/Denver" }, { name: "South Dakota (West)", zone: "America/Denver" }, { name: "Nebraska (West)", zone: "America/Denver" }] },
            { label: "Mountain Time Zone (MST - No DST)", states: [{ name: "Arizona (No DST)", zone: "America/Phoenix" }] },
            { label: "Pacific Time Zone (PT/PDT)", states: [{ name: "California", zone: "America/Los_Angeles" }, { name: "Nevada", zone: "America/Los_Angeles" }, { name: "Oregon (Most)", zone: "America/Los_Angeles" }, { name: "Washington", zone: "America/Los_Angeles" }, { name: "Idaho (North)", zone: "America/Los_Angeles" }] },
            { label: "Alaska Time Zone (AKT/AKDT)", states: [{ name: "Alaska (Most)", zone: "America/Anchorage" }] },
            { label: "Hawaii Time Zone (HST)", states: [{ name: "Hawaii", zone: "Pacific/Honolulu" }] }
        ];

        let intervalId = null;
        let selectedWeeks = null;

        // --- VISUAL SEARCH LOGIC ---
        function toggleStatePicker() {
            const panel = document.getElementById('statePickerPanel');
            panel.classList.toggle('hidden');
            if (!panel.classList.contains('hidden')) {
                document.getElementById('stateSearch').value = '';
                filterStates();
                document.getElementById('stateSearch').focus();
            }
        }

        function filterStates() {
            const val = document.getElementById('stateSearch').value.toLowerCase();
            const items = document.querySelectorAll('.state-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(val) ? 'block' : 'none';
            });
        }

        function selectState(name, zone) {
            document.getElementById('selectedStateLabel').textContent = name;
            const realSelect = document.getElementById('patientZone');
            // Keep the logic of injecting into the hidden select
            realSelect.innerHTML = `<option value="${zone}" selected>${name}</option>`;
            if (!document.getElementById('statePickerPanel').classList.contains('hidden')) {
                toggleStatePicker();
            }
            calculateTimeDifference();
        }

        function populateCustomList() {
            const list = document.getElementById('statesList');
            list.innerHTML = '';
            TIME_ZONE_GROUPS.forEach(group => {
                const header = document.createElement('div');
                header.className = 'text-[10px] font-bold text-gray-400 px-2 py-1 bg-gray-50 uppercase tracking-tighter';
                header.textContent = group.label;
                list.appendChild(header);

                group.states.forEach(state => {
                    const item = document.createElement('div');
                    item.className = 'state-item px-3 py-2 text-sm hover:bg-blue-600 hover:text-white cursor-pointer text-black transition-colors';
                    item.textContent = state.name;
                    item.onclick = () => selectState(state.name, state.zone);
                    list.appendChild(item);
                });
            });
        }

        window.onclick = function(event) {
            if (!event.target.closest('#statePickerTrigger') && !event.target.closest('#statePickerPanel')) {
                document.getElementById('statePickerPanel').classList.add('hidden');
            }
        }

        // --- YOUR LOGIC FUNCTIONS (AS-IS) ---
        function clearWeekSelection() { selectedWeeks = null; const ws = document.getElementById('weekSelector'); if (ws) ws.value = ""; }
        function openNativeDatePicker() { const input = document.getElementById('targetDate'); if (input.showPicker) input.showPicker(); else { input.focus(); input.click(); } }
        function onTargetDateChange() { clearWeekSelection(); checkWeekend(); calculateTimeDifference(); paintPrettyDate(); }

        const PRETTY_LOCALE = 'en-US';
        const PRETTY_TZ = 'America/Bogota';

        function paintPrettyDate() {
            const input = document.getElementById('targetDate');
            const out = document.getElementById('targetDateDisplayText');
            if (!input || !out) return;
            const iso = input.value;
            if (!iso) { out.textContent = '—'; return; }
            const date = new Date(iso + 'T00:00:00');
            const formatted = new Intl.DateTimeFormat(PRETTY_LOCALE, { timeZone: PRETTY_TZ, year: 'numeric', month: 'long', day: '2-digit' }).format(date);
            out.textContent = formatted.charAt(0).toUpperCase() + formatted.slice(1);
        }

        function initApp() {
            populateCustomList();
            populateWeekSelector();
            setDefaultDate();
            setDefaultTime();
            checkWeekend();
            document.getElementById('myZoneName').textContent = T.easternTimeLabel;
            selectState("Connecticut", "America/New_York");

            if (intervalId) clearInterval(intervalId);
            intervalId = setInterval(() => {
                const hasManualTime = !!document.getElementById('myTimeInput').value;
                if (!hasManualTime) calculateTimeDifference();
            }, 1000);
        }

        function setDefaultDate() { const targetDateInput = document.getElementById('targetDate'); const today = new Date(); const yyyy = today.getFullYear(); const mm = String(today.getMonth() + 1).padStart(2, '0'); const dd = String(today.getDate()).padStart(2, '0'); const todayString = `${yyyy}-${mm}-${dd}`; targetDateInput.min = todayString; targetDateInput.value = todayString; paintPrettyDate(); }
        function setDefaultTime() { const myTimeInput = document.getElementById('myTimeInput'); const now = new Date(); const hh = String(now.getHours()).padStart(2, '0'); const mi = String(now.getMinutes()).padStart(2, '0'); myTimeInput.value = `${hh}:${mi}`; }

        function populateWeekSelector() {
            const weekSelector = document.getElementById('weekSelector');
            weekSelector.innerHTML = `<option value="" selected disabled>${T.weekPlaceholder}</option>`;
            for (let i = 1; i <= 52; i++) {
                let optionLabel = (i === 1) ? `${T.nextWeek}` : `${T.inWeeksPrefix}${i}${T.inWeeksSuffix}`;
                weekSelector.innerHTML += `<option value="${i}">${optionLabel}</option>`;
            }
        }

        function checkWeekend() {
            const targetDateInput = document.getElementById('targetDate');
            const selectedDate = new Date(targetDateInput.value + 'T00:00:00');
            const dayOfWeek = selectedDate.getDay();
            let message = '';
            if (dayOfWeek === 0 || dayOfWeek === 6) {
                let daysToAdd = (dayOfWeek === 6) ? 2 : 1;
                const newDate = new Date(selectedDate.getTime() + (daysToAdd * 86400000));
                const yyyy = newDate.getFullYear();
                const mm = String(newDate.getMonth() + 1).padStart(2, '0');
                const dd = String(newDate.getDate()).padStart(2, '0');
                targetDateInput.value = `${yyyy}-${mm}-${dd}`;
                paintPrettyDate();
                message = T.weekendsNotAllowedAdjusted;
            }
            const weekStatusEl = document.getElementById('weekStatus');
            if (message) {
                weekStatusEl.innerHTML = `<span class="text-red-600 font-bold">${message}</span>`;
                setTimeout(() => { calculateTimeDifference(true); }, 3000);
            } else { weekStatusEl.textContent = ''; }
        }

        function handleWeekSelection(weeks) {
            const weekSelector = document.getElementById('weekSelector');
            const targetDateInput = document.getElementById('targetDate');
            const weeksInt = parseInt(weeks, 10);
            selectedWeeks = weeksInt;
            const today = new Date();
            const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            const targetDate = new Date(todayStart.getTime() + (weeksInt * 7 * 86400000));
            const yyyy = targetDate.getFullYear();
            const mm = String(targetDate.getMonth() + 1).padStart(2, '0');
            const dd = String(targetDate.getDate()).padStart(2, '0');
            targetDateInput.value = `${yyyy}-${mm}-${dd}`;
            checkWeekend();
            calculateTimeDifference(true);
            paintPrettyDate();
            weekSelector.value = String(selectedWeeks);
        }

        function getLocalTimeData(timeZone, dateObj) {
            const timeOptions = { timeZone, hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
            const dateOptions = { timeZone, weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            return {
                time: new Intl.DateTimeFormat('en-US', timeOptions).format(dateObj),
                date: new Intl.DateTimeFormat('en-US', dateOptions).format(dateObj)
            };
        }

        function getTzOffsetMinutesAt(date, timeZone) {
            const dtf = new Intl.DateTimeFormat('en-US', { timeZone, hour12: false, year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const parts = dtf.formatToParts(date).reduce((acc, p) => { acc[p.type] = p.value; return acc; }, {});
            const asUTC = Date.UTC(parts.year, parts.month - 1, parts.day, parts.hour, parts.minute, parts.second);
            return (asUTC - date.getTime()) / 60000;
        }

        function makeZonedInstant(year, month, day, hour, minute, timeZone) {
            let guess = new Date(Date.UTC(year, month - 1, day, hour, minute, 0));
            const off1 = getTzOffsetMinutesAt(guess, timeZone);
            let utcMillis = Date.UTC(year, month - 1, day, hour, minute, 0) - (off1 * 60000);
            let result = new Date(utcMillis);
            const off2 = getTzOffsetMinutesAt(result, timeZone);
            if (off2 !== off1) { result = new Date(Date.UTC(year, month - 1, day, hour, minute, 0) - (off2 * 60000)); }
            return result;
        }

        function calculateTimeDifference(forceWeekStatusUpdate = false) {
            const patientZoneSelect = document.getElementById('patientZone');
            const targetDateInput = document.getElementById('targetDate');
            const myTimeInput = document.getElementById('myTimeInput');
            const myZone = "America/New_York";
            const patientZone = patientZoneSelect.value || myZone;
            if (!targetDateInput.value) return;

            let hour, minute;
            if (myTimeInput.value) { const [hh, mm] = myTimeInput.value.split(':').map(Number); hour = hh; minute = mm; }
            else { const now = new Date(); hour = now.getHours(); minute = now.getMinutes(); }

            const [year, month, day] = targetDateInput.value.split('-').map(Number);
            const patientInstant = makeZonedInstant(year, month, day, hour, minute, patientZone);

            const myData = getLocalTimeData(myZone, patientInstant);
            const patientData = getLocalTimeData(patientZone, patientInstant);

            const offMy = getTzOffsetMinutesAt(patientInstant, myZone) / 60;
            const offPatient = getTzOffsetMinutesAt(patientInstant, patientZone) / 60;
            const diffHours = offPatient - offMy;

            let differenceText =
                (diffHours === 0)
                    ? T.sameTime
                    : `${T.patientIs}${Math.abs(diffHours).toFixed(1)}${T.hours}<span class="font-bold ${diffHours > 0 ? 'text-green-700' : 'text-red-700'}">${diffHours > 0 ? T.patientAhead : T.patientBehind}</span>.`;

            const today = new Date();
            const targetDate = new Date(targetDateInput.value + 'T00:00:00');
            const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            const diffDays = Math.round((targetDate - todayStart) / 86400000);

            document.getElementById('weekStatus').textContent =
                diffDays === 0
                    ? T.appointmentToday
                    : (diffDays > 0
                        ? `${T.appointmentInPrefix}${diffDays < 7 ? diffDays + T.daySuffix : Math.round(diffDays/7) + T.weekSuffix}`
                        : T.appointmentPast);

            document.getElementById('patientZoneName').textContent = document.getElementById('selectedStateLabel').textContent;
            document.getElementById('myTime').textContent = myData.time;
            document.getElementById('myDate').textContent = myData.date.charAt(0).toUpperCase() + myData.date.slice(1);
            document.getElementById('patientTime').textContent = patientData.time;
            document.getElementById('patientDate').textContent = patientData.date.charAt(0).toUpperCase() + patientData.date.slice(1);
            document.getElementById('timeDifference').innerHTML = differenceText;

            const card = document.getElementById('differenceCard');
            card.className = "bg-white p-4 rounded-lg shadow-sm border-l-4 " + (diffHours > 0 ? 'border-green-500' : (diffHours < 0 ? 'border-red-500' : 'border-gray-300'));
        }

        function initOnce() { const root = document.getElementById('results'); if (!root || root.dataset.inited === '1') return; root.dataset.inited = '1'; initApp(); }
        function cleanup() { if (intervalId) { clearInterval(intervalId); intervalId = null; } const root = document.getElementById('results'); if (root) delete root.dataset.inited; }

        document.addEventListener('DOMContentLoaded', initOnce, { once: true });
        window.addEventListener('pageshow', (e) => { if (e.persisted) initOnce(); });
        document.addEventListener('turbo:load', () => { cleanup(); initOnce(); });
        document.addEventListener('livewire:navigated', () => { cleanup(); initOnce(); });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH C:\Users\EOCHOA\Desktop\Kiwimap\resources\views\time_difference.blade.php ENDPATH**/ ?>