<?php

use App\Http\Resources\RentalUnit\RentalUnitResource;
use App\Models\PaymentFrequency;
use App\Models\RentalUnit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

beforeEach(function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $this->seed();
});

test('can CREATE rental unit', function () {

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

test('can CREATE rental_unit w/o description', function () {
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

test('can UDPATE rental unit', function () {

    $freq = PaymentFrequency::first();
    $rentalUnit = RentalUnit::factory()->create([
        'unit_owner_id' => Auth::user()->id,
        'payment_frequency_id' => $freq->id,
    ]);

    $updatedDetailsPayload = [
        'unit_name' => 'Rental ni Chris brown',
        'base_rent_amount' => '2000.00',
        'payment_frequency_id' => $freq->id,
        'is_available' => true
    ];

    $response = $this->patchJson("/api/rental-units/{$rentalUnit->id}", $updatedDetailsPayload);

    $rentalUnit->refresh();

    $response->assertStatus(200)
        ->assertJson([
            'data' => (new RentalUnitResource($rentalUnit))->resolve(),
            'message' => 'Updated successfully',
        ]);
});

test('can CREATE tenant', function () {
    $freq = PaymentFrequency::first();
    $rentalUnit = RentalUnit::factory()->create([
        'unit_owner_id' => Auth::user()->id,
        'payment_frequency_id' => $freq->id,
    ]);

    $input = [
        'fullname' => 'Jason Tatum',
        'contact_number' => '09123456789',
        'email' => 'jisontitum@gmail.com',
    ];

    $response = $this->postJson("/api/rental-units/{$rentalUnit->id}/create-tenant", $input);

    $response->assertStatus(201);

    $this->assertDatabaseHas('rental_units', [
        'is_available' => false
    ]);
});

test('can CREATE tenant with downpayment', function () {
    $freq = PaymentFrequency::first();
    $rentalUnit = RentalUnit::factory()->create([
        'unit_owner_id' => Auth::user()->id,
        'payment_frequency_id' => $freq->id,
    ]);

    $input = [
        'fullname' => 'Jason Tatum',
        'contact_number' => '09123456789',
        'email' => 'jisontitum@gmail.com',
        'has_downpayment' => true,
        'payment_amount' => '1000.00',
        'date_paid' => now()
    ];

    $response = $this->postJson("/api/rental-units/{$rentalUnit->id}/create-tenant", $input);

    $response->assertStatus(201);

    $this->assertDatabaseHas('rental_units', [
        'is_available' => false
    ]);
    $this->assertDatabaseCount('rental_payments', 1);
});
