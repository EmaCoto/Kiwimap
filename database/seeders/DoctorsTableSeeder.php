<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor;


class DoctorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Doctor::factory()->count(3)->create()->each(function ($doc) {
            if ($doc->user) {
                $doc->user->assignRole('Doctor');
                if (!$doc->user->email_verified_at) {
                    $doc->user->forceFill(['email_verified_at' => now()])->save();
                }
            }
        });
    }
}
