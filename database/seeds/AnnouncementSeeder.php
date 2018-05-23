<?php

use App\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $number_of_announcements = 200;

        //////////////////////////////////////////////////////////////

        info('Seeding '.$number_of_announcements.' Announcements on random Subject Instances of this year.');

        factory(App\Announcement::class,$number_of_announcements)->create();
    }
}
