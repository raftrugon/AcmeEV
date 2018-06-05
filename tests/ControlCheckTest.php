<?php

namespace Tests\Unit;

use App\ControlCheck;
use App\ControlCheckInstance;
use App\Subject;
use App\User;
use App\Repositories\ControlCheckRepo as ControlCheckRepo;
use App\Repositories\ControlCheckInstanceRepo as ControlCheckInstanceRepo;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    ControlCheckTest
 */
class ControlCheckTest extends TestCase{

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
     * @dataProvider getControlCheckInstancesForStudentProvider
     */
    public function testGetControlCheckInstancesForStudent($user_auth, $user_id, $subject_id,
                                                           $expected_number, $expected_exception,
                                                           $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("User Auth: ".$user_auth."\n");
        echo("User ID: ".$user_id."\n");
        echo("Subject ID: ".$subject_id."\n");
        echo("Expected Number: ".$expected_number."\n");
        echo("-----------------------------------------------------------------\n");

        if($user_auth==null)
            Auth::loginUsingId($user_id); //This will be used to avoid exceptions.
        else
            Auth::loginUsingId($user_auth);

        $this->assertTrue(Auth::check());

        $controlCheckInstanceRepo = new ControlCheckInstanceRepo();
        $controlCheckRepo = new ControlCheckRepo($controlCheckInstanceRepo);

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
        $controlCheckInstance3->setControlCheck(4);
        $controlCheckInstance3->save();

        $controlCheckInstance4 = $controlCheckInstanceRepo->getModel();
        $controlCheckInstance4->setStudent(10);
        $controlCheckInstance4->setControlCheck(1);
        $controlCheckInstance4->save();

        $all = ControlCheckInstance::all();
        foreach($all as $a){
            echo($a."\n");
        }


        $subject = Subject::find($subject_id);
        $user = User::find($user_id);

        if($user_auth=null)
            $results = $controlCheckRepo->getControlCheckInstancesForStudent($subject, $user);
        else
            $results = $controlCheckRepo->getControlCheckInstancesForStudent($subject);

        $total = $results->count();

        echo("Elementos obtenidos: ".$total." (Esperados: ".$expected_number.")\n");

        foreach($results->get() as $r){
            echo($r."\n");
        }

        if($expected_exception)
            $this->assertNotEquals($expected_number, $total);
        else
            $this->assertEquals($expected_number, $total);



    }

    public function getControlCheckInstancesForStudentProvider()
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
        echo("=====================================TEST GET CONTROL CHECK INSTANCES FOR STUDENT==============================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [null, 9, 1, 2, false,
                "Obtener todos los exámenes de la asignatura Investigación de Materiales  
                pertenecientes a Ana Morales."],
            [9, 9, 2, 1, false,
                "Obtener todos los exámenes de la asignatura Investigación experimental de Aviones Nivel Básico 
                pertenecientes a Ana Morales (login)."],
            [10, 10, 1, 3, true,
                "Obtener todos los exámenes de la asignatura Investigación de Materiales  
                pertenecientes a Miguel Hernández."],

        ];

    }

    /**
     * @dataProvider getControlChecksForLecturerProvider
     */
    public function testGetControlChecksForLecturer($subject_id, $expected_number, $expected_exception,
                                                           $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("Subject ID: ".$subject_id."\n");
        echo("Expected Number: ".$expected_number."\n");
        echo("-----------------------------------------------------------------\n");

        $controlCheckInstanceRepo = new ControlCheckInstanceRepo();
        $controlCheckRepo = new ControlCheckRepo($controlCheckInstanceRepo);

        $subject = Subject::find($subject_id);

        $results = $controlCheckRepo->getControlChecksForLecturer($subject);

        $total = $results->count();

        echo("Elementos obtenidos: ".$total." (Esperados: ".$expected_number.")\n");

        foreach($results->get() as $r){
            echo($r."\n");
        }

        if($expected_exception)
            $this->assertNotEquals($expected_number, $total);
        else
            $this->assertEquals($expected_number, $total);



    }

    public function getControlChecksForLecturerProvider()
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
        echo("=====================================TEST GET CONTROL CHECKS FOR LECTURER======================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [1, 3, false,
                "Obtener todos los exámenes de la asignatura Investigación de Materiales."],
            [2, 2, false,
                "Obtener todos los exámenes de la asignatura Investigación experimental de Aviones Nivel Básico."],
            [1, 2, true,
                "Obtener todos los exámenes de la asignatura Investigación de Materiales, esperando obtener
                dos en lugar de tres."],

        ];

    }

    /**
     * @dataProvider deleteControlCheckProvider
     */
    public function testDeleteControlCheck($control_check_id, $expected_exception,
                                                    $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("Control Check ID: ".$control_check_id."\n");
        echo("-----------------------------------------------------------------\n");

        $controlCheckInstanceRepo = new ControlCheckInstanceRepo();
        $controlCheckRepo = new ControlCheckRepo($controlCheckInstanceRepo);

        $all = ControlCheck::all();
        $before_count = $all->count();
        echo("Exámenes antes del Delete (total:".$before_count."):\n");
        foreach($all as $a){
            echo($a."\n");
        }

        $results = $controlCheckRepo->deleteControlCheck($control_check_id);

        $all = ControlCheck::all();
        $after_count = $all->count();
        echo("Exámenes después del Delete (total:".$after_count."):\n");

        /*if($expected_exception==null)
            $this->assertTrue($results=='true');
        else
            $this->assertNotTrue($results=='false');*/

        if($expected_exception==null)
            $this->assertEquals($before_count,$after_count+1);
        else
            $this->assertNotEquals($before_count,$after_count);

    }

    public function deleteControlCheckProvider()
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
        echo("=====================================TEST DELETE CONTROL CHECK=================================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [1, false, "Eliminar con éxito First control check."],
            [2, false, "Eliminar con éxito Second control check."],
            [5, true, "Utilizar un índice no válido para eliminar el Control Check."],

        ];

    }

}