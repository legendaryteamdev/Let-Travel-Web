<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
	     DB::table('users')->insert(
                [
                ['name' => "System",'email' => 'system@mpwt.com', 'phone' => '012345675', 'position_id' => 1, 'status'=>1, 'visible'=>0, 'password' => bcrypt('xxxxxx')],
                ['name' => "Admin",'email' => 'admin@mpwt.com', 'phone' => '012345678', 'position_id' => 1, 'status'=>1, 'visible'=>1, 'password' => bcrypt('123456')],
                ['name' => "User",'email' => 'user@mpwt.com', 'phone' => '0123456784', 'position_id' => 2,  'status'=>1, 'visible'=>1, 'password' => bcrypt('123456')],
            ]);
        DB::table('positions')->insert(
            [
                [ 
                    'name' => 'Admin',
                    'description' => 'Full Access'
                    

                ],
                [ 
                    'name' => 'User',
                    'description' => 'Full Access but Can not Delete'
                ],
                            
            ]);
	}
}
