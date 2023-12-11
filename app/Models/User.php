<?php

namespace App\Models;

use AgileTeknik\Auth\AgileTeknikAuthUser;
use AgileTeknik\Auth\HasAgileTeknikAuth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements AgileTeknikAuthUser
{
    use HasAgileTeknikAuth;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'agileteknik_access_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'agileteknik_access_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function typeTransaction(): HasMany
    {
        return $this->hasMany(TransactionType::class);
    }

    public function forecastSimulations(): HasMany
    {
        return $this->hasMany(ForecastSimulation::class);
    }

    public function forecastTrasactions(): HasMany
    {
        return $this->hasMany(ForecastTransaction::class);
    }
}
