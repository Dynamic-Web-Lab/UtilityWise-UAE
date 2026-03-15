<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function bills(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Bill::class);
    }

    public function consumptionRecords(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ConsumptionRecord::class);
    }

    public function alerts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Alert::class);
    }
}
