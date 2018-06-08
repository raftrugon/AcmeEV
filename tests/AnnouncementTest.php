<?php

namespace Tests\Unit;

use App\Announcement;
use App\SubjectInstance;
use App\Repositories\AnnouncementRepo as AnnouncementRepo ;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 *    AnnouncementTest
 */
class AnnouncementTest extends TestCase{

    public $database = "acmev_db"; //Cambiar en función de nuestra base de datos
    public $username = "root"; //Cambiar en función de nuestra base de datos
    public $password = ""; //Cambiar en función de nuestra base de datos

    public static $capsule;

    function getSubjectInstanceId($subjectId, $year){
        $res = SubjectInstance::where('subject_id', $subjectId)->where('academic_year', $year)->get()->first()->getId();
        return $res;
    }

    function setUp(){
        $this::$capsule->connection()->beginTransaction();
    }

    function tearDown(){

        $this::$capsule->connection()->rollBack();
    }

    /**
     * @dataProvider getAnnouncementsBySubjectInstanceIdProvider
     */
    public function testGetAnnouncementsBySubjectInstanceId($subject_instance_id, $expected_exception, $explanation){

        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        echo("Explicación: " . $explanation ."\n");
        echo("subject_instance_id: ".$subject_instance_id."\n");
        echo("-----------------------------------------------------------------\n");

        $announcements = AnnouncementRepo::getAnnouncementsBySubjectInstanceId($subject_instance_id)->get();

        echo("(ANTES) Elementos obtenidos:\n");

        foreach ($announcements as $ld){
            echo($ld."\n");
        }
        $count_before = $announcements->count();
        echo("Total: ".$count_before."\n");

        $new_announcement =  AnnouncementRepo::getModel();
        $new_announcement->setTitle("Announcement Test");
        if($expected_exception)
            $new_announcement->setSubjectInstance($subject_instance_id+1);
        else
            $new_announcement->setSubjectInstance($subject_instance_id);
        $new_announcement->save();

        $announcements2 = AnnouncementRepo::getAnnouncementsBySubjectInstanceId($subject_instance_id)->get();

        echo("(DESPUÉS) Elementos obtenidos:\n");

        foreach ($announcements2 as $ld){
            echo($ld."\n");
        }
        $count_after = $announcements2->count();
        echo("Total: ".$count_after."\n");

        if($expected_exception)
            $this->assertNotEquals($count_before+1, $count_after);
        else
            $this->assertEquals($count_before+1, $count_after);

    }

    public function getAnnouncementsBySubjectInstanceIdProvider()
    {
        AnnouncementTest::$capsule = new Capsule();
        AnnouncementTest::$capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => $this->database,
            'username'  => $this->username,
            'password'  => $this->password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        AnnouncementTest::$capsule->bootEloquent();
        AnnouncementTest::$capsule->setAsGlobal();

        echo("===============================================================================================================\n");
        echo("=====================================TEST GET ANNOUNCEMENT BY SUBJECT_INSTANCE_ID==============================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [$this->getSubjectInstanceId(1, 2017), false,
                "Obtener anuncios pertenecientes a una misma asignatura."],
            [$this->getSubjectInstanceId(2, 2017), true,
                "Guardar un nuevo anuncio no perteneciente a la misma asignatura."],
        ];
    }
}