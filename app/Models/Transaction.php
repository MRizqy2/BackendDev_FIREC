<?php

namespace App\Models;

use App\Models\TransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'note', 'date', 'transaction_type_id', 'user_id'];

    public function typeTransaction(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
