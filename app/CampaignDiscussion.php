<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignDiscussion extends Model
{
    use CampaignTrait;

    protected $fillable = [
        'campaign_id', 'parent_id', 'user_id', 'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(CampaignDiscussion::class, 'id', 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(CampaignDiscussion::class, 'parent_id', 'id')
            ->where('is_deleted', '=', 0)
            ->orderBy('id', 'asc');
    }
}
