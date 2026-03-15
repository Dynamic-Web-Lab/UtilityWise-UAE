<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsumptionRecord extends Model
{
    use HasFactory;

    protected $table = 'consumption_records';

    protected $fillable = [
        'user_id',
        'bill_id',
        'record_date',
        'kwh',
        'gallons',
        'amount_aed',
        'provider',
    ];

    protected function casts(): array
    {
        return [
            'record_date' => 'date',
            'kwh' => 'decimal:2',
            'gallons' => 'decimal:2',
            'amount_aed' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }
}
