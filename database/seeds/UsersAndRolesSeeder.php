<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersAndRolesSeeder extends Seeder
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
        $pcoordinate_subject = Permission::firstOrCreate(['id'=>7,'name'=>'coordinate_subject']);
        $pteach = Permission::firstOrCreate(['id'=>8,'name'=>'teach']);

        $phave_appointments = Permission::firstOrCreate(['id'=>9,'name'=>'have_appointments']);


        User::firstOrCreate(['id'=>1,
            'name'=>'Juana',
            'surname'=>'Vargas Pérez',
            'email'=>'juavarper@pas.us.es',
            'id_number'=>'44444444A',
            'address'=>'Calle de la soledad, 11',
            'phone_number'=>'612345678',
            'personal_email'=>'juanavargas@gmail.com',
            'password'=>bcrypt('pas1')
        ]);
        $pas1 = User::where('id',1)->first();
        $pas1->givePermissionTo('have_appointments');
        $pas1->assignRole('pas');

        User::firstOrCreate(['id'=>2,
            'name'=>'Pablo',
            'surname'=>'Tabares García',
            'email'=>'pabtabgar@alum.us.es',
            'id_number'=>'44742619Y',
            'address'=>'Calle de la amargura, 23',
            'phone_number'=>'666666666',
            'personal_email'=>'ptabaresg@gmail.com',
            'password'=>bcrypt('student1')
        ]);
        $student1 = User::where('id',2)->first();
        $student1->givePermissionTo('current');
        $student1->assignRole('student');
    }
}
