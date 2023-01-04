<?php

namespace App\Http\Middleware;

use App\Actions\Searchaction;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Surah;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    
    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
      
        return array_merge(parent::share($request), [
             
            // اسم السورة 
            'surah' =>function() {; return $request->surah ?? Surah::find(1) ; } ,
              // نتائج البحث 
            'search_results' => function() use($request) { 
                $query = new Searchaction ;
                return  $query->search($request->text)?? null ;
             } ,
             'letters'=>function(){ 
                $query = new Searchaction ;
                return  $query->make_letters();  },
                

           
            
        ]);
    }


}
