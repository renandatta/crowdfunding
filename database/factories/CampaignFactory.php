<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Campaign;
use App\CampaignType;
use App\User;
use Faker\Generator as Faker;

$factory->define(Campaign::class, function (Faker $faker) {
    $campaignTypeCount = CampaignType::count();
    $userCount = User::count();
    $subDistricts = [
        ['name' => 'SIDOARJO', 'villages' => [['name' => 'BUDURAN'], ['name' => 'BLURU']]],
        ['name' => 'SUKODONO', 'villages' => [['name' => 'SARIROGO'], ['name' => 'SUKODONO']]]
    ];
    $subDistrictIndex = rand(0, 1);
    $villageIndex = rand(0, 1);
    $image_id = mt_rand(111111, 999999);
    return [
        'campaign_type_id' => rand(1, $campaignTypeCount),
        'user_id' => rand(2, $userCount),
        'title' => $faker->sentence(rand(5, 9)),
        'description' => $faker->paragraph(rand(2, 3)),
        'province' => 'JAWA TIMUR',
        'district' => 'SIDOARJO',
        'sub_district' => $subDistricts[$subDistrictIndex]['name'],
        'village' => $subDistricts[$subDistrictIndex]['villages'][$villageIndex]['name'],
        'address' => $faker->address,
        'target_fund' => mt_rand(00000000, 99999999),
        'deadline' => $faker->date('Y-m-d', '2022-12-31'),
        'status' => 'active',
        'featured_media' => 1,
        'featured_image' => 'https://source.unsplash.com/collection/'.$image_id.'/800x600',
    ];
});
