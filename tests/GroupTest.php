<?php

namespace Tests\Unit;

use App\Group;
use App\Enrollment;
use App\SubjectInstance;
use App\Repositories\ConversationRepo as ConversationRepo;
use App\Repositories\GroupRepo as GroupRepo;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    GroupTest
 */
class GroupTest extends TestCase{

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
     * @dataProvider subjectInstancesBatchProvider
     */
    public function testSubjectInstancesBatch($expected_number, $expected_exception, $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("Expected Number: ".$expected_number."\n");
        echo("-----------------------------------------------------------------\n");

        $subject1 = new SubjectInstance();
        $subject1->setAcademicYear(2018);
        $subject1->setSubject(1);
        $subject1->save();

        $subject2 = new SubjectInstance();
        $subject2->setAcademicYear(2018);
        $subject2->setSubject(2);
        $subject2->save();

        $subject3 = new SubjectInstance();
        $subject3->setAcademicYear(2018);
        $subject3->setSubject(3);
        $subject3->save();

        $enrollment1 = new Enrollment();
        $enrollment1->setUserId(9);
        $enrollment1->setSubjectInstance($subject1->getId());
        $enrollment1->save();

        $enrollment2 = new Enrollment();
        $enrollment2->setUserId(9);
        $enrollment2->setSubjectInstance($subject2->getId());
        $enrollment2->save();

        $enrollment3 = new Enrollment();
        $enrollment3->setUserId(9);
        $enrollment3->setSubjectInstance($subject3->getId());
        $enrollment3->save();

        $conversationRepo = new ConversationRepo();
        $groupRepo = new GroupRepo($conversationRepo);

        $groupRepo->subjectInstancesBatch();

        $results = $groupRepo->getModel()->join('subject_instances', 'groups.subject_instance_id', '=', 'subject_instances.id')
        ->where('academic_year',2018);

        $total = $results->count();

        echo("RESULTADOS: \n");

        foreach($results->get() as $r){
            echo($r."\n");
        }

        echo("Elementos obtenidos: ".$total." (Esperados: ".$expected_number.")\n");

        if($expected_exception)
            $this->assertNotEquals($expected_number, $total);
        else
            $this->assertEquals($expected_number, $total);

    }

    public function subjectInstancesBatchProvider()
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
        echo("=====================================TEST SUBJECT INSTANCES BATCH PROVIDER======================================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [3, false,
                "Obtener los nuevos grupos generados de este curso."],
            [1, true,
                "Obtener los nuevos grupos esperando recibir un solo grupo."],

        ];

    }

}