<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Monitor;
use Faker\Generator as Faker;

$factory->define(Monitor::class, function (Faker $faker) {
    return [
        'url' => $faker->url,
        'app_name' => $faker->company,
        'visible_to_admin_only' => false,
    ];
});
