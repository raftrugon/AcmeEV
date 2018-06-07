<?php

namespace Tests\Unit;

use App\Degree;
use App\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;


class CesarGarciaPascualTest extends TestCase{

    public static $capsule;

   function setUp(){
        parent::setUp();
        $this::$capsule = new Capsule();
        $this::$capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'acmev_db',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $this::$capsule->bootEloquent();
        $this::$capsule->setAsGlobal();
        //$this::$capsule->connection()->beginTransaction();
        //parent::getConnection()->beginTransaction();
    }

    function tearDown(){
        /*$this::$capsule->connection()->rollBack();
        parent::getConnection()->rollBack();
        parent::tearDown();*/

    }


    public function testCreateDegree(){


        $user2 = User::findOrFail(5);

        $degree = [
            'name'=>'Grado 1',
            'new_students_limit'=>'5',
        ];

        $this::$capsule->connection()->beginTransaction();
        parent::getConnection()->beginTransaction();

        Session::start();

        $response = $this->actingAs($user2)->call('POST', 'management/degree/save', array('_token' => csrf_token(), 'name'=>'hola', 'new_students_limit'=>'0'));

        $response->assertLocation('degree/all');//assertStatus(302);


        $degree = Degree::orderBy('id', 'DESC')->first();


        echo($degree->getId());
        echo($degree->getName());

        $this->assertNotNull($degree);

        Session::flush();


        $this::$capsule->connection()->rollBack();
        parent::getConnection()->rollBack();
        parent::tearDown();

    }


}