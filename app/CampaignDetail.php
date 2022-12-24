<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignDetail extends Model
{
    use CampaignTrait;
    
    protected $fillable = [
        'campaign_id', 'type', 'no', 'content'
    ];
}
