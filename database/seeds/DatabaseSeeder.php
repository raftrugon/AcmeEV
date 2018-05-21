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

        $this->call(DegreeSeeder::class);
        $this->call(DepartmentSeeder::class);                   //Basado en degrees
        $this->call(LecturersFromDepartmentsSeeder::class);     //Basado en departments

        $this->call(SubjectSeeder::class);                      //Basado en degrees
        $this->call(SubjectInstanceSeeder::class);              //Basado en subjects
        $this->call(AnnouncementSeeder::class);                 //Basado ene subject instances
        $this->call(GroupSeeder::class);                        //Basado en subject instances

        //TO DO  $this->call(StudentsSeeder::class);
        //TO DO  $this->call(EnrollmentAndMinuteSeeder::class);        //Basado en subject instances //Varias iteraciones de creación -> enrollments, minutes, enrollments, minutes...

        $this->call(InscriptionSeeder::class);
        $this->call(EnrollmentSeeder::class);                   //Será sustituido por EnrollmentAndMinuteSeeder


    }
}
