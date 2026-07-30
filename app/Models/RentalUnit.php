<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RentalUnit extends Model
{
    protected $guarded = [
        'unit_owner_id'
    ];

    public function owner(): BelongsTo {
        return $this->belongsTo(User::class, 'unit_owner_id');
    }

    public function paymentFrequency(): HasOne {
        return $this->hasOne(PaymentFrequency::class);
    }
}
