<?php

namespace Tests\Unit;

use App\Degree;
use App\Repositories\DegreeRepo as DegreeRepo;
use App\Repositories\InscriptionRepo as InscriptionRepo;
use App\Repositories\RequestRepo as RequestRepo;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    DegreeTest
 */
class DegreeTest extends TestCase{

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
     * @dataProvider getAllButSelectedProvider
     */
    public function testGetAllButSelected($array_degrees, $expected_number, $expected_exception,
                                          $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("Array Degrees: ".implode(",", $array_degrees)."\n");
        echo("Expected Number: ".$expected_number."\n");
        echo("-----------------------------------------------------------------\n");

        $requestRepo = new RequestRepo();
        $inscriptionRepo = new InscriptionRepo($requestRepo);
        $degreeRepo = new DegreeRepo($inscriptionRepo);

        $results = $degreeRepo->getAllButSelected($array_degrees);

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

    public function getAllButSelectedProvider()
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
        echo("=====================================TEST GET ALL BUT SELECTED=================================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [[1,2], 4, false,
                "Obtener todos los graduados que no sean los dos primeros"],
            [[1,2,3,4], 2, false,
                "Obtener todos los graduados que no sean los cuatro primeros"],
            [[5,6, 4], 4, true,
                "Obtener todos los graduados que no sean los tres últimos"],

        ];

    }

    /**
     * @dataProvider canCreateSubjectInstancesProvider
     */
    public function testCanCreateSubjectInstances($degree_id, $expected_number, $expected_exception,
                                                  $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        if($expected_number)
            $expected_number = 'true';
        else
            $expected_number = 'false';

        echo("Explicación: " . $explanation ."\n");
        echo("Degree ID: ". $degree_id ."\n");
        echo("Resultado Esperado: ".$expected_number."\n");
        echo("-----------------------------------------------------------------\n");

        $requestRepo = new RequestRepo();
        $inscriptionRepo = new InscriptionRepo($requestRepo);
        $degreeRepo = new DegreeRepo($inscriptionRepo);

        $degree = Degree::find($degree_id);

        $results = $degreeRepo->canCreateSubjectInstances($degree);

        if($results)
            $results = 'true';
        else
            $results = 'false';

        echo("Resultado obtenido: ".$results." (Esperados: ".$expected_number.")\n");

        if($expected_exception)
            $this->assertNotEquals($expected_number, $results);
        else
            $this->assertEquals($expected_number, $results);

    }

    public function canCreateSubjectInstancesProvider()
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
        echo("=====================================TEST CAN CREATE SUBJECT INSTANCES=========================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [1, true, false,
                "Comprobar si Grado en Ingeniería Informática - Ingeniería del Software puede instanciar
                asignaturas."],
            [3, true, false,
                "Comprobar si Grado en Ingeniería Industrial puede instanciar
                asignaturas."],
            [2, false, true,
                "Comprobar si Grado en Grado en Ingeniería Informática - Ingeniería de Computadores
                 puede instanciar asignaturas."],

        ];

    }



}