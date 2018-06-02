<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Degree;

class RandomTest extends TestCase
{
    static $capsule;

    function setUp()
    {
        echo "Empieza\n";
        $this::$capsule = new Capsule;
        $this::$capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'acmeev_db',
            'username' => 'root',
            'password' => '1234',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $this::$capsule->bootEloquent();
        $this::$capsule->setAsGlobal();
        $this::$capsule->connection()->beginTransaction();
    }

    function tearDown(){

        echo "Sacabó\n";
        $this::$capsule->connection()->rollBack();
    }

    /**
     * @dataProvider provider
     */
    public function testProbando($uno, $dos, $tres){

        echo "Vamo a probá\n";

        $degree = new Degree();
        $degree->setName("Test Name");
        $degree->save();

        $list_degree = $degree::all();

        foreach ($list_degree as $ld){
            echo($ld);
            echo("\n");
        }

        $primerito = $list_degree->first();
        echo($primerito);

        $this->assertTrue($uno == $dos);


    }

    /*public static function setUpBeforeClass(){
        Announcement2Test::$capsule = new Capsule();
        Announcement2Test::$capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'acmeev_db',
            'username'  => 'root',
            'password'  => '1234',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        Announcement2Test::$capsule->bootEloquent();
        Announcement2Test::$capsule->setAsGlobal();

    }*/

    public function provider()
    {
        return [
            [0, 0, 1],
            [1, 1, 1],
            [3, 3, 1],
            [3, 3, 3]
        ];
    }



}
