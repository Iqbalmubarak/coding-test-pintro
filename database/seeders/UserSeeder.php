<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        function generateRandomString($length) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        DB::table('users')->insert([
            [
                'name'		 => 'Admin',
                'username' 		     => 'admin',
                'password' 		 => bcrypt('secret')
            ]
        ]);

        $id = DB::getPdo()->lastInsertId();

        DB::table('activations')->insert([
            [
                'user_id' 		=> $id,
                'code' 			  => generateRandomString(40),
                'completed' 	=> '1',
            ]
        ]);

        DB::table('role_users')->insert([
            [
                'user_id' 		=> $id,
                'role_id' 			  => '1'
            ]
        ]);

        DB::table('users')->insert([
            [
                'name'		 => 'Employee',
                'username' 		     => 'employee',
                'password' 		 => bcrypt('secret')
            ]
        ]);

        $id = DB::getPdo()->lastInsertId();

        DB::table('activations')->insert([
            [
                'user_id' 		=> $id,
                'code' 			  => generateRandomString(40),
                'completed' 	=> '1',
            ]
        ]);

        DB::table('role_users')->insert([
            [
                'user_id' 		=> $id,
                'role_id' 			  => '2'
            ]
        ]);
    }
}
