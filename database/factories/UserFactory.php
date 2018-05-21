<?php

use App\Degree;
use App\Department;
use App\Inscription;
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

$factory->define(App\Inscription::class, function (Faker $faker) {
    $dni = $faker->unique->regexify('[0-9]{8}[A-Z]');
    return [
        'name'=>$faker->firstName,
        'surname'=>$faker->lastName,
        'address'=>$faker->address,
        'phone_number'=>$faker->phoneNumber,
        'grade'=>$faker->randomFloat(2,5,14),
        'email'=>$faker->unique->safeEmail,
        'id_number'=>$dni,
        'password'=>bcrypt($dni),
    ];
});

$factory->define(App\Request::class, function (Faker $faker) {
   return [
       'degree_id'=>$faker->randomElement(Degree::all()->pluck('id')->toArray()),
   ];
});





$factory->define(App\User::class, function(Faker $faker){
    $dni = $faker->unique->regexify('[0-9]{8}[A-Z]');
    $name = $faker->firstName;
    $lastnames = $faker->lastName.' '.$faker->lastName;
    $fullname = $name.' '.$lastnames;
    $email = explode(' ',$fullname);
    array_walk($email,function(&$value,$key){
       $value = substr($value,0,2);
    });
    $email = implode(' ',$email);
   return[
       'name'=>$name,
       'surname'=>$lastnames,
       'address'=>$faker->address,
       'phone_number'=>$faker->phoneNumber,
       'grade'=>$faker->randomFloat(2,5,14),
       'email'=>$email,
       'personal_email'=>$faker->safeEmail,
       'id_number'=>$dni,
       'password'=>bcrypt($email),
       'department_id'=>$faker->boolean(30) ? $faker->randomElement(Department::all()->pluck('id')->toArray()) : null,
   ];
});
