<?php

namespace Tests\Unit;

use App\Degree;
use App\Repositories\InscriptionRepo as InscriptionRepo;
use App\Repositories\RequestRepo as RequestRepo;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    InscriptionTest
 */
class InscriptionTest extends TestCase{

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
     * @dataProvider getAcceptedListForDegreeProvider
     */
    public function testGetAcceptedListForDegree($degree_id, $expected_number, $expected_exception,
                                               $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("Degree ID: ".$degree_id."\n");
        echo("Expected Number: ".$expected_number."\n");
        echo("-----------------------------------------------------------------\n");

        $requestRepo = new RequestRepo();
        $inscriptionRepo = new InscriptionRepo($requestRepo);


        $requests = $requestRepo->getModel()->where('degree_id',$degree_id)->get();
        for($i=0;$i<3;$i++){
            $requests[$i]->setAccepted(1);
            $requests[$i]->save();
        }

        $degree = Degree::find($degree_id);
        $results = $inscriptionRepo->getAcceptedListForDegree($degree);

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

    public function getAcceptedListForDegreeProvider()
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
        echo("=====================================TEST GET ACCEPTED LIST FOR DEGREE=========================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [3, 3, false,
                "Obtener las solicitudes de ingreso al grado aceptadas."],
            [4, 2, true,
                "Obtener las solicitudes de ingreso al grado aceptadas esperando recibir dos."],

        ];

    }

    /**
     * @dataProvider inscriptionBatchProvider
     */
    public function testInscriptionBatch($actual_state, $degree_id, $expected_number, $expected_exception,
                                         $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("Actual State: ".$actual_state."\n");
        echo("Expected Number: ".$expected_number."\n");
        echo("-----------------------------------------------------------------\n");

        $requestRepo = new RequestRepo();
        $inscriptionRepo = new InscriptionRepo($requestRepo);

        $inscriptionBatch = $inscriptionRepo->inscriptionBatch($actual_state);

        $degree = Degree::find($degree_id);
        $results = $inscriptionRepo->getAcceptedListForDegree($degree);

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

    public function inscriptionBatchProvider()
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
        echo("=====================================TEST INSCRIPTION BATCH====================================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [0, 1, 25, false,
                "Marcar solicitudes como aceptadas y ver las del Grado 1."],
            [0, 2, 30, true,
                "Marcar solicitudes como aceptadas y ver las del Grado 2 esperando obtener 30."],

        ];

    }

}