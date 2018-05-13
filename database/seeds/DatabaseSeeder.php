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
        $this->call(DegreeSeeder::class);
        $this->call(UsersAndRolesSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(SystemConfigSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(InscriptionSeeder::class);
    }
}
