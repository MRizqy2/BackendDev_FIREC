<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ForecastSimulation;

class UpdateTotalTransactionCommand extends Command
{
    protected $signature = 'app:update-total-transaction-command';

    protected $description = 'Update total transaksi for all forecast simulations';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $forecastSimulations = ForecastSimulation::all();

        foreach ($forecastSimulations as $forecastSimulation) {
            $forecastSimulation->updateTotalTransaksi();
        }

        $this->info('Total transaksi updated for all forecast simulations.');
    }

}
