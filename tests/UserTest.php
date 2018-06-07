<?php

namespace Tests\Unit;

use App\User;
use App\Repositories\UserRepo as UserRepo;
use App\Repositories\SubjectRepo as SubjectRepo;
use App\Repositories\EnrollmentRepo as EnrollmentRepo;
use App\Repositories\InscriptionRepo as InscriptionRepo;
use App\Repositories\RequestRepo as RequestRepo;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    UserTest
 */
class UserTest extends TestCase{

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
     * @dataProvider isUserFinishedProvider
     */
    public function testIsUserFinished($user_id, $expected_result, $expected_exception,
                                       $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("User ID: ".$user_id."\n");
        $booleano = 'false';
        if($expected_result)
            $booleano = 'true';
        echo("Expected Result: ".$booleano."\n");
        echo("-----------------------------------------------------------------\n");

        Auth::loginUsingId($user_id);
        $this->assertTrue(Auth::check());

        $subjectRepo = new SubjectRepo();
        $enrollmentRepo = new EnrollmentRepo();
        $requestRepo = new RequestRepo();
        $inscriptionRepo = new InscriptionRepo($requestRepo);
        $userRepo = new UserRepo($subjectRepo, $enrollmentRepo, $inscriptionRepo, $requestRepo);

        $results = $userRepo->isUserFinished();

        $booleano = 'false';
        if($results)
            $booleano = 'true';

        $booleano2 = 'false';
        if($expected_result)
            $booleano2 = 'true';

        echo("¿Ha finalizado?: ".$booleano." (Esperado: ".$booleano2.")\n");

        if($expected_exception)
            $this->assertNotEquals($booleano, $expected_result);
        else
            $this->assertEquals($booleano, $booleano2);

    }

    public function isUserFinishedProvider()
    {
        $this->assertTrue(true);

        $this::$capsule = new Capsule();
        $this::$capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'acmeev_db',
            'username' => 'root',
            'password' => '1234',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $this::$capsule->bootEloquent();
        $this::$capsule->setAsGlobal();

        echo("===============================================================================================================\n");
        echo("=====================================TEST IS USER FINISHED===================================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [9, false, false,
                "Comprobar si Ana Morales ha finalizado el grado."],
            [10, false, false,
                "Comprobar si Miguel Hernández ha finalizado el grado"],
            [11, true, true,
                "Comprobar si Miguela Gómez ha finalizado el grado suponiendo que le faltan 2."],

        ];
    }

    /**
     * @dataProvider isUserEnrolledThisYearProvider
     */
    public function testIsUserEnrolledThisYear($user_id, $expected_result, $expected_exception,
                                       $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("User ID: ".$user_id."\n");
        $booleano = 'false';
        if($expected_result)
            $booleano = 'true';
        echo("Expected Result: ".$booleano."\n");
        echo("-----------------------------------------------------------------\n");

        Auth::loginUsingId($user_id);
        $this->assertTrue(Auth::check());

        $subjectRepo = new SubjectRepo();
        $enrollmentRepo = new EnrollmentRepo();
        $requestRepo = new RequestRepo();
        $inscriptionRepo = new InscriptionRepo($requestRepo);
        $userRepo = new UserRepo($subjectRepo, $enrollmentRepo, $inscriptionRepo, $requestRepo);

        $results = $userRepo->isUserEnrolledThisYear();

        $booleano = 'false';
        if($results)
            $booleano = 'true';

        $booleano2 = 'false';
        if($expected_result)
            $booleano2 = 'true';

        echo("¿Ha finalizado?: ".$booleano." (Esperado: ".$booleano2.")\n");

        if($expected_exception)
            $this->assertNotEquals($booleano, $expected_result);
        else
            $this->assertEquals($booleano, $booleano2);

    }

    public function isUserEnrolledThisYearProvider()
    {
        $this->assertTrue(true);

        $this::$capsule = new Capsule();
        $this::$capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'acmeev_db',
            'username' => 'root',
            'password' => '1234',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $this::$capsule->bootEloquent();
        $this::$capsule->setAsGlobal();

        echo("===============================================================================================================\n");
        echo("=====================================TEST IS USER ENROLLED THIS YEAR===========================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [9, false, false,
                "Comprobar si Ana Morales tiene matrícula este año."],
            [10, false, false,
                "Comprobar si Miguel Hernández tiene matrícula este año."],
            [11, true, true,
                "Comprobar si Miguela Gómez tiene matrícula este año."],

        ];
    }

}