<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Roles
        $rstudent = Role::firstOrCreate(['id'=>1,'name'=>'student']);
        $rpdi = Role::firstOrCreate(['id'=>2,'name'=>'pdi']);
        $rpas = Role::firstOrCreate(['id'=>3,'name'=>'pas']);
        $radmin = Role::firstOrCreate(['id'=>4,'name'=>'admin']);

        //Permissions
        $pnew = Permission::firstOrCreate(['id'=>1,'name'=>'new']);
        $pcurrent = Permission::firstOrCreate(['id'=>2,'name'=>'current']);
        $pold = Permission::firstOrCreate(['id'=>3,'name'=>'old']);

        $pmanage = Permission::firstOrCreate(['id'=>5,'name'=>'manage']);
        $pdirect_department = Permission::firstOrCreate(['id'=>6,'name'=>'direct_department']);
        $pteach = Permission::firstOrCreate(['id'=>8,'name'=>'teach']);

        $phave_appointments = Permission::firstOrCreate(['id'=>9,'name'=>'have_appointments']);

    }
}
