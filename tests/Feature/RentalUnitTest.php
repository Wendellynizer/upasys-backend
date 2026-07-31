<?php

use App\Models\PaymentFrequency;
use App\Models\RentalUnit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

beforeEach(function() {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $this->seed();
});

test('can CREATE rental unit', function() {

    $freq = PaymentFrequency::first();

    $payload = [
        'unit_name' => 'Rental 1',
        'description' => 'Test description',
        'base_rent_amount' => '1500.00',
        'payment_frequency_id' => $freq->id,
        'is_available' => true
    ];

    $response = $this->postJson('/api/rental-units', $payload);

    $response->assertCreated();

    $this->assertDatabaseHas('rental_units', [
        'unit_name' => 'Rental 1'
    ]);
});

test('can CREATE rental_unit w/o description', function() {
    $freq = PaymentFrequency::first();

    $payload = [
        'unit_name' => 'Rental 1',
        'base_rent_amount' => '1500.00',
        'payment_frequency_id' => $freq->id,
        'is_available' => true
    ];

    $response = $this->postJson('/api/rental-units', $payload);

    $response->assertCreated();

    $this->assertDatabaseHas('rental_units', [
        'unit_owner_id' => 1
    ]);
});

test('can UDPATE rental unit', function() {

    $freq = PaymentFrequency::first();
    $rentalUnit = RentalUnit::first();

    $updatedDetailsPayload = [
        'unit_name' => 'Rental ni Chris brown',
        'base_rent_amount' => '2000.00',
        'payment_frequency_id' => $freq->id,
        'is_available' => true
    ];

    $response = $this->patchJson("/api/rental-units/{$rentalUnit->id}", $updatedDetailsPayload);

    $response->assertStatus(200)
        ->assertJson([
            'data' => $updatedDetailsPayload,
            'message' => 'Updated successfully',
        ]);
});