<?php

namespace Database\Seeders;

use App\Models\RentalUnit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            PaymentFrequencySeeder::class,
        ]);

        User::factory()->create([
            'first_name' => 'Jhon',
            'last_name' => 'Doe',
            'contact_number' => '09514135319',
            'email' => 'test@example.com',
            'password' => 'test'
        ]);

        User::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'contact_number' => '09514135319',
            'email' => 'test2@example.com',
            'password' => 'test'
        ]);


        RentalUnit::factory(10)->create();
    }
}
