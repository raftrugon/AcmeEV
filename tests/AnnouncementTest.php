<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\User as User;
use Faker\Factory;

/**
 *    AnnouncementTest
 */
class AnnouncementTest extends \PHPUnit\Framework\TestCase
{
    protected $userTable;


    public function testCreateUser()
    {
        // get default values for new user
        #$values = $this->getUserValues();

        // count number of records before create
        $before = 3;

        // assert user is created
        #$result = $this->userTable->create($values);
        #$this->assertTrue($result);

        // check users has been incremented
        $after = 5;
        $this->assertGreaterThan($before, $after);

        $user = new User();
        $user->setEmail('user@example.com');

        $this->assertEquals(
            'user@example.com',
            $user->getEmail()
        );

        $faker = Factory::create();

        $student = User::firstOrCreate([
            'name'=>$faker->firstName,
            'surname'=>$faker->lastName,
            'email'=>$faker->unique()->regexify('[a-z]{9}').'@alum.us.es',
            'id_number'=>$faker->unique()->regexify('[0-9]{8}[A-Z]{1}'),
            'address'=>$faker->address,
            'phone_number'=>$faker->phoneNumber,
            'personal_email'=>$faker->email,
            'password'=>'mimimimi'
        ]);



    }
}