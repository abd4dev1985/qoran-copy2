<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surah;
use App\Models\Ayah;
use App\Models\Tafseer;
use App\Models\Page;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Actions\Searchaction;
use Illuminate\Database\Eloquent\Builder;

class PageController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(  Page $page   )
    {
        $title ="صفحة رقم ".$page->id;
        $requested_page=request('page',null);
        $requested_tafseer=request('tafseer','all_myasar_text');
        $surahs =$page->surahs()->with('pages')->get()  ;
      
        return     $surahs ; 
        $first_page = $surah->pages->first()->id;
        $last_page = $surah->pages->last()->id;

        $pages =  $surah->pages;
        $pages = $pages->keyBy('id');

     
        $surahs_list=$pages->map(function ($page, $key) {
            return $page->ayahs->groupBy('surah_id')->keys();
        });
        $surahs_list =  $surahs_list->flatten();
       
        $surahs = Surah::whereIn('id', $surahs_list)->get();
        //$surahs =Surah::with('pages')->whereIn('id', $surahs_list)->get();
        $surahs  = $surahs->keyBy('id') ;
         //return $surahs ;
        session(['surah' =>   $surah->name ]);
        session(['surah_id' =>   $surah->id ]);
        
        return Inertia::render('Surahs/show',[
            'surah'=> $surah->only(['id','name']),'title'=>$title,
            'pages'=>$pages,  'surahs'=> $surahs,
            'first_page'=>$first_page,'last_page'=>$last_page,'requested_page'=>$requested_page,
            'tafseers'=> Inertia::lazy(function(){
                $id=session()->get('surah_id');
                $surah= Surah::with('pages.ayahs:id,page_id,ayah_number')->where('id',$id)->first();
                $pages =$surah->pages;
                $pages = $pages->keyBy('id');
                $pages =  $pages->map(function($page, $key){return $page->ayahs ; });
                $ids_array =$pages->flatten()->keyBy('id')->keys(); 
                $tafseers=Tafseer::whereIn('ayah_id', $ids_array)->get();   
                return $tafseers  ;}),
        ]) ; 
        
        
    }

    
}
