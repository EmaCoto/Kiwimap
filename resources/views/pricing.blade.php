<x-layouts.app :title="__('Pricing')">
    <div class="w-full">
        <div>
            <h1 class="text-lg font-bold mt-4">Tentative Service Price List</h1>
            <span class="text-sm text-gray-400">
                <strong>Updated on:</strong> 01/16/2026
            </span>
        </div>

        <table class="min-w-full table-auto border-collapse border border-gray-300 mt-6">
            <thead>
                <tr class="bg-[#6fa31c] text-white dark:bg-[#4d7a19]">
                    <th class="text-left px-1 font-medium">Membership</th>
                    <th class="text-left px-1 font-medium w-36">Price</th>
                    <th class="text-left px-1 font-medium">Benefits</th>
                    <th class="text-left px-1 font-medium">Notes</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd:bg-gray-200 dark:odd:bg-gray-800">
                    <td class="px-1 py-1 text-sm">Bronze Membership</td>
                    <td class="px-1 py-1 text-sm">$99/month</td>
                    <td class="px-1 py-1 text-sm"> - Perfect for those seeking essential care <br>
                                                - Includes one visit per month
                    </td>
                    <td class="px-1 py-1 text-sm">
                        Does not cover weight loss consultations
                    </td>
                </tr>
                <tr class="even:bg-gray-50 dark:even:bg-gray-700">
                    <td class="px-1 py-1 text-sm">Silver Membership</td>
                    <td class="px-1 py-1 text-sm">$210 / Initital Visit <br>
                                                $99 / month
                    </td>
                    <td class="px-1 py-1 text-sm"> - All the benefits of Bronze, plus: <br>
                                                - Includes weightloss consultations and follow ups
                    </td>
                    <td class="px-1 py-1 text-sm">
                        Only one weightloss consultation a month. 
                    </td>
                </tr>
                <tr class="odd:bg-gray-200 dark:odd:bg-gray-800">
                    <td class="px-1 py-1 text-sm">Gold Membership</td>
                    <td class="px-1 py-1 text-sm">$210 / Initial Visit <br>
                                                $149 / month
                    </td>
                    <td class="px-1 py-1 text-sm"> - Comprehensive access to all our health services, including weight loss. </td>
                    <td class="px-1 py-1 text-sm">
                        Maximum of two visits a month. 
                    </td>
                </tr>
            </tbody>
        </table>


        <table class="min-w-full table-auto border-collapse border border-gray-300 mt-6">
            <thead>
                <tr class="bg-[#6fa31c] text-white dark:bg-[#4d7a19]">
                    <th class="text-left px-1 font-medium">Service</th>
                    <th class="text-left px-1 font-medium w-26">Price</th>
                    <th class="text-left px-1 font-medium">Notes</th>
                    <th class="text-left px-1 font-medium">FORMS / INTAKES</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                <tr class="odd:bg-gray-200 dark:odd:bg-gray-800">
                    <td class="px-1 py-1 text-sm">Weight Loss Initial Visit</td>
                    <td class="px-1 py-1 text-sm">$245 per visit</td>
                    <td class="px-1 py-1 text-sm">Will usually need to see provider every 4-6 weeks</td>
                    <td class="px-1 py-1 text-sm">
                        Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form
                    </td>
                </tr>

                <tr class="even:bg-gray-50 dark:even:bg-gray-700">
                    <td class="px-1 py-1 text-sm">Weight Loss Follow up</td>
                    <td class="px-1 py-1 text-sm">$168 per visit</td>
                    <td class="px-1 py-1 text-sm">
                        Always review the forms for initial visit are completed
                    </td>
                    <td class="px-1 py-1 text-sm">
                        Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form
                    </td>
                </tr>

                <tr class="odd:bg-gray-200 dark:odd:bg-gray-800">
                    <td class="px-1 py-1 text-sm">Sick Visit</td>
                    <td class="px-1 py-1 text-sm">$155 per visit</td>
                    <td class="px-1 py-1 text-sm">
                        Sick patients with urinary symptoms, cough, cold, sore throats, rash, sinus/nasal concerns or other sick symptoms
                    </td>
                    <td class="px-1 py-1 text-sm">
                        Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form
                    </td>
                </tr>

                <tr class="even:bg-gray-50 dark:even:bg-gray-700">
                    <td class="px-1 py-1 text-sm">Mental Health (Anxiety/Depression) Initial visit</td>
                    <td class="px-1 py-1 text-sm">$155 per visit</td>
                    <td class="px-1 py-1 text-sm"></td>
                    <td class="px-1 py-1 text-sm">
                        Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form
                    </td>
                </tr>

                <tr class="odd:bg-gray-200 dark:odd:bg-gray-800">
                    <td class="px-1 py-1 text-sm">Mental Health Follow up</td>
                    <td class="px-1 py-1 text-sm">$150 per visit</td>
                    <td class="px-1 py-1 text-sm"></td>
                    <td class="px-1 py-1 text-sm">PHQ-9, GAD-7</td>
                </tr>

                <tr class="even:bg-gray-50 dark:even:bg-gray-700">
                    <td class="px-1 py-1 text-sm">Insomnia (difficulty sleeping)</td>
                    <td class="px-1 py-1 text-sm">$150 per visit</td>
                    <td class="px-1 py-1 text-sm"></td>
                    <td class="px-1 py-1 text-sm">
                        Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form
                    </td>
                </tr>

                <tr class="odd:bg-gray-200 dark:odd:bg-gray-800">
                    <td class="px-1 py-1 text-sm">Erectile Dysfunction</td>
                    <td class="px-1 py-1 text-sm">$195 per visit</td>
                    <td class="px-1 py-1 text-sm"></td>
                    <td class="px-1 py-1 text-sm">
                        Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form
                    </td>
                </tr>

                <tr class="even:bg-gray-50 dark:even:bg-gray-700">
                    <td class="px-1 py-1 text-sm">Acne</td>
                    <td class="px-1 py-1 text-sm">$155 per visit</td>
                    <td class="px-1 py-1 text-sm"></td>
                    <td class="px-1 py-1 text-sm">
                        Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form
                    </td>
                </tr>

                <tr class="odd:bg-gray-200 dark:odd:bg-gray-800">
                    <td class="px-1 py-1 text-sm">Hair Loss</td>
                    <td class="px-1 py-1 text-sm">$165 per visit</td>
                    <td class="px-1 py-1 text-sm"></td>
                    <td class="px-1 py-1 text-sm">
                        Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form
                    </td>
                </tr>

                <tr class="even:bg-gray-50 dark:even:bg-gray-700">
                    <td class="px-1 py-1 text-sm">Sexually Transmitted infections</td>
                    <td class="px-1 py-1 text-sm">$150 per visit</td>
                    <td class="px-1 py-1 text-sm"></td>
                    <td class="px-1 py-1 text-sm">
                        Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form
                    </td>
                </tr>

                <tr class="odd:bg-gray-200 dark:odd:bg-gray-800">
                    <td class="px-1 py-1 text-sm">Contraception</td>
                    <td class="px-1 py-1 text-sm">$150 per visit</td>
                    <td class="px-1 py-1 text-sm"></td>
                    <td class="px-1 py-1 text-sm">
                        Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form
                    </td>
                </tr>

                <tr class="even:bg-gray-50 dark:even:bg-gray-700">
                    <td class="px-1 py-1 text-sm">Follow up</td>
                    <td class="px-1 py-1 text-sm">same as per visit</td>
                    <td class="px-1 py-1 text-sm">
                        Patient has a second diferent visit reason.
                        Everything must be fully written on english.
                    </td>
                    <td class="px-1 py-1 text-sm">
                        Always review the corresponding forms are completed. Still the forms can be sent in spanish (patient preferred language).
                    </td>
                </tr>

                <tr class="odd:bg-gray-200 dark:odd:bg-gray-800">
                    <td class="px-1 py-1 text-sm">Patient with multiple health concerns</td>
                    <td class="px-1 py-1 text-sm">$??? per visit</td>
                    <td class="px-1 py-1 text-sm"></td>
                    <td class="px-1 py-1 text-sm">
                        Basic information, Este-HIPAA Release Form, State of telemedicine Informed Consent (Select by state), Medication & Allergies, Credit Card Authorization Form
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</x-layouts.app>
