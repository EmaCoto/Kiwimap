<?php

use App\Livewire\Information\Form;
use App\Livewire\Information\Index as InformationIndexComponent;
use App\Models\Information\Index as InformationIndex;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(PermissionsSeeder::class);
    app(PermissionRegistrar::class)->forgetCachedPermissions();
});

test('a user with information permissions can create update and delete records', function () {
    $user = User::factory()->create();
    $user->givePermissionTo([
        'information.view',
        'information.create',
        'information.update',
        'information.delete',
    ]);

    $this->actingAs($user);

    Livewire::test(Form::class)
        ->set('name', 'Teléfono de soporte')
        ->set('information', '+1 555 123 4567')
        ->set('notes', 'Disponible de lunes a viernes.')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('information.index'));

    $record = InformationIndex::sole();

    Livewire::test(Form::class, ['informationRecord' => $record])
        ->set('name', 'Soporte principal')
        ->set('information', 'support@example.com')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('information.index'));

    expect($record->fresh())
        ->name->toBe('Soporte principal')
        ->information->toBe('support@example.com');

    Livewire::test(InformationIndexComponent::class)
        ->call('delete', $record->id);

    $this->assertDatabaseMissing('indices', ['id' => $record->id]);
});

test('information fields enforce their maximum lengths', function () {
    $user = User::factory()->create();
    $user->givePermissionTo(['information.create']);

    $this->actingAs($user);

    Livewire::test(Form::class)
        ->set('name', str_repeat('a', 151))
        ->set('information', str_repeat('b', 101))
        ->call('save')
        ->assertHasErrors([
            'name' => 'max',
            'information' => 'max',
        ]);
});

test('users without information permission cannot access the module', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('information.index'))
        ->assertForbidden();
});
