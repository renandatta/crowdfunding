<?php

use App\Campaign;
use App\CampaignDetail;
use App\CampaignFaq;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Campaign::class, 30)->create()->each(function ($campaign){
            $campaign->campaignDetails()->saveMany(factory(CampaignDetail::class, rand(5, 10))->make());
            $campaign->campaignFaqs()->saveMany(factory(CampaignFaq::class, rand(5, 10))->make());
        });
    }
}
