<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalPayment extends Model
{
    protected $guarded = [];

    public function rentalUnit(): BelongsTo {
        return $this->belongsTo(RentalUnit::class);
    }

    public function tenant(): BelongsTo {
        return $this->belongsTo(Tenant::class);
    }
}
