<?php

namespace Tests\Unit;

use App\Enrollment;
use App\Repositories\EnrollmentRepo as EnrollmentRepo;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    EnrollmentTest
 */
class EnrollmentTest extends TestCase{

    public $database = "acmev_db"; //Cambiar en función de nuestra base de datos
    public $username = "root"; //Cambiar en función de nuestra base de datos
    public $password = ""; //Cambiar en función de nuestra base de datos

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
     * @dataProvider getMyEnrollmentsProvider
     */
    public function testGetMyEnrollments($user_id, $explanation){

        echo("Explicación: " . $explanation ."\n");
        echo("User ID: ".$user_id."\n");
        echo("-----------------------------------------------------------------\n");

        Auth::loginUsingId($user_id);
        $this->assertTrue(Auth::check());

        $enrollmentRepo = new EnrollmentRepo();

        $results = $enrollmentRepo->getMyEnrollments();

        $total = $results->count();

        foreach($results->get() as $r){
            echo($r."\n");
        }

        echo("Elementos obtenidos: ".$total);

    }

    public function getMyEnrollmentsProvider()
    {
        $this->assertTrue(true);

        $this::$capsule = new Capsule();
        $this::$capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => $this->database,
            'username'  => $this->username,
            'password'  => $this->password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $this::$capsule->bootEloquent();
        $this::$capsule->setAsGlobal();

        echo("===============================================================================================================\n");
        echo("=====================================TEST GET MY ENROLLMENTS===================================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [9, "Obtener todas las asignaturas matriculadas de Ana Morales."],
            [10, "Obtener todas las asignaturas matriculadas de Miguel Hernández."],
            [11, "Obtener todas las asignaturas matriculadas de Miguela Gómez esperando recibir 2."],

        ];

    }

    /**
     * @dataProvider getMyActualEnrollmentsProvider
     */
    public function testGetMyActualEnrollments($user_id, $expected_number, $expected_exception,
                                          $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("User ID: ".$user_id."\n");
        echo("Expected Number: ".$expected_number."\n");
        echo("-----------------------------------------------------------------\n");

        Auth::loginUsingId($user_id);
        $this->assertTrue(Auth::check());

        $enrollmentRepo = new EnrollmentRepo();

        $results = $enrollmentRepo->getMyActualEnrollments();

        $total = $results->count();

        foreach($results->get() as $r){
            echo($r."\n");
        }

        echo("Elementos obtenidos: ".$total." (Esperados: ".$expected_number.")\n");

        if($expected_exception)
            $this->assertNotEquals($expected_number, $total);
        else
            $this->assertEquals($expected_number, $total);

    }

    public function getMyActualEnrollmentsProvider()
    {
        $this->assertTrue(true);

        $this::$capsule = new Capsule();
        $this::$capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => $this->database,
            'username'  => $this->username,
            'password'  => $this->password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $this::$capsule->bootEloquent();
        $this::$capsule->setAsGlobal();

        echo("===============================================================================================================\n");
        echo("=====================================TEST GET MY ACTUAL ENROLLMENTS============================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [9, 0, false,
                "Obtener todas las asignaturas matriculadas de Ana Morales (de este curso)."],
            [10, 0, false,
                "Obtener todas las asignaturas matriculadas de Miguel Hernández (de este curso)."],
            [11, 2, true,
                "Obtener todas las asignaturas matriculadas de Miguela Gómez esperando recibir 2 (de este curso)."],

        ];

    }

}