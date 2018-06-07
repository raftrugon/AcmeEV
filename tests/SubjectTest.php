<?php

namespace Tests\Unit;

use App\Repositories\SubjectInstanceRepo;
use App\Repositories\GroupRepo;
use App\Repositories\SubjectRepo;
use App\Repositories\ConversationRepo;
use App\SubjectInstance;
use App\Subject;
use App\Group;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    SubjectTest
 */
class SubjectTest extends TestCase{

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
     * @dataProvider getSubjectsForTeacherProvider
     */
    public function testGetSubjectsForTeacher($user_id, $expected_number, $expected_exception,
                                               $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("User ID: ".$user_id."\n");
        echo("-----------------------------------------------------------------\n");

        $conversationRepo = new ConversationRepo();
        $groupRepo = new GroupRepo($conversationRepo);
        $subjectInstanceRepo = new SubjectInstanceRepo($groupRepo, $conversationRepo);
        $subjectRepo = new SubjectRepo($subjectInstanceRepo);

        $subject1 = new Subject();
        $subject1->setName("Test Subject");
        $subject1->setDepartment(10);
        $subject1->setDegree(1);
        $subject1->save();

        $subject_instance1 = new SubjectInstance();
        $subject_instance1->setAcademicYear(2018);
        $subject_instance1->setSubject($subject1->getId());
        $subject_instance1->save();

        $group1 = new Group();
        $group1->setSubjectInstance($subject_instance1->getId());
        $group1->setNumber(1);
        if(!$expected_exception)
            $group1->setTheoryLecturer($user_id);
        $group1->save();

        Auth::loginUsingId($user_id);
        $this->assertTrue(Auth::check());

        $results = $subjectRepo->getSubjectsForTeacher();

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

    public function getSubjectsForTeacherProvider()
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
        echo("=====================================TEST GET SUBJECTS FOR TEACHER=============================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [55, 1, false,
                "Obtener todas las asignaturas que imparte el usuario 55 este año."],
            [58, 1, false,
                "Obtener todas las asignaturas que imparte el usuario 58 este año."],
            [59, 2, true,
                "Obtener todas las asignaturas que imparte el usuario 59 este año."],

        ];

    }

}