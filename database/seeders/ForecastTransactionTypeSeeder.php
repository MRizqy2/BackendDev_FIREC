<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForecastTransactionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ForecastTransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                "name" => "Income",
            ],
            [
                "name" => "Expense",
            ]
        ];

        foreach ($datas as $data) {
            ForecastTransactionType::create([
                'name' => $data['name']
            ]);
        }
    }
}
