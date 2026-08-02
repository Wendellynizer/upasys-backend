<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RentalUnit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function owner(): BelongsTo {
        return $this->belongsTo(User::class, 'unit_owner_id');
    }

    public function paymentFrequency(): HasOne {
        return $this->hasOne(PaymentFrequency::class);
    }

    public function tenant(): HasOne {
        return $this->hasOne(Tenant::class);
    }

    public function rentalPayments(): HasMany {
        return $this->hasMany(RentalPayment::class);
    }
}
