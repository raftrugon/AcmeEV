<?php

use App\Degree;
use App\Department;
use App\Subject;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class LecturersFromDepartmentsSeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();

        $minimum_number_lecturers = 4;
        $maximum_number_lecturers = 6;

        //////////////////////////////////////////////////////////////////////////////////////////////////////

        $departments_id = Department::all()->where('id','!=', 1)->pluck('id')->toArray();
        $count = count($departments_id);

        info('Seeding from '.$minimum_number_lecturers.' to '.$maximum_number_lecturers.' Lecturers for each Department and setting one to coordinator('.$count.' Departments).');

        foreach ($departments_id as $department_id) {                            //Por cada departamento

            $coordinator = true;                                                 //Contador para hacer el primer profesor coordinador

            $lecturers_per_department = $faker->numberBetween($minimum_number_lecturers, $maximum_number_lecturers);             //Numero aleatorio de profesores por departamento

            for ($j = 0; $j < $lecturers_per_department; $j++) {                 //Crea $lecturers_per_department lecturers


                $pas = User::firstOrCreate([
                    'name'=>$faker->firstName,
                    'surname'=>$faker->lastName,
                    'email'=>$faker->unique()->regexify('[a-z]{9}').'@pdi.us.es',
                    'id_number'=>$faker->unique()->regexify('[0-9]{8}[A-Z]{1}'),
                    'address'=>$faker->address,
                    'phone_number'=>$faker->phoneNumber,
                    'personal_email'=>$faker->email,
                    'department_id' => $department_id,
                    'password'=>bcrypt('pdi')
                ]);


                //Roles
                $pas->assignRole('pdi');

                //Permisos
                if($coordinator){
                    $pas->givePermissionTo('teach','direct_department');        //El primero es director de departamento
                    $coordinator = false;
                } else {
                    $pas->givePermissionTo('teach');
                }

            }

        }
    }
}