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
        License::factory()->active()->count(10)->create();
        License::factory()->pending()->count(5)->create();
        License::factory()->expired()->count(5)->create();

    }
}
