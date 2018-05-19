<?php

use App\Announcement;
use App\Degree;
use App\Department;
use App\Subject;
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


/*$factory->define(App\Subject::class, function (Faker $faker){
    $department = $faker->randomElement(Department::all()->pluck('id')->toArray());
    return [
        'name'=>$faker->words(4,true),
        'code'=>$faker->unique->regexify('[A-Z]{3}[0-9]{6}'),
        'subject_type'=>$faker->randomElement(['OBLIGATORY','BASIC','OPTATIVE','EDP']),
        'school_year'=>$faker->numberBetween(1,4),
        'semester'=>$faker->boolean(70) ? $faker->boolean() : null,
        'department_id'=>$department,
        'degree_id'=>$faker->randomElement(Degree::all()->pluck('id')->toArray()),
        'coordinator_id'=>$faker->randomElement(User::where('department_id',$department)->get()->toArray()),
    ];
});*/

/*$factory->define(App\SubjectInstance::class, function (Faker $faker){
    $academic_year = $faker->numberBetween(2005, 2013);                                    //Año de comienzo de la asignatura
    $endFor = date('Y');                                                            //Año actual
    $subject_id = $faker->randomElement(Subject::all()->pluck('id')->toArray());     //Asignatura a crear instancias

    for($i = $academic_year; $i <= $endFor; $i++){                                          //Crea instancias desde el año de comienzo hasta el actual
        return [
            'academic_year'=>$academic_year,
            'subject_id'=>$subject_id,
        ];
    }
});*/
