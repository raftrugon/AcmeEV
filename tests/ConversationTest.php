<?php

namespace Tests\Unit;

use App\SubjectInstance;
use App\Conversation;
use App\Group;
use App\Repositories\ConversationRepo as ConversationRepo;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    ConversationTest
 */
class ConversationTest extends TestCase{

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
     * @dataProvider getMyGroupsForThisYearProvider
     */
    public function testGetMyGroupsForThisYear($user_id, $expected_number, $expected_exception,
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

        /*$subject_instance1 = new SubjectInstance();
        $subject_instance1->setAcademicYear(2018);
        $subject_instance1->setSubject(1);
        $subject_instance1->save();
        $subject_instance2 = new SubjectInstance();
        $subject_instance2->setAcademicYear(2018);
        $subject_instance2->setSubject(2);
        $subject_instance2->save();
        $subject_instance3 = new SubjectInstance();
        $subject_instance3->setAcademicYear(2018);
        $subject_instance3->setSubject(3);
        $subject_instance3->save();*/

        $conversationRepo = new ConversationRepo();

        $results = $conversationRepo->getMyGroupsForThisYear();

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

    public function getMyGroupsForThisYearProvider()
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
        echo("=====================================TEST GET MY GROUP FOR THIS YEAR===========================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [9, 0, false,
                "Obtener el número total de grupos distintos de la estudiante Ana Morales."],
            [10, 0, false,
                "Obtener el número total de grupos distintos del estudiante Miguel Hernández."],
            [11, 1, true,
                "Obtener el número total de grupos distintos de la estudiante Miguela Gómez esperando
                un total de tres grupos distintos."],

        ];

    }

}