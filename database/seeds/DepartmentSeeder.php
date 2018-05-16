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
        Department::firstOrCreate(['name'=>'Lenguajes y Sistemas Informáticos','code'=>'USDEP00001','website'=>'http://www.lsi.us.es/']);
        Department::firstOrCreate(['name'=>'Física','code'=>'USDEP00002','website'=>'http://departamento.us.es/dfisap1/etsii.htm']);
        Department::firstOrCreate(['name'=>'Tecnología Electrónica','code'=>'USDEP00003','website'=>'https://www.dte.us.es/']);
        Department::firstOrCreate(['name'=>'Ciencias de la Computación e Inteligencia Artificial','code'=>'USDEP00004','website'=>'https://www.cs.us.es/']);
        Department::firstOrCreate(['name'=>'Matemática aplicada','code'=>'USDEP00005','website'=>'http://www.ma1.us.es/']);

        factory(App\Department::class,200);


    }
}