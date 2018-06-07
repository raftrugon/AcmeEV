<?php

namespace Tests\Unit;

use App\Message;
use App\Conversation;
use App\Repositories\ConversationRepo;
use App\Repositories\GroupRepo;
use App\Repositories\MessageRepo as MessageRepo;
use Tests\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Auth;

/**
 *    MessageTest
 */
class MessageTest extends TestCase{

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
     * @dataProvider markUnreadAsReadForConversationsProvider
     */
    public function testMarkUnreadAsReadForConversations($user_id, $expected_number, $expected_exception,
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


        $conversationRepo = new conversationRepo();
        $groupRepo = new groupRepo($conversationRepo);
        $messageRepo = new MessageRepo($conversationRepo, $groupRepo);

        $conversation1 = $conversationRepo->getModel();
        $conversation1->setUser1(9);
        $conversation1->setUser2(10);
        $conversation1->getMessages();
        $conversation1->save();

        $conversation1 = Conversation::find($conversation1->getId());



        $conversation2 = $conversationRepo->getModel();
        $conversation2->setUser1(10);
        $conversation2->setUser2(11);
        $conversation2->save();

        $conversation2 = Conversation::find($conversation2->getId());

        $message1 = new Message();
        $message1->setSender(9);
        $message1->setConversation($conversation1->getId());
        $message1->setBody("Hola Miguel.");
        $message1->save();

        $message2 = new Message();
        $message2->setSender(10);
        $message2->setConversation($conversation1->getId());
        $message2->setBody("Hola Ana.");
        $message2->save();

        $message3 = new Message();
        $message3->setSender(9);
        $message3->setConversation($conversation1->getId());
        $message3->setBody("It was a prank bro.");
        $message3->save();

        $message4 = new Message();
        $message4->setSender(10);
        $message4->setConversation($conversation1->getId());
        $message4->setBody("OMG OMG OMG.");
        $message4->save();

        //$conversation1->getMessages()->insert([$message1, $message2, $message3, $message4]);

        $conversations = collect([$conversation1, $conversation2]);

        $messageRepo->markUnreadAsReadForConversations($conversations);

        $results = Message::all();

        $total = 0;

        foreach($results as $r){
            echo($r."\n");
            if($r->getReadBy()!=null)
                $total++;
        }

        echo("Mensajes leídos: ".$total." (Esperados: ".$expected_number.")\n");

        if($expected_exception)
            $this->assertNotEquals($expected_number, $total);
        else
            $this->assertEquals($expected_number, $total);

    }

    public function markUnreadAsReadForConversationsProvider()
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
        echo("=====================================TEST MARK UNREAD AS READ FOR CONVERSATIONS================================\n");
        echo("===============================================================================================================\r");
        print("\n");

        return [
            [9, 2, false,
                "Marcar como leído los mensajes de una conversación."],
            [10, 2, false,
                "Obtener todas las asignaturas matriculadas de Miguel Hernández (de este curso)."],
            [11, 3, true,
                "Obtener todas las asignaturas matriculadas de Miguela Gómez esperando recibir 2 (de este curso)."],

        ];

    }

}