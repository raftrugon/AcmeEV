<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Capsule\Manager as Capsule;

class ExampleTest extends TestCase
{
    public static $capsule;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        echo("holis\n");
        if(Auth::check())
            echo("Logado");
        else
            echo("No logado");
        $this->assertTrue(true);
    }

    function setUp(){
        parent::setUp();
        echo("EMPIEZA1");
    }

    function tearDown(){
        echo("EMPIEZA2");
        parent::tearDown();
    }
}
