<?php

namespace Tests\Unit;

use App\Degree;
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 *    Announcement2Test
 */
class Announcement2Test extends TestCase{

    static $capsule;

    function setUp(){
        echo "Empieza\n";
        $this::$capsule = new Capsule;
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
        $this::$capsule->connection()->beginTransaction();
    }

    function tearDown(){

        echo "Sacabó\n";
        $this::$capsule->connection()->rollBack();
    }

    public function testProbando(){

        echo "Vamo a probá\n";

        $degree = new Degree();
        $degree->setName("Test Name");
        $degree->save();

        $list_degree = $degree::all();

        foreach ($list_degree as $ld){
            echo($ld);
            echo("\n");
        }


    }

    /*public function testProcessPaymentReturnsTrueOnSuccessfulPayment()
    {

        $pdo = $this->getConnection();

        $result = 1==1;

        $this->assertTrue($result);

        $degree = new Degree();
        #$degree::all();
        #$this->_degree->save();

        $DBH = $degree->getDbh();

        $query = "SELECT * FROM degrees WHERE id=3";
        $stmt = $DBH->prepare($query);
        $stmt->execute();
        $rows = $stmt->rowCount();

        echo 'Método';
    }/*

    /*public function testDeleteRule_legalDeletion()
    {
        $id = 3;
        $pdo = $this->getConnection();
        $fixture = new AdRules();
        $fixture->setDbh($pdo);
        $res = $fixture->deleteRule($id);

        $DBH = $fixture->getDbh();

        $query = "SELECT * FROM rules WHERE id=3";
        $stmt = $DBH->prepare($query);
        $stmt->execute();
        $rows = $stmt->rowCount();

        $this->assertEquals($rows,0);

    }*/
}