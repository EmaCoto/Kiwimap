<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => __('Pricing')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Pricing'))]); ?>

    <div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl">

        
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
                    <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-widest uppercase ">Tentative Service Price List</h1>
                </div>
                <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3">
                    Updated on: 01/16/2026
                </p>
            </div>

            <div class="hidden md:flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => 'currency-dollar','class' => 'h-4 w-4 text-[#6fa31c]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'currency-dollar','class' => 'h-4 w-4 text-[#6fa31c]']); ?>
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
                <span class="text-[9px] font-black text-gray-700 dark:text-white uppercase tracking-widest">Official Rates</span>
            </div>
        </div>

        
        <div class="bg-white dark:bg-[#123338]/10 rounded-2xl shadow-2xl shadow-black/[0.02] border border-gray-100 dark:border-white/5 overflow-hidden">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[9px] font-black text-gray-700 dark:text-gray-200 uppercase tracking-[0.2em] border-b border-gray-50 dark:border-white/5 bg-gray-50/30">
                            <th class="px-6 py-5">Membership</th>
                            <th class="px-6 py-5 w-48">Price</th>
                            <th class="px-6 py-5">Benefits</th>
                            <th class="px-6 py-5">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                        
                        <tr class="group hover:bg-[#123338]/[0.02] dark:hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-6 text-[11px] font-black text-[#123338] dark:text-gray-200 uppercase  tracking-widest">Bronze Membership</td>
                            <td class="px-6 py-6 text-[11px] tracking-widest font-black text-[#02a676]">$149 / Initial Visit <br> $89/month</td>
                            <td class="px-6 py-6 text-[10px] font-bold text-gray-500 dark:text-gray-200 uppercase leading-relaxed tracking-widest">
                                - Perfect for those seeking essential care <br> - Includes one visit per month
                            </td>
                            <td class="px-6 py-6 text-[9px] font-black text-[#c93d00] uppercase tracking-widest opacity-80">
                                Does not cover weight loss consultations
                            </td>
                        </tr>
                        
                        <tr class="group hover:bg-[#123338]/[0.02] dark:hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-6 text-[11px] font-black text-[#123338] dark:text-gray-200 uppercase  tracking-widest">Silver Membership</td>
                            <td class="px-6 py-6 text-[11px] tracking-widest font-black text-[#02a676]">
                                $210 / Initial Visit <br> $99 / month
                            </td>
                            <td class="px-6 py-6 text-[10px] font-bold text-gray-500 dark:text-gray-200 uppercase leading-relaxed tracking-widest">
                                - All the benefits of Bronze, plus: <br> - Includes weight loss consultations and follow ups
                            </td>
                            <td class="px-6 py-6 text-[9px] font-black text-gray-700 dark:text-gray-200 uppercase tracking-widest">
                                Only one weightloss consultation a month.
                            </td>
                        </tr>
                        
                        <tr class="group hover:bg-[#123338]/[0.02] dark:hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-6 text-[11px] font-black text-[#123338] dark:text-gray-200 uppercase  tracking-tight">Gold Membership</td>
                            <td class="px-6 py-6 text-[11px] tracking-widest font-black text-[#02a676]">
                                $210 / Initial Visit <br> $149 / month
                            </td>
                            <td class="px-6 py-6 text-[10px] font-bold text-gray-500 dark:text-gray-200 uppercase leading-relaxed tracking-widest">
                                - Comprehensive access to all our health services, including weight loss.
                            </td>
                            <td class="px-6 py-6 text-[9px] font-black text-gray-700 dark:text-gray-200 uppercase tracking-widest">
                                Maximum of two visits a month.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="bg-white dark:bg-[#123338]/10 rounded-2xl shadow-2xl shadow-black/[0.02] border border-gray-100 dark:border-white/5 overflow-hidden mt-4">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[9px] font-black text-white uppercase tracking-[0.2em] bg-[#123338]">
                            <th class="px-6 py-4">Service</th>
                            <th class="px-6 py-4 w-36">Price</th>
                            <th class="px-6 py-4">Notes</th>
                            <th class="px-6 py-4">FORMS / INTAKES</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                        <?php
                            $services = [
                                ['Weight Loss Initial Visit', '$245 per visit', 'Will usually need to see provider every 4-6 weeks', 'Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form'],
                                ['Weight Loss Follow up', '$145 per visit', 'Always review the forms for initial visit are completed', 'Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form'],
                                ['General Health', '$148.50 per visit', 'Sick patients with urinary symptoms, cough, cold, sore throats, rash, sinus/nasal concerns or other sick symptoms', 'Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form'],
                                ['Mental Health (Anxiety/Depression) Initial visit', '$149 per visit', '', 'Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form'],
                                ['Mental Health Follow up', '$149 per visit', '', 'PHQ-9, GAD-7'],
                                ['Insomnia (difficulty sleeping)', '$149 per visit', '', 'Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form'],
                                ['Erectile Dysfunction', '$195 per visit', '', 'Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form'],
                                ['Acne', '$148 per visit', '', 'Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form'],
                                ['Hair Loss', '$165 per visit', '', 'Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form'],
                                ['Sexually Transmitted infections', '$147 per visit', '', 'Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form'],
                                ['Contraception', '$99 per visit', '', 'Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form'],
                                ['Follow up', 'same as per visit', 'Patient has a second different visit reason. Everything must be fully written on english.', 'Always review the corresponding forms are completed. Still the forms can be sent in spanish (patient preferred language).'],
                                ['Patient with multiple health concerns', '$??? per visit', '', 'Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form'],
                                ['Comprehensive Appointment', '$250', 'This service provides a thorough evaluation of a patient’s medical conditions. If requested, and clinically appropriate, a clinical summary may be provided to help the patient understand the findings and next steps.', 'Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form, PHQ-9, GAD-7']
                            ];
                        ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="group hover:bg-[#123338]/[0.02] dark:hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 text-[12px] font-black text-[#123338] dark:text-gray-200 uppercase  leading-tight"><?php echo e($s[0]); ?></td>
                            <td class="px-6 py-4 text-[12px] tracking-widest font-black text-[#02a676] "><?php echo e($s[1]); ?></td>
                            <td class="px-6 py-4 text-[10px] font-bold text-gray-700 dark:text-gray-200 uppercase tracking-widest"><?php echo e($s[2]); ?></td>
                            <td class="px-6 py-4 text-[10px] font-bold text-gray-700  dark:text-gray-200 uppercase tracking-widest leading-relaxed">
                                <?php echo e($s[3]); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="px-2 py-4 border-t border-gray-100 dark:border-white/5">
            <p class="text-[8px] font-black text-gray-700 uppercase tracking-[0.5em] text-center dark:text-gray-200">Executive Pricing Report - Internal Use Only</p>
        </div>
    </div>

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
<?php /**PATH C:\Users\EOchoa\Escritorio\Kiwimap\resources\views/pricing.blade.php ENDPATH**/ ?>