<?php

namespace Database\Seeders;

use App\Models\LoanProduct;
use Illuminate\Database\Seeder;

class LoanProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Crédit express',
                'description' => 'Petit crédit rapide remboursable sur 3 mois.',
                'min_amount' => 50000,
                'max_amount' => 300000,
                'interest_rate' => 5.00,
                'duration_months' => 3,
            ],
            [
                'name' => 'Crédit salaire',
                'description' => 'Crédit adapté aux salariés, remboursable sur 12 mois.',
                'min_amount' => 100000,
                'max_amount' => 1000000,
                'interest_rate' => 4.50,
                'duration_months' => 12,
            ],
            [
                'name' => 'Crédit entrepreneuriat',
                'description' => 'Financement pour petites entreprises sur 24 mois.',
                'min_amount' => 500000,
                'max_amount' => 5000000,
                'interest_rate' => 3.75,
                'duration_months' => 24,
            ],
        ];

        foreach ($products as $product) {
            LoanProduct::firstOrCreate(['name' => $product['name']], $product);
        }
    }
}
