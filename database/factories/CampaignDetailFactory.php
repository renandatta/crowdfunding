<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CampaignDetail;
use Faker\Generator as Faker;

$factory->define(CampaignDetail::class, function (Faker $faker) {
    $types = ['image', 'text'];
    $type = $types[array_rand($types)];
    $image_id = mt_rand(111111, 999999);
    $content = $type == 'image' ? 'https://source.unsplash.com/collection/'.$image_id.'/800x600' : $faker->paragraph(rand(3, 20));
    static $no = 1;
    return [
        'type' => $type,
        'no' => $no++,
        'content' => trim($content)
    ];
});
