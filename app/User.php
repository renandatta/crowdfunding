<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $modules = [
        ['caption' => 'Dashboard', 'url' => 'admin', 'icon' => 'la la-dashboard'],
        ['caption' => 'Data Master', 'url' => '#', 'icon' => 'la la-folder-open', 'sub_modules' => [
            ['caption' => 'User', 'url' => 'admin.user'],
            ['caption' => 'Jenis Bantuan', 'url' => 'admin.campaign_type'],
            ['caption' => 'Jenis Pembayaran', 'url' => 'admin.payment_type'],
        ]],
        ['caption' => 'Bantuan', 'url' => 'admin.campaign', 'icon' => 'la la-star'],
        ['caption' => 'Donasi', 'url' => 'admin.donation', 'icon' => 'la la-money'],
    ];

    protected $fillable = [
        'name', 'email', 'password', 'user_level', 'phone', 'city', 'address'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function modulAvailable()
    {
        return json_decode(json_encode($this->modules), false);
    }

    public function userDonations()
    {
        return $this->hasMany(Donation::class)
            ->where('is_deleted', '=', 0);
    }

    public function userDiscussions()
    {
        return $this->hasMany(CampaignDiscussion::class)
            ->where('is_deleted', '=', 0);
    }
}
