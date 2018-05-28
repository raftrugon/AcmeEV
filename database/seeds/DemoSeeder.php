<?php

use App\Degree;
use App\Department;
use App\Subject;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();

        info('Seeding from  Departments).');


        $department_id = Department::where('id', 1)->pluck('id')->first();

        ///////////////////////////////////////// PDIs /////////////////////////////////////////

        $coordinator = User::firstOrCreate([
            'name' => 'Juan',
            'surname' => 'Ortiz',
            'email' => 'coordinator@pdi.us.es',
            'id_number' => $faker->unique()->regexify('[0-9]{8}[A-Z]{1}'),
            'address' => $faker->address,
            'phone_number' => $faker->phoneNumber,
            'personal_email' => $faker->email,
            'department_id' => $department_id,
            'password' => bcrypt('coordinator')
        ]);

        $coordinator->assignRole('pdi');
        $coordinator->givePermissionTo('teach', 'direct_department');        //El primero es coordinador



        $lecturer1 = User::firstOrCreate([
            'name' => 'Pepe',
            'surname' => 'Dominguez',
            'email' => 'lecturer1@pdi.us.es',
            'id_number' => $faker->unique()->regexify('[0-9]{8}[A-Z]{1}'),
            'address' => $faker->address,
            'phone_number' => $faker->phoneNumber,
            'personal_email' => $faker->email,
            'department_id' => $department_id,
            'password' => bcrypt('lecturer')
        ]);

        $lecturer1->assignRole('pdi');
        $lecturer1->givePermissionTo('teach');




        $lecturer2 = User::firstOrCreate([
            'name' => 'Jose',
            'surname' => 'Alvarez',
            'email' => 'lecturer2@pdi.us.es',
            'id_number' => $faker->unique()->regexify('[0-9]{8}[A-Z]{1}'),
            'address' => $faker->address,
            'phone_number' => $faker->phoneNumber,
            'personal_email' => $faker->email,
            'department_id' => $department_id,
            'password' => bcrypt('lecturer')
        ]);

        $lecturer2->assignRole('pdi');
        $lecturer2->givePermissionTo('teach');


        ///////////////////////////////////////// STUDENTS /////////////////////////////////////////

        $student1 = User::firstOrCreate([
            'name'=>'Ana',
            'surname'=>'Morales',
            'email'=>'student1@alum.us.es',
            'id_number'=>$faker->unique()->regexify('[0-9]{8}[A-Z]{1}'),
            'address'=>$faker->address,
            'phone_number'=>$faker->phoneNumber,
            'personal_email'=>$faker->email,
            'degree_id' => 1,
            'password'=>bcrypt('student')
        ]);

        $student1->assignRole('student');
        $student1->givePermissionTo('current');




        $student2 = User::firstOrCreate([
            'name'=>'Miguel',
            'surname'=>'Hernandez',
            'email'=>'student2@alum.us.es',
            'id_number'=>$faker->unique()->regexify('[0-9]{8}[A-Z]{1}'),
            'address'=>$faker->address,
            'phone_number'=>$faker->phoneNumber,
            'personal_email'=>$faker->email,
            'degree_id' => 1,
            'password'=>bcrypt('student')
        ]);

        $student2->assignRole('student');
        $student2->givePermissionTo('current');






    }
}