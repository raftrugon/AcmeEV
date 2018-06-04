<?php

use App\Inscription;
use App\Request;
use Illuminate\Database\Seeder;

class InscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        Request::where('id','<>',0)->delete();
        Inscription::where('id','<>',0)->delete();

        $faker = Faker\Factory::create();

        factory(App\Inscription::class,310)
            ->create()
            ->each(function($inscription) use($faker) {
                for ($i = 1; $i <= $faker->numberBetween(1,5); $i++){
                    factory(App\Request::class)->create([
                        'inscription_id' => $inscription->id,
                        'priority' => $i,
                    ]);
                }
            });
    }




}
