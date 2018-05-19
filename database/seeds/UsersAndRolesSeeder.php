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
        $pteach = Permission::firstOrCreate(['id'=>8,'name'=>'teach']);

        $phave_appointments = Permission::firstOrCreate(['id'=>9,'name'=>'have_appointments']);

        //Usuarios estáticos para pruebas

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

        User::firstOrCreate(['id'=>3,               //NO PONERLE DEPARTMENT
            'name'=>'Jorge',
            'surname'=>'Hernandez Rodriguez',
            'email'=>'jorherrod@pdi.us.es',
            'id_number'=>'11111111A',
            'address'=>'Calle de la delicia, 6',
            'phone_number'=>'611222333',
            'personal_email'=>'jorge.her@gmail.com',
            'password'=>bcrypt('pdi1')
        ]);
        $student1 = User::where('id',3)->first();
        $student1->givePermissionTo('manage','teach','direct_department');
        $student1->assignRole('pdi');


        User::firstOrCreate(['id'=>4,
            'name'=>'Cesar',
            'surname'=>'Garcia Pascual',
            'email'=>'cesgarpas@alum.us.es',
            'id_number'=>'32090358X',
            'address'=>'Avd. del colesterol, 38',
            'phone_number'=>'676666666',
            'personal_email'=>'cesgarpas@gmail.com',
            'password'=>bcrypt('student')
        ]);
        $student1 = User::where('id',4)->first();
        $student1->givePermissionTo('current');
        $student1->assignRole('student');


        User::firstOrCreate(['id'=>5,
            'name'=>'Jorge',
            'surname'=>'Puente Zara',
            'email'=>'jorpuezar@alum.us.es',
            'id_number'=>'44742618Y',
            'address'=>'Rotonda cuadrada, Piso 4 no. 21',
            'phone_number'=>'686666666',
            'personal_email'=>'jorpuezar@gmail.com',
            'password'=>bcrypt('student')
        ]);
        $student1 = User::where('id',5)->first();
        $student1->givePermissionTo('current');
        $student1->assignRole('student');


        //Usuarios auto-generados para rellenar

        //factory(App\User::class,2000)->create();

    }
}
