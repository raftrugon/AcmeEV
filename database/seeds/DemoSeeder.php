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

        info('Seeding objects for demo.');


        $department_id = Department::where('id', 1)->pluck('id')->first();

        ///////////////////////////////////////// WEBMASTER /////////////////////////////////////////

        $webmaster = User::firstOrCreate([
            'name'=>'Web',
            'surname'=>'Master',
            'email'=>'webmaster@us.es',
            'id_number'=>'44742618Y',
            'address'=>'Master direction',
            'phone_number'=>'666000666',
            'personal_email'=>'webmaster@gmail.com',
            'password'=>bcrypt('webmaster')
        ]);

        $webmaster->assignRole('student');
        $webmaster->assignRole('pdi');
        $webmaster->assignRole('pas');
        $webmaster->assignRole('admin');
        $webmaster->givePermissionTo('new');
        $webmaster->givePermissionTo('current');
        $webmaster->givePermissionTo('old');
        $webmaster->givePermissionTo('manage');
        $webmaster->givePermissionTo('direct_department');
        $webmaster->givePermissionTo('teach');
        $webmaster->givePermissionTo('have_appointments');

        ///////////////////////////////////////// PAS /////////////////////////////////////////

        $pas = User::firstOrCreate([
            'name'=>'Juana',
            'surname'=>'Vargas Pérez',
            'email'=>'pas@pas.us.es',
            'id_number'=>'44444444A',
            'address'=>'Calle de la soledad, 11',
            'phone_number'=>'612345678',
            'personal_email'=>'juanavargas@gmail.com',
            'password'=>bcrypt('pas')
        ]);

        $pas->givePermissionTo('have_appointments');
        $pas->assignRole('pas');

        ///////////////////////////////////////// PDIs /////////////////////////////////////////

        $pdimaster = User::firstOrCreate([
            'name' => 'Juan',
            'surname' => 'Domingo',
            'email' => 'pdimaster@pdi.us.es',
            'id_number' => $faker->unique()->regexify('[0-9]{8}[A-Z]{1}'),
            'address' => $faker->address,
            'phone_number' => $faker->phoneNumber,
            'personal_email' => $faker->email,
            'department_id' => $department_id,
            'password' => bcrypt('pdimaster')
        ]);

        $pdimaster->assignRole('pdi');
        $pdimaster->givePermissionTo('manage', 'teach', 'direct_department');


        $manager = User::firstOrCreate([
            'name' => 'Juana',
            'surname' => 'Dominguez',
            'email' => 'manager@pdi.us.es',
            'id_number' => $faker->unique()->regexify('[0-9]{8}[A-Z]{1}'),
            'address' => $faker->address,
            'phone_number' => $faker->phoneNumber,
            'personal_email' => $faker->email,
            'department_id' => null,
            'password' => bcrypt('manager')
        ]);

        $manager->assignRole('pdi');
        $manager->givePermissionTo('manage');


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
        $coordinator->givePermissionTo('teach', 'direct_department');        //Coordinador del departamento



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