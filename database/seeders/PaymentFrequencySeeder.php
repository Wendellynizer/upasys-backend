<?php

namespace Database\Seeders;

use App\Models\PaymentFrequency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentFrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentFrequencies = [
            ['frequency_name' => 'Monthly', 'months_count' => 1],
            ['frequency_name' => 'Bimonthly', 'months_count' => 2],
            ['frequency_name' => 'Quarterly', 'months_count' => 3],
        ];

        foreach ($paymentFrequencies as $paymentFreq) {
            PaymentFrequency::create($paymentFreq);
        }
    }
}
