<?php

use App\Livewire\Dashboard\Metrics;
use App\Livewire\Licenses\Form as LicenseForm;
use App\Livewire\Licenses\Index as LicensesIndex;
use App\Models\Doctor;
use App\Models\License;
use App\Models\State;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Support\Facades\Artisan;
use Livewire\Livewire;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function () {
    $this->seed(PermissionsSeeder::class);
    app(PermissionRegistrar::class)->forgetCachedPermissions();
});

it('normalizes legacy pending statuses in dashboard metrics', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');
    $this->actingAs($admin);

    $doctorA = Doctor::factory()->create();
    $doctorB = Doctor::factory()->create();

    $operationalState = State::factory()->create([
        'name' => 'Operational State',
        'code' => 'OP',
        'is_operational' => true,
    ]);

    $inactiveState = State::factory()->create([
        'name' => 'Inactive State',
        'code' => 'IN',
        'is_operational' => false,
    ]);

    License::factory()->create([
        'doctor_id' => $doctorA->id,
        'state_id' => $operationalState->id,
        'issued_date' => '2025-01-01',
        'expiration_date' => now()->addDays(20)->format('Y-m-d'),
        'status' => 'active',
    ]);

    License::factory()->create([
        'doctor_id' => $doctorA->id,
        'state_id' => $inactiveState->id,
        'issued_date' => '2025-01-02',
        'expiration_date' => now()->addDays(35)->format('Y-m-d'),
        'status' => 'renovation',
    ]);

    License::factory()->create([
        'doctor_id' => $doctorB->id,
        'state_id' => $operationalState->id,
        'issued_date' => '2025-01-03',
        'expiration_date' => now()->addDays(50)->format('Y-m-d'),
        'status' => 'pending',
    ]);

    License::factory()->create([
        'doctor_id' => $doctorB->id,
        'state_id' => $inactiveState->id,
        'issued_date' => '2025-01-04',
        'expiration_date' => now()->subDays(10)->format('Y-m-d'),
        'status' => 'expired',
    ]);

    Livewire::test(Metrics::class)
        ->assertSet('licensesCount', 4)
        ->assertSet('byStatus', [
            'active' => 1,
            'renovation' => 2,
            'expired' => 1,
        ]);
});

it('includes legacy pending licenses when filtering renovation status', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');
    $this->actingAs($admin);

    $activeDoctor = Doctor::factory()->for(User::factory()->state(['name' => 'Dr Active']))->create();
    $renovationDoctor = Doctor::factory()->for(User::factory()->state(['name' => 'Dr Renovation']))->create();
    $pendingDoctor = Doctor::factory()->for(User::factory()->state(['name' => 'Dr Pending']))->create();

    $operationalState = State::factory()->create(['name' => 'Operational State', 'code' => 'OP']);
    $inactiveState = State::factory()->create(['name' => 'Inactive State', 'code' => 'IN', 'is_operational' => false]);

    License::factory()->create([
        'doctor_id' => $activeDoctor->id,
        'state_id' => $operationalState->id,
        'issued_date' => '2025-02-01',
        'status' => 'active',
    ]);

    License::factory()->create([
        'doctor_id' => $renovationDoctor->id,
        'state_id' => $operationalState->id,
        'issued_date' => '2025-02-02',
        'status' => 'renovation',
    ]);

    License::factory()->create([
        'doctor_id' => $pendingDoctor->id,
        'state_id' => $inactiveState->id,
        'issued_date' => '2025-02-03',
        'status' => 'pending',
    ]);

    Livewire::test(LicensesIndex::class)
        ->set('status', 'renovation')
        ->assertSee('Dr Renovation')
        ->assertSee('Dr Pending')
        ->assertDontSee('Dr Active');
});

it('allows editing a historical license linked to an inactive state', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');
    $this->actingAs($admin);

    Artisan::spy();

    $doctor = Doctor::factory()->create();
    $inactiveState = State::factory()->create([
        'name' => 'Historical State',
        'code' => 'HS',
        'is_operational' => false,
    ]);

    $license = License::factory()->create([
        'doctor_id' => $doctor->id,
        'state_id' => $inactiveState->id,
        'issued_date' => '2025-03-01',
        'expiration_date' => '2026-03-01',
        'status' => 'pending',
    ]);

    Livewire::test(LicenseForm::class, ['license' => $license])
        ->assertSet('status', 'renovation')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('licenses.index'));

    expect($license->fresh()->status)->toBe('renovation');

    Artisan::shouldHaveReceived('call')
        ->once()
        ->with('licenses:send-reminders', ['--id' => $license->id]);
});
