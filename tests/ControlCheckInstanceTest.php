<?php

namespace Tests\Unit;

use App\ControlCheckInstance;
use App\Repositories\ControlCheckInstanceRepo as ControlCheckInstanceRepo;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    ControlCheckInstanceTest
 */
class ControlCheckInstanceTest extends TestCase{

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
     * @dataProvider getControlCheckInstanceForStudentProvider
     */
    public function testGetControlCheckInstanceForStudent($control_check_id, $id_number, $expected_user_id,
                                                          $expected_exception, $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("Control Check ID: ".$control_check_id."\n");
        echo("Expected User ID: ".$expected_user_id."\n");
        echo("ID Number: ".$id_number."\n");
        echo("-----------------------------------------------------------------\n");

        $controlCheckInstanceRepo = new ControlCheckInstanceRepo();

        //We will create 4 ControlCheckInstance test objects:

        $controlCheckInstance1 = $controlCheckInstanceRepo->getModel();
        $controlCheckInstance1->setStudent(9);
        $controlCheckInstance1->setControlCheck(1);
        $controlCheckInstance1->save();

        $controlCheckInstance2 = $controlCheckInstanceRepo->getModel();
        $controlCheckInstance2->setStudent(9);
        $controlCheckInstance2->setControlCheck(2);
        $controlCheckInstance2->save();

        $controlCheckInstance3 = $controlCheckInstanceRepo->getModel();
        $controlCheckInstance3->setStudent(9);
        $controlCheckInstance3->setControlCheck(3);
        $controlCheckInstance3->save();

        $controlCheckInstance4 = $controlCheckInstanceRepo->getModel();
        $controlCheckInstance4->setStudent(10);
        $controlCheckInstance4->setControlCheck(1);
        $controlCheckInstance4->save();

        $all = ControlCheckInstance::all();
        foreach($all as $a){
            echo($a."\n");
        }

        $results = $controlCheckInstanceRepo->getControlCheckInstanceForStudent($control_check_id, $id_number);

        echo("Elemento obtenido: \n".$results."\n");
        echo("ID de Usuario obtenido: ".$results->student_id.". ID esperado: ".$expected_user_id."\n");

        if($expected_exception)
            $this->assertNotEquals($results->student_id, $expected_user_id);
        else
            $this->assertEquals($results->student_id, $expected_user_id);

    }

    public function getControlCheckInstanceForStudentProvider()
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
        echo("=====================================TEST GET CONTROL CHECK INSTANCE FOR STUDENT===============================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [3, '04093414V', 9, false,
                "Comprobar el próximo examen Laboratory control check de la estudiante Ana Morales."],
            [1, '25687049B', 10, false,
                "Comprobar el próximo examen First Control Check del estudiante Miguel Hernández."],
            [1, '04093414V', 10, true,
                "Comprobar el próximo examen First Control Check de Ana Morales esperando recibir el de
                Miguel Hernández."],

        ];

    }

    /**
     * @dataProvider getUpdateQualificationsProvider
     */
    public function testGetUpdateQualifications($array_ids, $array_qualifications, $expected_number_updates,
                                                $expected_exception, $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("Array IDs: ".implode(",", $array_ids)."\n");
        echo("Array Qualifications: ".implode(",", $array_qualifications)."\n");
        echo("Expected Number of Updates: ".$expected_number_updates."\n");
        echo("-----------------------------------------------------------------\n");

        $controlCheckInstanceRepo = new ControlCheckInstanceRepo();

        //We will create 3 ControlCheckInstance test objects:

        $controlCheckInstance1 = $controlCheckInstanceRepo->getModel();
        $controlCheckInstance1->setStudent(9);
        $controlCheckInstance1->setControlCheck(1);
        $controlCheckInstance1->save();

        $controlCheckInstance2 = $controlCheckInstanceRepo->getModel();
        $controlCheckInstance2->setStudent(9);
        $controlCheckInstance2->setControlCheck(2);
        $controlCheckInstance2->save();

        $controlCheckInstance3 = $controlCheckInstanceRepo->getModel();
        $controlCheckInstance3->setStudent(9);
        $controlCheckInstance3->setControlCheck(3);
        $controlCheckInstance3->save();

        $controlCheckInstance4 = $controlCheckInstanceRepo->getModel();
        $controlCheckInstance4->setStudent(10);
        $controlCheckInstance4->setControlCheck(1);
        $controlCheckInstance4->save();

        echo("Exámenes antes de los cambios:\n");
        $all = ControlCheckInstance::all();
        foreach($all as $a){
            echo($a."\n");
        }

        $array_ids2 = [];

        foreach($array_ids as $index){
            array_push($array_ids2, $all[$index-1]->id);
        }

        $results = $controlCheckInstanceRepo->updateQualifications($array_ids2, $array_qualifications);

        echo("Exámenes después de los cambios:\n");
        $all = ControlCheckInstance::all();
        $count = 0;
        foreach($all as $a){
            echo($a."\n");
            if($a->getQualification()<>null)
                $count++;
        }
        echo("Número de exámenes actualizados: ".$count.". Esperados: ".$expected_number_updates."\n");

        if($expected_exception)
            $this->assertNotEquals($count, $expected_number_updates);
        else
            $this->assertEquals($count, $expected_number_updates);

    }

    public function getUpdateQualificationsProvider()
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
        echo("=====================================TEST UPDATE QUALIFICATIONS================================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [[1,2], [9,7], 2,false,
                "Actualizar las notas de los dos primeros exámenes de Ana Morales."],
            [[1,2,3,4], [9,7,4,6], 4, false,
                "Actualizar las notas de los cuatro exámenes disponibles."],
            [[1,2,3,4], [9,7,4,6], 3, true,
                "Actualizar las notas de los cuatro exámenes disponibles esperando actualizar solo 3."],

        ];
    }
}