<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Doctor, License, State};

class LicensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegura estados poblados antes
        if (State::count() === 0) $this->call(StatesTableSeeder::class);

        // Para cada doctor, 3-6 licencias aleatorias
        Doctor::all()->each(function($doc){
            License::factory()->count(rand(3,6))->create(['doctor_id'=>$doc->id]);
        });
    }
}
