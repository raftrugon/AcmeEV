<?php

namespace Tests\Unit;

use App\Repositories\SubjectInstanceRepo;
use App\Repositories\GroupRepo;
use App\Repositories\SubjectRepo;
use App\Repositories\ConversationRepo;
use App\SubjectInstance;
use App\Subject;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    SubjectInstanceTest
 */
class SubjectInstanceTest extends TestCase{

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
     * @dataProvider isUserTeacherNOFUNCIONALProvider
     */
    public function testIsUserTeacherNOFUNCIONAL($user_id, $subject_instance_id, $expected_exception,
                                               $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("User ID: ".$user_id."\n");
        echo("Subject Instance ID: ".$subject_instance_id."\n");
        echo("-----------------------------------------------------------------\n");

        Auth::loginUsingId($user_id);
        $this->assertTrue(Auth::check());

        $conversationRepo = new ConversationRepo();
        $groupRepo = new GroupRepo($conversationRepo);
        $subjectInstanceRepo = new SubjectInstanceRepo($groupRepo, $conversationRepo);

        $subject_instance = SubjectInstance::find($subject_instance_id);
        $results = $subjectInstanceRepo->isUserTeacherNOFUNCIONAL($subject_instance);

        $booleano = null;
        if($results)
            $booleano = 'true';
        else
            $booleano = 'false';
        echo("Elementos obtenidos: ".$booleano."\n");

        if($expected_exception)
            $this->assertNotTrue($results);
        else
            $this->assertTrue($results);

    }

    public function isUserTeacherNOFUNCIONALProvider()
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
        echo("=====================================TEST IS USER TEACHER NO FUNCIONAL=========================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [13, 3, false,
                "Consultar si Marcia Klein es profesor en la asignatura 3."],
            [15, 4, false,
                "Consultar si Jovan Buckridge es profesor en la asignatura 4."],
            [59, 2, true,
                "Consultar si Camilla Beatty es profesor en la asignatura 2."],

        ];

    }

    /**
     * @dataProvider getCurrentInstanceProvider
     */
    public function testGetCurrentInstance($expected_exception,
                                                 $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("-----------------------------------------------------------------\n");

        $subject1 = new Subject();
        $subject1->setName("Test Subject");
        $subject1->setDepartment(10);
        $subject1->setDegree(1);
        $subject1->save();

        $subject_instance1 = new SubjectInstance();
        $subject_instance1->setAcademicYear(2018);
        $subject = Subject::find($subject1->getId());
        $subject_instance1->setSubject($subject1->getId());
        $subject_instance1->save();

        $conversationRepo = new ConversationRepo();
        $groupRepo = new GroupRepo($conversationRepo);
        $subjectInstanceRepo = new SubjectInstanceRepo($groupRepo, $conversationRepo);

        $results = $subjectInstanceRepo->getCurrentInstance($subject->getId());

        echo($results);

        $this->assertNotNull($results);

    }

    public function getCurrentInstanceProvider()
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
        echo("=====================================TEST GET CURRENT INSTANCE=================================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [false,
                "Obtener el Subject Instance correspondiente a este año de la nueva asignatura."]

        ];

    }

}