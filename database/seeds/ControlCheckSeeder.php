<?php

use App\ControlCheck;
use Illuminate\Database\Seeder;

class ControlCheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ControlCheck::firstOrCreate(['name'=>1,'floor'=>1,'description'=>'A1','date'=>false,'is_submittable'=>30]);
    }
}