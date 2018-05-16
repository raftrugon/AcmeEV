<?php


use App\SubjectInstance;
use App\User;
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


$factory->define(App\Enrollment::class, function (Faker $faker) {
    return [
        'subject_instance_id'=>$faker->randomElement(SubjectInstance::all()->pluck('id')->toArray()),
        //'user_id'=>$faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_id'=>$faker->randomElement(User::join('model_has_permissions','users.id','=','model_has_permissions.model_id')->where('model_has_permissions.permission_id', 2)->get()->pluck('id')->toArray())
    ];
});
