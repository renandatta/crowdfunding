<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CampaignFaq;
use Faker\Generator as Faker;

$factory->define(CampaignFaq::class, function (Faker $faker) {
    return [
        'question' => $faker->sentence(rand(3, 8)),
        'answer' => $faker->sentence(rand(3, 8)),
    ];
});
