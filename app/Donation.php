<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use CampaignTrait;

    protected $fillable = [
        'campaign_id', 'user_id', 'donation', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function donationPayment()
    {
        return $this->hasOne(DonationPayment::class);
    }
}
