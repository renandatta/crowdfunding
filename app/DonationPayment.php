<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationPayment extends Model
{
    protected $fillable = [
        'donation_id', 'payment_type_id', 'unique_code', 'total'
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }
}
