<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Ayah;
use App\Models\Tafseer;

class AyahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[];
        $ayahs=Ayah::where('surah_id',1)->get();
        foreach ($ayahs as $ayah) {
            $data[]=[
            "id"=>$ayah->id,
            "surah_id"=>$ayah->surah_id,
            "ayah_number"=>$ayah->ayah_number,
            "body"=>$ayah->body,
            "page_id" =>$ayah->page_id,   
            ]; 
        }
        DB::connection('pgsql2')->table('ayahs')->insert( $data );
       
    }
}
