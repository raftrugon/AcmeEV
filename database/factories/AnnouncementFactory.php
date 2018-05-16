<?php

use App\Announcement;
use App\SubjectInstance;
use Faker\Generator as Faker;


/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(App\Announcement::class, function (Faker $faker) {
    return [
        'title' => $faker->realText($maxNbChars = 15, $indexSize = 2),
        'body' => $faker->realText($maxNbChars = 80, $indexSize = 2),
        'creation_moment' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'subject_instance_id'=>$faker->randomElement(SubjectInstance::all()->pluck('id')->toArray()),
    ];
});
