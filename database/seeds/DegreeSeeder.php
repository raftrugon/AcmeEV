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
        info('Seeding 11 Degrees.');

        //////////////////////////////////////////////////////////////

        Degree::firstOrCreate(['name'=>'Grado en Ingeniería Informática - Ingeniería del Software','code'=>'AAA000001','new_students_limit'=>25,'deleted'=>false]);
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería Informática - Ingeniería de Computadores','code'=>'AAA000002','new_students_limit'=>35,'deleted'=>false]);
        Degree::firstOrCreate(['name'=>'Grado en Ingeniería Industrial','code'=>'AAA000005','new_students_limit'=>15,'deleted'=>false]);

        Degree::firstOrCreate(['name'=>'Grado en Ingeniería de Telecomunicaciones','code'=>'AAA000007','new_students_limit'=>26,'deleted'=>false]);
        Degree::firstOrCreate(['name'=>'Grado en Administración de Empresas','code'=>'AAA000009','new_students_limit'=>15,'deleted'=>false]);
        Degree::firstOrCreate(['name'=>'Grado en Derecho','code'=>'AAA000010','new_students_limit'=>45,'deleted'=>false]);

        /*Degree::firstOrCreate(['name'=>'Grado en Filología Inglesa','code'=>'AAA000013','new_students_limit'=>56,'deleted'=>false]);
        Degree::firstOrCreate(['name'=>'Grado en Filología Francesa','code'=>'AAA000015','new_students_limit'=>38,'deleted'=>false]);
        Degree::firstOrCreate(['name'=>'Grado en Magisterio','code'=>'AAA000016','new_students_limit'=>42,'deleted'=>false]);

        Degree::firstOrCreate(['name'=>'Grado en Criminología','code'=>'AAA000018','new_students_limit'=>34,'deleted'=>false]);
        Degree::firstOrCreate(['name'=>'Grado en Audiovisuales','code'=>'AAA000019','new_students_limit'=>37,'deleted'=>false]);*/

        //Degree::firstOrCreate(['name'=>'Grado en Ingeniería Informática - Tecnologías Informáticas','code'=>'AAA000003','new_students_limit'=>472,'deleted'=>false]);
        //Degree::firstOrCreate(['name'=>'Grado en Ingeniería de la Salud','code'=>'AAA000004','new_students_limit'=>24,'deleted'=>false]);
        //Degree::firstOrCreate(['name'=>'Doble Grado en Física y Matemáticas','code'=>'AAA000011','new_students_limit'=>6,'deleted'=>false]);
        //Degree::firstOrCreate(['name'=>'Doble Grado en Derecho y Administración de Empresas','code'=>'AAA000012','new_students_limit'=>4,'deleted'=>false]);
        //Degree::firstOrCreate(['name'=>'Grado en Ingeniería Civil','code'=>'AAA000008','new_students_limit'=>12,'deleted'=>false]);
        //Degree::firstOrCreate(['name'=>'Grado en Filología Española','code'=>'AAA000014','new_students_limit'=>123,'deleted'=>false]);
        //Degree::firstOrCreate(['name'=>'Grado en Psicología','code'=>'AAA000017','new_students_limit'=>864,'deleted'=>false]);
        //Degree::firstOrCreate(['name'=>'Grado en Ingeniería Aeronaval','code'=>'AAA000006','new_students_limit'=>123,'deleted'=>false]);


    }
}
