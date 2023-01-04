<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Page;
class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[];
        $pages=Page::whereBetween('id',[401,604])->get();
        foreach ($pages as $page) {
            $data[]=[
            "id"=>$page->id,
            "juz_id"=>$page->juz_id,
            ]; 
        }
        DB::connection('sqlite')->table('pages')->insert( $data );
    }
}
