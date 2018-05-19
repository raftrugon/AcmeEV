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
        $this->call(InscriptionSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(SubjectInstanceSeeder::class);
        $this->call(AnnouncementSeeder::class);
        $this->call(EnrollmentSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(ControlCheckSeeder::class);

    }
}
