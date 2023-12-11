<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForecastTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'forecast_simulation_id',
        'forecast_transaction_type_id',
        'forecast_transaction_interval_id',
        'name',
        'amount'
    ];

    public function forecastSimulation(): BelongsTo
    {
        return $this->belongsTo(ForecastSimulation::class);
    }

    public function forecastTransactionType(): BelongsTo
    {
        return $this->belongsTo(ForecastTransactionType::class);
    }

    public function forecastTransactionInterval(): BelongsTo
    {
        return $this->belongsTo(ForecastTransactionInterval::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($transaction) {
            $transaction->forecastSimulation->updateTotalTransaksi();
        });

        static::created(function ($transaction) {
            $transaction->forecastSimulation->updateTotalTransaksi();
        });

        static::deleted(function ($transaction) {
            $transaction->forecastSimulation->updateTotalTransaksi();
        });
    }

}
