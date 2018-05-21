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
        $id = 45454;

        //////////////////////////////////////////////////////////////////////////////////////////////////////

        $departments_id = Department::all()->pluck('id')->toArray();

        foreach ($departments_id as $department_id) {                            //Por cada departamento

            $coordinator = true;                                                 //Contador para hacer el primer profesor coordinador

            $lecturers_per_department = $faker->numberBetween(2, 4);             //Numero aleatorio de profesores por departamento

            for ($j = 0; $j < $lecturers_per_department; $j++) {                 //Crea $lecturers_per_department lecturers

                //$department_id = $faker->randomElement(Department::all()->pluck('id')->toArray());

                $pas = User::firstOrCreate(['id'=>$id,
                    'name'=>$faker->firstName,
                    'surname'=>$faker->lastName,
                    'email'=>$faker->unique()->regexify('[a-z]{9}').'@pdi.us.es',
                    'id_number'=>$faker->unique()->regexify('[0-9]{8}[A-Z]{1}'),
                    'address'=>$faker->address,
                    'phone_number'=>$faker->phoneNumber,
                    'personal_email'=>$faker->email,
                    'department_id' => $department_id,
                    'password'=>bcrypt('pas')
                ]);

                //Roles
                $pas->assignRole('pdi');

                //Permisos
                if($coordinator){
                    $pas->givePermissionTo('teach','direct_department');        //El primero es coordinador
                    $coordinator = false;
                } else {
                    $pas->givePermissionTo('teach');
                }

                $id++;  //Incremento de id
            }

        }
    }
}