<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForecastSimulation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'total_transaction'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function forecastTransactions(): HasMany
    {
        return $this->hasMany(ForecastTransaction::class, 'forecast_simulation_id');
    }

    public function calculateTotalByType($forecastTransactionTypeId)
    {
        return $this->forecastTransactions
            ->where('forecast_transaction_type_id', $forecastTransactionTypeId)
            ->sum('amount');
    }

    public function updateTotalTransaksi()
    {
        $totalIncome = 0;
        $totalOutcome = 0;

        $intervalMultipliers = [
            5 => 365,
            6 => 52,
            7 => 12,
            8 => 1,
        ];

        for ($i = 1; $i <= 2; $i++) {
            $forecastTransactionTypeId = $i;

            for ($j = 5; $j <= 8; $j++) {
                $forecastTransactionIntervalId = $j;

                if ($forecastTransactionTypeId == 1) {
                    $totalIncome += $this->calculateTotalForInterval(
                        $forecastTransactionTypeId,
                        $forecastTransactionIntervalId,
                        $intervalMultipliers
                    );
                } elseif ($forecastTransactionTypeId == 2) {
                    $totalOutcome += $this->calculateTotalForInterval(
                        $forecastTransactionTypeId,
                        $forecastTransactionIntervalId,
                        $intervalMultipliers
                    );
                }
            }
        }

        $this->total_transaction = $totalIncome - $totalOutcome;

        $this->save();
    }

    private function calculateTotalForInterval(
        $forecastTransactionTypeId,
        $forecastTransactionIntervalId,
        $intervalMultipliers
    )
    {
        $transactionType = ForecastTransactionType::find($forecastTransactionTypeId);

        if (!$transactionType) {
            return 0;
        }

        return $this->forecastTransactions
            ->where('forecast_transaction_type_id', $forecastTransactionTypeId)
            ->where('forecast_transaction_interval_id', $forecastTransactionIntervalId)
            ->sum('amount') * $intervalMultipliers[$forecastTransactionIntervalId];
    }
}
