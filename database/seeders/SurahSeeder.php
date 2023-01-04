<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Surah;
class SurahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[];
        $surhas=Surah::all();
        foreach ($surhas as $surha) {
            $data[]=[
            "id"=>$surha->id,
            "name"=>$surha->name,
            ]; 
        }
        DB::connection('sqlite')->table('surahs')->insert( $data );
      

    }
}
