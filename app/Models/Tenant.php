<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    protected $guarded = [];

    public function rentalUnit(): BelongsTo {
        return $this->belongsTo(RentalUnit::class);
    }

    public function rentalPayments(): HasMany {
        return $this->hasMany(RentalPayment::class);
    }
}
