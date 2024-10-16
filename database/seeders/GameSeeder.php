<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\spinBetlog;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $time = Carbon::parse($now)->format('Ymd');
        $gamesno = $time.'01'.'0001';

        spinBetlog::insert([
            ['gamesno' => $gamesno,'number' => '0' , 'amount'=> '0', 'status' => '1','created_at'=>$now, 'updated_at'=>$now],
            ['gamesno' => $gamesno,'number' => '1' , 'amount'=> '0', 'status' => '1','created_at'=>$now, 'updated_at'=>$now],
            ['gamesno' => $gamesno,'number' => '2' , 'amount'=> '0', 'status' => '1','created_at'=>$now, 'updated_at'=>$now],
            ['gamesno' => $gamesno,'number' => '3' , 'amount'=> '0', 'status' => '1','created_at'=>$now, 'updated_at'=>$now],
            ['gamesno' => $gamesno,'number' => '4' , 'amount'=> '0', 'status' => '1','created_at'=>$now, 'updated_at'=>$now],
            ['gamesno' => $gamesno,'number' => '5' , 'amount'=> '0', 'status' => '1','created_at'=>$now, 'updated_at'=>$now],
            ['gamesno' => $gamesno,'number' => '6' , 'amount'=> '0', 'status' => '1','created_at'=>$now, 'updated_at'=>$now],
            ['gamesno' => $gamesno,'number' => '7' , 'amount'=> '0', 'status' => '1','created_at'=>$now, 'updated_at'=>$now],
            ['gamesno' => $gamesno,'number' => '8' , 'amount'=> '0', 'status' => '1','created_at'=>$now, 'updated_at'=>$now],
            ['gamesno' => $gamesno,'number' => '9' , 'amount'=> '0', 'status' => '1','created_at'=>$now, 'updated_at'=>$now],
        ]);
    }
}
