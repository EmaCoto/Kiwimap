<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Database\Seeder;

class LicensesTableSeeder extends Seeder
{
    public function run(): void
    {
        License::factory()->active()->count(10)->create();
        License::factory()->renovation()->count(5)->create();
        License::factory()->expired()->count(5)->create();
    }
}
