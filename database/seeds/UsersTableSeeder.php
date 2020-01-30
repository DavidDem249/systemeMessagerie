<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        for($i=240; $i<250; $i++)
        {
        	DB::table('users')->insert([
        		'name' => "David_Dem$i",
        		'email' => "david$i@gmail.com",
        		'password' => bcrypt("0000")
        	]);
        }
    }
}
