<?php

use App\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Department::firstOrCreate(['name'=>'Lenguajes y Sistemas Informáticos','code'=>'USD000001','website'=>'http://www.lsi.us.es/']);
        Department::firstOrCreate(['name'=>'Física','code'=>'USD000002','website'=>'http://departamento.us.es/dfisap1/etsii.htm']);
        Department::firstOrCreate(['name'=>'Tecnología Electrónica','code'=>'USD000003','website'=>'https://www.dte.us.es/']);
        Department::firstOrCreate(['name'=>'Ciencias de la Computación e Inteligencia Artificial','code'=>'USD000004','website'=>'https://www.cs.us.es/']);
        Department::firstOrCreate(['name'=>'Matemática aplicada','code'=>'USD000005','website'=>'http://www.ma1.us.es/']);*/

        $number_of_departments = 10;

        //////////////////////////////////////////////////////////////

        info('Seeding '.$number_of_departments.' Departments with random names.');

        factory(App\Department::class,$number_of_departments)->create();


    }
}