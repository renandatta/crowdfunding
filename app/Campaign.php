<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property integer featured_media
 * @property string featured_image
 * @property string featured_video
 * @property string title
 * @property string slug
 * @property string address
 * @property string village
 * @property string sub_district
 * @property string district
 * @property string province
 * @property string id
 */
class Campaign extends Model
{
    protected $fillable = [
        'campaign_type_id', 'user_id', 'title', 'description', 'province', 'district', 'sub_district', 'village', 'address',
        'target_fund', 'deadline', 'status', 'featured_media', 'featured_image', 'featured_video'
    ];

    public function campaignType()
    {
        return $this->belongsTo(CampaignType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class)
            ->where('status', '=', 'diverifikasi')
            ->where('is_deleted', '=', 0);
    }

    public function campaignDetails()
    {
        return $this->hasMany(CampaignDetail::class)
            ->where('is_deleted', '=', 0);
    }

    public function campaignFaqs()
    {
        return $this->hasMany(CampaignFaq::class)
            ->where('is_deleted', '=', 0);
    }

    public function campaignUpdates()
    {
        return $this->hasMany(CampaignUpdate::class)
            ->where('is_deleted', '=', 0);
    }

    public function campaignDiscussions()
    {
        return $this->hasMany(CampaignDiscussion::class)
            ->where('is_deleted', '=', 0)
            ->whereNull('parent_id')
            ->orderBy('id', 'desc');
    }

    public function campaignMedia()
    {
        return $this->featured_media == 1 ? $this->featured_image : $this->featured_video;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function percentageDonation()
    {
        $donations = $this->donations->sum('donation');
        return round(($donations / $this->target_fund) * 100);
    }

    public function fullAddress(){
        return join("<br>", [
            $this->address,
            $this->village . ', ' . $this->sub_district,
            $this->district . ', ' . $this->province,
        ]);
    }
}
