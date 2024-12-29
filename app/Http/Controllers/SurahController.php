<?php

namespace App\Http\Controllers;

use App\Models\Surah;
use App\Models\Ayah;
use App\Models\Tafseer;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Actions\Searchaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
class SurahController extends Controller
{

    public function __construct()
    {
       // $this->middleware(['throttle:global']);
       
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $pages= Page::with(['ayahs','surahs',])->get();
        $pages = $pages->keyBy('id');
        $surahs = Surah::all();
        $surahs  = $surahs->keyBy('id') ;
      
         //return $pages ;
         
        return Inertia::render('Surahs/index',[
            'pages'=> $pages  ,
            'surahs'=>  $surahs ,
            'first_page'=> 1,
            'last_page'=> 604 ,
            'requested_page'=> $request->page,
            
        ]) ;
        
       
    }
    public function all(Request $request)
    {
        //$pages= Page::with(['ayahs','surahs',])->get();
        //$pages = $pages->keyBy('id');
        

        $surahs = Surah::all();
        $surahs  = $surahs->keyBy('id') ;
      
         //return $pages ;
         
        return Inertia::render('Surahs/index',[
            'pages'=> Cache::get('allQuran')  ,
            'surahs'=>  $surahs ,
            'first_page'=> 1,
            'last_page'=> 604 ,
            'requested_page'=> 1,
            'tafseers'=> Inertia::lazy(function(){
                $tafseers=Tafseer::all();   
                return $tafseers  ;}),
        ]) ;
        
       
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $surah= Surah::find($request->surah_number);
        $new_ayahs=[];
        foreach ($request->ayaht as $index => $ayah) {
        $new_ayahs[]=[ 'body' =>  $ayah ,'ayah_number' =>$index+1  ] ;     
        }
        $surah->ayahs()->createMany($new_ayahs );
     
        return redirect ('/surahs/'.$request->surah_number );

        //foreach ($request->surahs as $index => $surah) {
         // $new_surahs[]=[ 'name' =>  $surah    ] ;  
         // }

        //$new_surahs=[];
        //foreach ($request->surahs as $index => $surah) {
       // $new_surahs[]=[ 'name' =>  $surah    ] ;  
       // }
      
        //Surah::upsert( $new_surahs , ['name'], []);

       // $surah = new Surah ;
      //  $surah->name=  $request->name ;
      //  $surah->save();
        //return redirect('/surahs');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Surah  $surah
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, Surah $surah   )
    {
        
        $title =$surah->name;
        $requested_page=request('page',null);
        $requested_tafseer=request('tafseer','all_myasar_text');
        // get pages from chach if it is existed 

        if (Cache::get('surahs/'.$surah->id)!=NULL) {
             $pages = Cache::get('surahs/'.$surah->id);
        }else{
            $surah =Surah::with('pages.ayahs')->where('id',$surah->id)->first();
            $pages =  $surah->pages;
            $pages = $pages->keyBy('id');
            Cache::forever('surahs/'.$surah->id, $pages);
        }
        
        $first_page = $pages->first()->id;
        $last_page = $pages->last()->id;
       
        


        //$tafsser_surah =Surah::with('pages.ayahs:id,page_id,ayah_number')->where('id',$surah->id)->first();
        //$tafsser_pages = $tafsser_surah->pages ;
        //$tafsser_pages = $tafsser_pages->keyBy('id');
        //$ayahs=  $tafsser_pages->map(function($page, $key){return $page->ayahs ; });
        //$ayahs_ids =$ayahs->flatten()->keyBy('id')->keys(); 
        //$ayahs_tafseer=Tafseer::whereIn('ayah_id',$ayahs_ids)->get(); 

        //return   $ayahs_tafseer;
        //return   $pages ;
       
        session(['surah' =>  $surah->name ]);
        session(['surah_id' =>   $surah->id ]);
        
        return Inertia::render('Surahs/show',[
            'surah'=> $surah->only(['id','name']),'title'=>$title,
            'pages'=> function() use($pages) {return $pages;}  ,  
            'first_page'=>$first_page,'last_page'=>$last_page,'requested_page'=>$requested_page,
            'tafseers'=> Inertia::lazy(function(){
                $id=session()->get('surah_id');
              //  $ids_array= Ayah::where('surah_id',$id)->get('id');
              //  $surah= Surah::with('pages.ayahs:id,page_id,ayah_number')->where('id',$id)->first();
              //  $pages =$surah->pages;
              //  $pages = $pages->keyBy('id');
              //  $pages =  $pages->map(function($page, $key){return $page->ayahs ; });
               // $ids_array =$pages->flatten()->keyBy('id')->keys(); 
               // $tafseers=Tafseer::whereIn('id', $ids_array)->get();  
               $tafseers= Tafseer::find(request('tafseer_id'));
                return $tafseers  ;}),
        ]) ; 
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Surah  $surah
     * @return \Illuminate\Http\Response
     */
    public function edit(Surah $surah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Surah  $surah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Surah $surah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Surah  $surah
     * @return \Illuminate\Http\Response
     */
    public function destroy(Surah $surah)
    {
        //
    }
    public function get_name( Request  $request )
    {
        $mysurah= Surah::find( $request->number);
        return redirect()->action([SurahController::class, 'first_vue'],['surah' => $mysurah]);               
    }
    public function more_pages(  $surah_id )
    {
        $surah =Surah::with('pages.ayahs')->where('id',$surah_id)->first();
        $pages =  $surah->pages;
        $pages = $pages->keyBy('id');
        return   $pages ;        
    }
    

    public function first_vue( Request  $request )
    {   
      
        $surah =  Surah::find($request->number) ?? Surah::find(1);
        $user=  Auth::user();
        $request->session()->put('test',   $surah);
        $test = $request->session()->get('test');
        $ayahs_count= $surah->loadCount('ayahs');
       return Inertia::render('firstvue',['surah'=>$surah,'user'=>$user,'test'=>$test,'ayahs_count'=>$ayahs_count,])  ;
               
    }

}
