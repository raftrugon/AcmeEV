<?php

namespace Tests\Unit;

use App\ControlCheckInstance;
use App\Enrollment;
use App\User;
use App\Minute;
use App\Repositories\MinuteRepo;
use App\Repositories\ControlCheckInstanceRepo;
use App\Repositories\ControlCheckRepo;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    MinuteTest
 */
class MinuteTest extends TestCase{

    public static $capsule;

    function setUp(){
        parent::setUp();
        $this::$capsule->connection()->beginTransaction();
        parent::getConnection()->beginTransaction();
    }

    function tearDown(){
        $this::$capsule->connection()->rollBack();
        parent::getConnection()->rollBack();
        parent::tearDown();

    }

    /**
     * @dataProvider getMinutesForStudentProvider
     */
    public function testGetMinutesForStudent($auth_login, $user_id, $expected_number, $expected_exception,
                                                         $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("User ID: ".$user_id."\n");
        echo("Expected Number: ".$expected_number."\n");
        echo("-----------------------------------------------------------------\n");

        $controlCheckInstanceRepo = new ControlCheckInstanceRepo();
        $controlCheckRepo = new ControlCheckRepo($controlCheckInstanceRepo);
        $minuteRepo = new MinuteRepo($controlCheckRepo, $controlCheckInstanceRepo);

        if($auth_login){
            Auth::loginUsingId($user_id);
            $this->assertTrue(Auth::check());
            $results = $minuteRepo->getMinutesForStudent();
        }
        else{
            $user = User::find($user_id);
            $results = $minuteRepo->getMinutesForStudent($user);
        }

        $total = $results->count();

        foreach($results->get() as $r){
            echo($r."\n");
        }

        echo("Resultado obtenido: ".$total." (Esperado: ".$expected_number.")\n");

        if($expected_exception)
            $this->assertNotEquals($expected_number, $total);
        else
            $this->assertEquals($expected_number, $total);

    }

    public function getMinutesForStudentProvider()
    {
        $this->assertTrue(true);

        $this::$capsule = new Capsule();
        $this::$capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'acmeev_db',
            'username'  => 'root',
            'password'  => '1234',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $this::$capsule->bootEloquent();
        $this::$capsule->setAsGlobal();

        echo("===============================================================================================================\n");
        echo("=====================================TEST MINUTES FOR STUDENT==================================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [true, 9, 16, false,
                "Obtener todas las actas de Ana Morales (usando login)."],
            [false, 10, 7, false,
                "Obtener todas las actas de Miguel Hernández (sin usar login)."],
            [true, 11, 7, true,
                "Obtener todas las actas de Miguela Gómez esperando obtener 7."],

        ];

    }

    /**
     * @dataProvider setAllStatusTrueProvider
     */
    public function testSetAllStatusTrue($expected_number, $expected_exception,
                                             $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("Expected Number: ".$expected_number."\n");
        echo("-----------------------------------------------------------------\n");

        $controlCheckInstanceRepo = new ControlCheckInstanceRepo();
        $controlCheckRepo = new ControlCheckRepo($controlCheckInstanceRepo);
        $minuteRepo = new MinuteRepo($controlCheckRepo, $controlCheckInstanceRepo);

        $minutes = Minute::all();

        $count = 0;
        foreach($minutes as $min){
            $min->setStatus(0);
            $min->save();
            $count++;
            if($count==3)
                break;
        }

        $results = Minute::where('status',0);

        $total = $results->count();

        echo("Antes: ".$total.":\n");

        foreach($results->get() as $r){
            echo($r."\n");
        }

        $minuteRepo->setAllStatusTrue();

        echo("Antes: ".$total.":\n");

        $results = Minute::where('status',0);

        $total = $results->count();

        foreach($results->get() as $r){
            echo($r."\n");
        }

        echo("Después: ".$total." (Esperado: ".$expected_number.")\n");

        if($expected_exception)
            $this->assertNotEquals($expected_number, $total);
        else
            $this->assertEquals($expected_number, $total);

    }

    public function setAllStatusTrueProvider()
    {
        $this->assertTrue(true);

        $this::$capsule = new Capsule();
        $this::$capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'acmeev_db',
            'username'  => 'root',
            'password'  => '1234',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $this::$capsule->bootEloquent();
        $this::$capsule->setAsGlobal();

        echo("===============================================================================================================\n");
        echo("=====================================TEST SET ALL STATUS TRUE==================================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [0, false,
                "Poner todos los Minutes en estado 1."],
            [2,true,
                "Poner todos los Minutes en estado 1 esperando a recibir 2 de estado 0."],

        ];

    }

}