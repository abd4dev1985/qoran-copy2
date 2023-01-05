<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware;
use Inertia\Inertia;
use App\Models\Surah;
use App\Models\Page;
use App\Models\Juz;
use App\Models\Ayah;
use App\Models\Tafseer;
use App\Http\Controllers\SurahController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Downloadtest;
use App\Http\Controllers\Ayah_controller;
use App\Actions\Searchaction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    

Route::get('/', function () {
    $surahs= Surah::all();
    return Inertia::render('mywelcome', [
        'surahs'=> $surahs,
    ]);
});
Route::get('/myroot', function () {
    $root= database_path('database.sqlite');
    return $root;
});

Route::inertia('/download','download');

Route::get('/trycache/{id}', function ($id) {
     $new_pages = Cache::get('surahs/'.$id);
     return  $new_pages  ;  
});

/*
Route::get('/baghawi', function () {
    // $response = Http::get('http://api.alquran.cloud/v1/quran/ar.jalalayn'); 
    $surahs=json_decode(Storage::get('ar.baghawi.json'))->data->surahs   ;  
    $id=0;
    $data=[];
    // $data[]=['id'=> $id,'jalalayn' => $ayah->text];
    foreach ($surahs as $surah) {
        foreach ($surah->ayahs as $ayah) {
            $id++;
            if ($id>6000 and $id<6237) {
                $data[]=['id'=> $id,'baghawi' => $ayah->text];
            }
        }
    }
   Tafseer::upsert( $data,['id'],['baghawi']);
    return    $data    ;  
});
*/

Route::get('/test_sqlite', function () {
   

 $pages=DB::connection('sqlite')->table('pages')->distinct()->get();
 return $pages ;
});
Route::get('/surahs_list', function () {
    $surahs_list = Surah::with('pages')->get();
    return  $surahs_list  ;
     
});
Route::get('/pages_list', function () {
    $pages_list = Page::with('surahs')->get();
    return  $pages_list  ;
});
Route::get('/testrenderdb', function () {
  // $surahs= DB::connection('pgsql2')->table('surahs')->distinct()->get();
   //$ayahs= DB::connection('pgsql2')->table('ayahs')->distinct()->get();
   $ayahs= Ayah::all();
    return  $ayahs  ;
});

Route::get('/juzs', function () {

    if (Cache::get('juzs')!=NULL){
        $pages = Cache::get('juzs');
        return $pages;
    }
    else{
        $juzs = Juz::with('pages')->get();
         // group only first page for each juz
        $pages=$juzs->map(function($juz){
            return $juz->pages()->first();
        });
        Cache::forever('juzs', $pages);
        return   $pages  ;
    }
});


Route::get('/tafseers/{type}', function ($type){
    $tafseers=Tafseer::all('id',$type,'page_id','surah_id');
   return  $tafseers;
} );

Route::get('/get_ayah', [Ayah_controller::class, 'get_ayah']);
//Route::get('/get_tafseer', [Ayah_controller::class, 'get_tafseer']);

Route::post('/name', [SurahController::class, 'get_name']);
//Route::get('/firstvue', [SurahController::class, 'first_vue']);
//Route::post('/firstvue', [SurahController::class, 'first_vue']);
Route::get('/surahs/all', [SurahController::class, 'all']);
Route::resources([
    'surahs' => SurahController::class]);

Route::resources([
        'pages' => PageController::class]);    
   
