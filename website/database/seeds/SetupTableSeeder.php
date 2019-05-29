<?php

use Illuminate\Database\Seeder;

class SetupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
	    
        DB::table('setting')->insert(
            [
                [ 'setting' => 'SCORE_RANGE', 'value' =>100],
                [ 'setting' => 'RADIUS_FOR_POTHOLE', 'value' =>10], 
                [ 'setting' => 'RADIUS_FOR_ROAD', 'value' =>10], 
               
            ]);

        DB::table('ministry')->insert(
            [
                [ 'name' => 'Ministry of Public Works and Transport', 'abbre'=>'MPWT'],
                // [ 'name' => 'MRD', 'abbre'=>'MRD'],
                // [ 'name' => 'RCA', 'abbre'=>'RCA'], 
                // [ 'name' => 'MOI', 'abbre'=>'MOI']
            ]);

        DB::table('status')->insert(
            [
                [ 'name' => 'Pending'],
                [ 'name' => 'Repairing'],
                [ 'name' => 'Declined'], 
                [ 'name' => 'Fixed'], 
                [ 'name' => 'Consulting']
            ]);
       
        DB::table('roads_type')->insert(
            [
                [ 'name' => 'Paved Road'],
                [ 'name' => 'Footpath'],
                [ 'name' => 'Laterite Road'],
                [ 'name' => 'Road'],
                [ 'name' => 'Carttrack'], 
                [ 'name' => 'Street']
            ]);
        //=========================================>> Maintence
        DB::table('maintences_group')->insert(
            [
                [ 'kh_name' => 'ថែទាំផ្លូវថ្នល់ជាប្រចាំ', 'en_name'=>'Routine Maintenance']
            ]);

        DB::table('maintences_type')->insert(
            [
                [ 'kh_name' => 'កំរាលផ្លូវ', 'en_name'=>'Body'], 
                [ 'kh_name' => 'សង្ខាងផ្លូវ', 'en_name'=>'Road Side'],
                [ 'kh_name' => 'សំណង់សិល្បការ្យ', 'en_name'=>'Road Structure'],
                [ 'kh_name' => 'បរិក្ខាផ្លូវថ្នល់', 'en_name'=>'Road Forniture'],
            ]);

        DB::table('maintences_subtype')->insert(
            [
                [ 'kh_name' => 'កំរាលផ្លូវក្រាលកៅស៊ូ', 'en_name'=>'Paved Road'], 
                [ 'kh_name' => 'កំរាលផ្លូវក្រាលដីក្រួសក្រហម', 'en_name'=>'Unpaved Road'],
                [ 'kh_name' => 'ចិញ្ចើមផ្លូវក្រាលកៅស៊ូ', 'en_name'=>'Hard Soulder'],
                [ 'kh_name' => 'សង្ខាងផ្លូវ', 'en_name'=>'Road Side'],
                [ 'kh_name' => 'បរិក្ខាផ្លូវថ្នល់', 'en_name'=>'Road Forniture'],

            ]);

        DB::table('maintences_unit')->insert(
            [
                [ 'kh_name' => 'ម២', 'en_name'=>'m2'], 
                [ 'kh_name' => 'ម៣', 'en_name'=>'m3'],
                [ 'kh_name' => 'គម', 'en_name'=>'km'],
                [ 'kh_name' => 'ម', 'en_name'=>'m'],
                [ 'kh_name' => 'បុគ្គលិក.ម៉ោង', 'en_name'=>'person.hour'],
                [ 'kh_name' => 'បង្គោល', 'en_name'=>'item'],
                
            ]);
	}
}
