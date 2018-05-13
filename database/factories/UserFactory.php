<?php

use App\Degree;
use App\Inscription;
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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Inscription::class, function (Faker $faker) {
    $dni = $faker->unique->regexify('[0-9]{8}[A-Z]');
    return [
        'name'=>$faker->firstName,
        'surname'=>$faker->lastName,
        'address'=>$faker->address,
        'phone_number'=>$faker->phoneNumber,
        'grade'=>$faker->randomFloat(2,5,14),
        'email'=>$faker->safeEmail,
        'id_number'=>$dni,
        'password'=>bcrypt($dni),
    ];
});

$factory->define(App\Request::class, function (Faker $faker) {
   return [
       'degree_id'=>$faker->randomElement(Degree::all()->pluck('id')->toArray()),
   ];
});
