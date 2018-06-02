<?php

namespace Tests\Unit;

use App\Degree;
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use Illuminate\Support\Facades\DB as DB;
//use Illuminate\Database\Capsule\Manager as DB;

/**
 *    Announcement2Test
 */
class Announcement2Test extends TestCase{

   /* use TestCaseTrait;

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=acmeev_db', 'root', '1234');


        return $this->createDefaultDBConnection($pdo, 'testdb');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createXMLDataSet(dirname(__FILE__).'/../dbTest/fixtures/data.xml');
    }


    protected $_degree;


    #function setUp() { $this->db->exec("BEGIN"); }
    #function tearDown() { $this->db->exec("ROLLBACK"); }

    function setUp(){
        echo 'Empiezaaa';

        //$pdo = DB::connection()->getPdo();
    }

    function tearDown(){
        echo 'Sacabó';
    }

    public function testProbando(){
        echo 'Vamo a probá';

        $degree = new Degree();
        //$degree::all();
        //$this->_degree->save();
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