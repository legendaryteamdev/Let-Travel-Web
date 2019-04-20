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
	    DB::table('users_type')->insert(
            [
                [ 'name' =>'Admin'],
                [ 'name' =>'MO'],
                [ 'name' =>'MT'],
                [ 'name' =>'Member'],
            ]);

        DB::table('users_social')->insert(
            [
                [ 'name' =>'MPWT'],
                [ 'name' =>'Facebook'],
                [ 'name' =>'Google']
            ]);

        DB::table('user')->insert(
            [
                [ 'type_id'=>1, 'social_type_id'=>1, 'email'=>'admin@roadcare.mpwt.gov.kh',               'phone' => '011899948', 'password' => bcrypt('123456'), 'is_active'=>1, 'is_email_verified'=>1, 'name' => 'Admin', 'avatar'=>'public/user/profile.png'],
                [ 'type_id'=>2, 'social_type_id'=>1, 'email'=>'mo@roadcare.mpwt.gov.kh',                  'phone' => '021899948', 'password' => bcrypt('123456'), 'is_active'=>1, 'is_email_verified'=>1, 'name' => 'MPWT MO', 'avatar'=>'public/user/profile.png'], //MO
                
            ]);

        DB::table('admin')->insert([[ 'user_id' =>1]]);
        DB::table('mo')->insert([[ 'user_id' =>2, 'name'=>'Head Office']]);
        DB::table('mos_ministries')->insert([[ 'mo_id' =>1, 'ministry_id'=>1]]);

        //Create 27 MT
        for($i = 1; $i <= 27; $i++){
            
            $th = $i; 
            if($i < 10){
                $th = '0'.$i; 
            }

            $userId = DB::table('user')->insertGetId([ 'type_id'=>3, 'social_type_id'=>1, 'email'=>'mt'.$th.'@roadcare.mpwt.gov.kh', 'is_email_verified'=>1, 'phone' => '0118999'.$th, 'password' => bcrypt('123456'), 'is_active'=>1, 'name' => 'MT '.$th, 'avatar'=>'public/user/profile.png']);
            $mtId = DB::table('mt')->insertGetId([ 'user_id' =>$userId, 'name'=>$th, 'province_id'=>$i ]);
            DB::table('mts_mos')->insert(['mt_id'=>$mtId, 'mo_id'=>1]); 

        }

      
	}
}
