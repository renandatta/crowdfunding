<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignUpdate extends Model
{
    use CampaignTrait;

    protected $fillable = [
        'campaign_id', 'title', 'content', 'featured_media', 'featured_image', 'featured_video'
    ];
}
