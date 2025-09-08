<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\License;
use App\Models\State;
use Illuminate\Database\Seeder;

class LicensesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ejemplo: crea 1-3 licencias por doctor, usando estados aleatorios
        $stateIds = State::pluck('id')->all();

        Doctor::query()->each(function (Doctor $doc) use ($stateIds) {
            $n = rand(1, 3);
            $picked = collect($stateIds)->shuffle()->take($n);

            foreach ($picked as $stateId) {
                License::factory()->create([
                    'doctor_id' => $doc->id,
                    'state_id'  => $stateId,
                ]);
            }
        });
    }
}
