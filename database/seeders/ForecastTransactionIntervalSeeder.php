<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ForecastTransactionInterval;

class ForecastTransactionIntervalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                "name" => "Harian",
            ],
            [
                "name" => "Mingguan",
            ],
            [
                "name" => "Bulanan",
            ],
            [
                "name" => "Tahunan",
            ]
        ];

        foreach ($datas as $data) {
            ForecastTransactionInterval::create([
                'name' => $data['name']
            ]);
        }
    }
}

