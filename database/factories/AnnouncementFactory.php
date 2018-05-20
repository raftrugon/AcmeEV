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

    //Año actual academico
    $actual_academic_year = date('Y');                                   //Año actual

    if(date('m') > 8)                                                    //Si ha pasado septiembre crea las de este año tambien
        $actual_academic_year++;

    $subject_instances = SubjectInstance::where('academic_year',$actual_academic_year)->pluck('id')->toArray();

    return [
        'title' => $faker->realText($maxNbChars = 20, $indexSize = 2),
        'body' => $faker->realText($maxNbChars = 80, $indexSize = 2),
        'creation_moment' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now', $timezone = null),
        'subject_instance_id'=>$faker->randomElement($subject_instances),
    ];
});
