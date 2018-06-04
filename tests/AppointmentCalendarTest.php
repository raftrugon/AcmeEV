<?php

namespace Tests\Unit;

use App\AppointmentCalendar;
use App\User;
use App\Repositories\AppointmentCalendarRepo as AppointmentCalendarRepo;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    AppointmentCalendarTest
 */
class AppointmentCalendarTest extends TestCase{

    public static $capsule;

    function setUp(){
        parent::setUp();
        echo("EMPIEZA\n");
        $this::$capsule->connection()->beginTransaction();
        parent::getConnection()->beginTransaction();
    }

    function tearDown(){
        echo("ACABAH\n");
        $this::$capsule->connection()->rollBack();
        parent::getConnection()->rollBack();
        parent::tearDown();

    }

    /**
     * @dataProvider getAvailableDatesForRangeProvider
     */
    public function testGetAvailableDatesForRange($user_id, $start_time, $end_time, $expected_number, $expected_exception, $explanation){


        if(!$expected_exception)
            echo("---------------------------- POSITIVO ---------------------------\n");
        else
            echo("---------------------------- NEGATIVO ---------------------------\n");

        $startTime = strtotime( $start_time);
        $startDate = date('Y-m-d H-i-s',$startTime);
        $endTime = strtotime( $end_time);
        $endDate = date('Y-m-d H-i-s',$endTime);

        echo("Explicación: " . $explanation ."\n");
        echo("User ID: ".$user_id."\n");
        echo("Start Date: ".$startDate."\n");
        //print date('Y-m-d H-i-s', $startDate );
        echo("End Date: ".$endDate."\n");
        //print date('Y-m-d H-i-s', $endDate );
        echo("Expected number: ".$expected_number."\n");
        echo("-----------------------------------------------------------------\n");

        Auth::loginUsingId($user_id);

        $this->assertTrue(Auth::check());

        $appointmentCalendarRepo = new AppointmentCalendarRepo();

        //We will create 3 AppointmentCalendar test objects:

        $startTime1 = strtotime( "June 05, 2018 10:00:00");
        $startDate1 = date('Y-m-d H-i-s',$startTime1);
        $endTime1 = strtotime( "June 05, 2018 11:00:00");
        $endDate1 = date('Y-m-d H-i-s',$endTime1);

        $appointmentCalendar1 = $appointmentCalendarRepo->getModel();
        $appointmentCalendar1->setStart($startDate1);
        $appointmentCalendar1->setEnd($endDate1);
        $appointmentCalendar1->setPas($user_id);

        $appointmentCalendar1->save();

        $startTime2 = strtotime( "June 05, 2018 11:00:00");
        $startDate2 = date('Y-m-d H-i-s',$startTime2);
        $endTime2 = strtotime( "June 05, 2018 12:00:00");
        $endDate2 = date('Y-m-d H-i-s',$endTime2);

        $appointmentCalendar2 = $appointmentCalendarRepo->getModel();
        $appointmentCalendar2->setStart($startDate2);
        $appointmentCalendar2->setEnd($endDate2);
        $appointmentCalendar2->setPas($user_id);

        $appointmentCalendar2->save();

        $startTime3 = strtotime( "June 06, 2018 09:00:00");
        $startDate3 = date('Y-m-d H-i-s',$startTime3);
        $endTime3 = strtotime( "June 06, 2018 09:30:00");
        $endDate3 = date('Y-m-d H-i-s',$endTime3);

        $appointmentCalendar3 = $appointmentCalendarRepo->getModel();
        $appointmentCalendar3->setStart($startDate3);
        $appointmentCalendar3->setEnd($endDate3);
        $appointmentCalendar3->setPas($user_id);

        $appointmentCalendar3->save();

        $results = $appointmentCalendarRepo->getAvailableDatesForRange($startDate, $endDate)->get();
        $total = $results->count();

        echo("Elementos obtenidos: ".$total." (Esperados: ".$expected_number.")\n");

        $this->assertEquals($expected_number, $total);

        foreach($results as $r){
            echo($r."\n");
        }

    }

    public function getAvailableDatesForRangeProvider()
    {
        echo("PROVDASOHLOCOH\n");

        $this->assertTrue(true);

        AppointmentCalendarTest::$capsule = new Capsule();
        AppointmentCalendarTest::$capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'acmeev_db',
            'username'  => 'root',
            'password'  => '1234',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        AppointmentCalendarTest::$capsule->bootEloquent();
        AppointmentCalendarTest::$capsule->setAsGlobal();

        echo("===============================================================================================================\n");
        echo("=====================================TEST GET AVAILABLE DATES FOR RANGE========================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [3, "June 03, 2018 10:00:00", "June 07, 2018 10:15:00", 3, false,
                "Obtener los horarios libres de un PAS (1)."],
            [3, "June 22, 2018 10:00:00", "June 23, 2018 10:00:00", 0, false,
               "Obtener los horarios libres de un PAS (2)."]
        ];
    }
}