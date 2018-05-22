<?php

use App\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room::firstOrCreate(['number'=>1,'floor'=>1,'module'=>'A1','is_laboratory'=>false,'capacity'=>30]);
        Room::firstOrCreate(['number'=>2,'floor'=>2,'module'=>'A1','is_laboratory'=>false,'capacity'=>45]);
        Room::firstOrCreate(['number'=>3,'floor'=>1,'module'=>'A1','is_laboratory'=>true,'capacity'=>20]);
        Room::firstOrCreate(['number'=>4,'floor'=>2,'module'=>'A2','is_laboratory'=>false,'capacity'=>35]);
        Room::firstOrCreate(['number'=>5,'floor'=>1,'module'=>'A2','is_laboratory'=>false,'capacity'=>60]);
        Room::firstOrCreate(['number'=>6,'floor'=>2,'module'=>'A2','is_laboratory'=>true,'capacity'=>10]);
        Room::firstOrCreate(['number'=>7,'floor'=>1,'module'=>'A3','is_laboratory'=>false,'capacity'=>60]);
        Room::firstOrCreate(['number'=>8,'floor'=>2,'module'=>'A3','is_laboratory'=>false,'capacity'=>25]);
        Room::firstOrCreate(['number'=>9,'floor'=>1,'module'=>'A3','is_laboratory'=>true,'capacity'=>35]);
        Room::firstOrCreate(['number'=>10,'floor'=>2,'module'=>'A4','is_laboratory'=>false,'capacity'=>45]);
    }
}
