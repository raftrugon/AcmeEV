<?php

use App\Degree;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería Informática - Ingeniería del Software','code'=>'AAA000001','new_students_limit'=>100]);
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería Informática - Ingeniería de Computadores','code'=>'AAA000002','new_students_limit'=>100]);
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería Informática - Tecnologías Informáticas','code'=>'AAA000003','new_students_limit'=>100]);
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería de la Salud','code'=>'AAA000004','new_students_limit'=>100]);

    }
}
