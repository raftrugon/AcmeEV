<?php

use App\Degree;
use App\Department;
use App\Subject;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();

        $minimum_number_students = 4;
        $maximum_number_students = 10;

        //////////////////////////////////////////////////////////////////////////////////////////////////////

        $degrees_id = Degree::all()->pluck('id')->toArray();
        $count = count($degrees_id);

        info('Seeding from '.$minimum_number_students.' to '.$maximum_number_students.' Students for each Degree ('.$count.' Degrees).');

        foreach ($degrees_id as $degree_id) {                            //Por cada departamento



            $students_per_degree = $faker->numberBetween($minimum_number_students, $maximum_number_students);             //Numero aleatorio de estudiantes por grado

            for ($j = 0; $j < $students_per_degree; $j++) {                 //Crea $students_per_degree lecturers


                $student = User::firstOrCreate([
                    'name'=>$faker->firstName,
                    'surname'=>$faker->lastName,
                    'email'=>$faker->unique()->regexify('[a-z]{9}').'@alum.us.es',
                    'id_number'=>$faker->unique()->regexify('[0-9]{8}[A-Z]{1}'),
                    'address'=>$faker->address,
                    'phone_number'=>$faker->phoneNumber,
                    'personal_email'=>$faker->email,
                    'degree_id' => $degree_id,
                    'password'=>bcrypt('student')
                ]);


                //Roles y permisos
                $student->assignRole('student');
                $student->givePermissionTo('current');

            }

        }
    }
}