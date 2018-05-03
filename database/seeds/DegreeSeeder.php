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
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería Informática - Ingeniería del Software','code'=>'AAA000001','new_students_limit'=>475]);
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería Informática - Ingeniería de Computadores','code'=>'AAA000002','new_students_limit'=>637]);
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería Informática - Tecnologías Informáticas','code'=>'AAA000003','new_students_limit'=>472]);
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería de la Salud','code'=>'AAA000004','new_students_limit'=>300]);
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería Industrial','code'=>'AAA000005','new_students_limit'=>453]);
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería Aeronaval','code'=>'AAA000006','new_students_limit'=>123]);
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería de Telecomunicaciones','code'=>'AAA000007','new_students_limit'=>235]);
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería Civil','code'=>'AAA000008','new_students_limit'=>12]);
        Degree::firstOrCreate(['name'=>'Grado en Administración de Empresas','code'=>'AAA000009','new_students_limit'=>15]);
        Degree::firstOrCreate(['name'=>'Grado en Derecho','code'=>'AAA000010','new_students_limit'=>1245]);
        Degree::firstOrCreate(['name'=>'Doble Grado en Física y Matemáticas','code'=>'AAA000011','new_students_limit'=>6]);
        Degree::firstOrCreate(['name'=>'Doble Grado en Derecho y Administración de Empresas','code'=>'AAA000012','new_students_limit'=>4]);
        Degree::firstOrCreate(['name'=>'Grado en Filología Inglesa','code'=>'AAA000013','new_students_limit'=>66]);
        Degree::firstOrCreate(['name'=>'Grado en Filología Española','code'=>'AAA000014','new_students_limit'=>123]);
        Degree::firstOrCreate(['name'=>'Grado en Filología Francesa','code'=>'AAA000015','new_students_limit'=>572]);
        Degree::firstOrCreate(['name'=>'Grado en Magisterio','code'=>'AAA000016','new_students_limit'=>475]);
        Degree::firstOrCreate(['name'=>'Grado en Psicología','code'=>'AAA000017','new_students_limit'=>864]);
        Degree::firstOrCreate(['name'=>'Grado en Criminología','code'=>'AAA000018','new_students_limit'=>457]);
        Degree::firstOrCreate(['name'=>'Grado en Audiovisuales','code'=>'AAA000019','new_students_limit'=>326]);



    }
}
