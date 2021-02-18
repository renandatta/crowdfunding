<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignFaq extends Model
{
    use CampaignTrait;

    protected $fillable = [
        'campaign_id', 'question', 'answer'
    ];
}
