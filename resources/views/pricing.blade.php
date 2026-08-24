<x-layouts.app :title="__('Pricing')">

    <div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl">

        {{-- Header: Estilo Ejecutivo --}}
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
                    <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-widest uppercase ">{{ __('Tentative Service Price List') }}</h1>
                </div>
                <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3">
                    {{ __('Updated on: 01/16/2026') }}
                </p>
            </div>

            <div class="hidden md:flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                <flux:icon name="currency-dollar" class="h-4 w-4 text-[#02a676]" />
                <span class="text-[9px] font-black text-gray-700 dark:text-white uppercase tracking-widest">{{ __('Official Rates') }}</span>
            </div>
        </div>


        <div class="space-y-3 flex flex-col">
            {{-- Contenedor de Información con mejor diseño --}}
            <div class="bg-[#02a676]/5 border-l-4 border-[#02a676] p-4 rounded-r-2xl max-w-2xl">
                <div class="flex items-start gap-3">
                    <flux:icon name="information-circle" class="h-5 w-5 text-[#02a676] mt-0.5" />
                    <div class="space-y-2">
                        <p class="text-sm font-bold text-[#123338] dark:text-white leading-tight">
                            {{ __('Patients of Georgia, ask if they live within a 25 air-mile straight-line radius from ZIP code 30566.') }}
                        </p>
                        <div class="flex flex-col gap-2">
                            <a
                                class="text-[11px] font-medium text-gray-600 dark:text-gray-400 hover:text-[#02a676] transition-colors break-all underline decoration-[#02a676]/30 underline-offset-4"
                                href="https://www.google.com/maps/place/Oakwood,+Georgia+30566,+EE.+UU./@34.2229331,-83.9202238,14741m/data=!3m1!1e3!4m6!3m5!1s0x88f5f30891aee1b9:0x385e3005efde53c6!8m2!3d34.2292795!4d-83.8950042!16s%2Fm%2F03dpck0?entry=ttu&g_ep=EgoyMDI2MDMwMS4xIKXMDSoASAFQAw%3D%3D"
                            >
                                {{ __('Click here to check the radius') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- Tabla 1: Memberships --}}
        <div class="bg-white dark:bg-[#123338]/10 rounded-2xl shadow-2xl shadow-black/2 border border-gray-100 dark:border-white/5 overflow-hidden">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[9px] font-black text-gray-700 dark:text-gray-200 uppercase tracking-[0.2em] border-b border-gray-50 dark:border-white/5 bg-gray-50/30">
                            <th class="px-6 py-5">{{ __('Membership') }}</th>
                            <th class="px-6 py-5 w-48">{{ __('Price') }}</th>
                            <th class="px-6 py-5">{{ __('Benefits') }}</th>
                            <th class="px-6 py-5">{{ __('Notes') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                        {{-- Bronze --}}
                        <tr class="group hover:bg-[#123338]/2 dark:hover:bg-white/2 transition-colors">
                            <td class="px-6 py-6 text-[11px] font-black text-[#123338] dark:text-gray-200 uppercase  tracking-widest">{{ __('Bronze Membership') }}</td>
                            <td class="px-6 py-6 text-[11px] tracking-widest font-black text-[#02a676]">{!! __('$149 / Initial Visit <br> $89/month') !!}</td>
                            <td class="px-6 py-6 text-[10px] font-bold text-gray-500 dark:text-gray-200 uppercase leading-relaxed tracking-widest">{!! __('- Perfect for those seeking essential care <br> - Includes one visit per month') !!}</td>
                            <td class="px-6 py-6 text-[9px] font-black text-[#c93d00] uppercase tracking-widest opacity-80">{{ __('Does not cover weight loss consultations') }}</td>
                        </tr>
                        {{-- Silver --}}
                        <tr class="group hover:bg-[#123338]/2 dark:hover:bg-white/2 transition-colors">
                            <td class="px-6 py-6 text-[11px] font-black text-[#123338] dark:text-gray-200 uppercase  tracking-widest">{{ __('Silver Membership') }}</td>
                            <td class="px-6 py-6 text-[11px] tracking-widest font-black text-[#02a676]">
                                {!! __('$210 / Initial Visit <br> $99 / month') !!}
                            </td>
                            <td class="px-6 py-6 text-[10px] font-bold text-gray-500 dark:text-gray-200 uppercase leading-relaxed tracking-widest">
                                {!! __('- All the benefits of Bronze, plus: <br> - Includes weight loss consultations and follow ups') !!}
                            </td>
                            <td class="px-6 py-6 text-[9px] font-black text-gray-700 dark:text-gray-200 uppercase tracking-widest">
                                {{ __('Only one weightloss consultation a month.') }}
                            </td>
                        </tr>
                        {{-- Gold --}}
                        <tr class="group hover:bg-[#123338]/2 dark:hover:bg-white/2 transition-colors">
                            <td class="px-6 py-6 text-[11px] font-black text-[#123338] dark:text-gray-200 uppercase  tracking-tight">{{ __('Gold Membership') }}</td>
                            <td class="px-6 py-6 text-[11px] tracking-widest font-black text-[#02a676]">
                                {!! __('$210 / Initial Visit <br> $149 / month') !!}
                            </td>
                            <td class="px-6 py-6 text-[10px] font-bold text-gray-500 dark:text-gray-200 uppercase leading-relaxed tracking-widest">
                                {{ __('- Comprehensive access to all our health services, including weight loss.') }}
                            </td>
                            <td class="px-6 py-6 text-[9px] font-black text-gray-700 dark:text-gray-200 uppercase tracking-widest">
                                {{ __('Maximum of two visits a month.') }}
                            </td>
                        </tr>
                        {{-- Weight Loss --}}
                        <tr class="group hover:bg-[#123338]/2 dark:hover:bg-white/2 transition-colors">
                            <td class="px-6 py-6 text-[11px] font-black text-[#123338] dark:text-gray-200 uppercase  tracking-tight">{{ __('Weight Loss Membership') }}</td>
                            <td class="px-6 py-6 text-[11px] tracking-widest font-black text-[#02a676]">
                                {!! __('$149 / Initial Visit <br> $99 / month') !!}
                            </td>
                            <td class="px-6 py-6 text-[10px] font-bold text-gray-500 dark:text-gray-200 uppercase leading-relaxed tracking-widest">
                                {{ __('') }}
                            </td>
                            <td class="px-6 py-6 text-[9px] font-black text-gray-700 dark:text-gray-200 uppercase tracking-widest">
                                {{ __('Use the same  Form/Intake that Weightloss Initial Visit and Fu accordingly') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tabla 2: Services --}}
        <div class="bg-white dark:bg-[#123338]/10 rounded-2xl shadow-2xl shadow-black/2 border border-gray-100 dark:border-white/5 overflow-hidden mt-4">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[9px] font-black text-white uppercase tracking-[0.2em] bg-[#123338]">
                            <th class="px-6 py-4">{{ __('Service') }}</th>
                            <th class="px-6 py-4 w-36">{{ __('Price') }}</th>
                            <th class="px-6 py-4">{{ __('Notes') }}</th>
                            <th class="px-6 py-4">{{ __('FORMS / INTAKES') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                        @php
                            $services = [
                                [__('Weight Loss Initial Visit'), __('$245 per visit'), __('Will usually need to see provider every 4-6 weeks'), __('Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form, Consent weightloss')],
                                [__('Weight Loss Follow up'), __('$145 per visit'), __('Always review the forms for initial visit are completed'), __('Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form, Consent weightloss')],
                                [__('General Health'), __('$148.50 per visit'), __('Sick patients with urinary symptoms, cough, cold, sore throats, rash, sinus/nasal concerns or other sick symptoms'), __('Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form')],
                                [__('Mental Health (Anxiety/Depression) Initial visit'), __('$149 per visit'), __(''), __('Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form')],
                                [__('Mental Health Follow up'), __('$149 per visit'), __(''), __('PHQ-9, GAD-7')],
                                [__('Insomnia (difficulty sleeping)'), __('$149 per visit'), __(''), __('Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form')],
                                [__('Erectile Dysfunction'), __('$195 per visit'), __(''), __('Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form')],
                                [__('Acne'), __('$148 per visit'), __(''), __('Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form')],
                                [__('Hair Loss'), __('$165 per visit'), __(''), __('Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form')],
                                [__('Sexually Transmitted infections'), __('$147 per visit'), __(''), __('Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form')],
                                [__('Contraception'), __('$99 per visit'), __(''), __('Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form')],
                                [__('Follow up'), __('same as per visit'), __('Patient has a second different visit reason. Everything must be fully written on english.'), __('Always review the corresponding forms are completed. Still the forms can be sent in spanish (patient preferred language).')],
                                [__('Patient with multiple health concerns'), __('$??? per visit'), __(''), __('Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form')],
                                [__('Comprehensive Appointment'), __('$250'), __('This service provides a thorough evaluation of a patient’s medical conditions. If requested, and clinically appropriate, a clinical summary may be provided to help the patient understand the findings and next steps.'), __('Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form, PHQ-9, GAD-7')],
                                [__('Post-Consultation Form or Medical Letter Completion'), __('$30'), __("Administrative fee for forms or medical letters requested after the patient’s consultation. Payment is required before the request is processed. All requests are subject to physician review and must be supported by the patient’s medical record.\n\nThe physician may decline to complete or sign any form or letter if the request is not clinically justified, is not supported by sufficient documentation, or falls outside the scope of the services provided."), __('')]
                            ];
                        @endphp

                        @foreach($services as $s)
                        <tr class="group hover:bg-[#123338]/2 dark:hover:bg-white/2 transition-colors">
                            <td class="px-6 py-4 text-[12px] font-black text-[#123338] dark:text-gray-200 uppercase leading-tight">{{ $s[0] }}</td>
                            <td class="px-6 py-4 text-[12px] tracking-widest font-black text-[#02a676]">{{ $s[1] }}</td>

                            {{-- Solución aquí: --}}
                            <td class="px-6 py-4 text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-widest">
                                {!! nl2br(e($s[2])) !!}
                            </td>

                            <td class="px-6 py-4 text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-widest leading-relaxed">
                                {{ $s[3] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="px-2 py-4 border-t border-gray-100 dark:border-white/5">
            <p class="text-[8px] font-black text-gray-700 uppercase tracking-[0.5em] text-center dark:text-gray-200">{{ __('Executive Pricing Report - Internal Use Only') }}</p>
        </div>
    </div>

</x-layouts.app>
