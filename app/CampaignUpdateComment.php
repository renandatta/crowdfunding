<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignUpdateComment extends Model
{
    protected $fillable = [
        'campaign_update_id', 'parent_id', 'user_id', 'content'
    ];

    public function campaignUpdate()
    {
        return $this->belongsTo(CampaignUpdate::class);
    }

    public function parent()
    {
        return $this->belongsTo(CampaignUpdate::class, 'id', 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(CampaignUpdate::class, 'parent_id', 'id')
            ->where('id_deleted', '=', 0);
    }
}
