<?php
namespace App;

trait CampaignTrait
{
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
