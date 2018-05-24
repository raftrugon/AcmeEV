<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SystemConfigSeeder::class);
        $this->call(DegreeSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(UsersAndRolesSeeder::class);
        $this->call(RoomSeeder::class);

        //$this->call(DegreeSeeder::class);
        $this->call(DepartmentSeeder::class);                   //Basado en degrees
        $this->call(LecturersFromDepartmentsSeeder::class);     //Basado en departments

        $this->call(SubjectSeeder::class);                      //Basado en degrees
        $this->call(SubjectInstanceSeeder::class);              //Basado en subjects
        $this->call(GroupSeeder::class);                        //Basado en subject instances
        $this->call(ControlCheckSeeder::class);

        $this->call(StudentsSeeder::class);
        $this->call(EnrollmentsAndMinutesSeeder::class);        //Basado en los estudiantes, los grados, las asignaturas y sus instancias.

        $this->call(InscriptionSeeder::class);
        $this->call(AnnouncementSeeder::class);                 //Basado ene subject instances



    }
}
