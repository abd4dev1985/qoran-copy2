<?php

namespace App\Http\Controllers;

use App\Models\Surah;
use App\Models\Ayah;
use App\Models\Tafseer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Ayah_controller extends Controller
{
       
    private static function  arquery($text)
    {
        $replace = array("قَ", "ق", "تَ", "ت", "مَ", "م", "خَ", "خ",);
        $with   =array( "(ق|قَ)", "(ق|قَ)", "(ت|تَ)","(ت|تَ)","(م|مَ)","(م|مَ)", "(خ|خَ)", "(خ|خَ)", );
        $new     = array_combine($replace,$with);

        $return = "" ;
        $len = strlen(utf8_decode($text));

        for($i=0;$i<$len;$i++){
            $current = mb_substr($text,$i,1,'utf-8');
            if(isset($new[$current])){
                $return.=$new[$current];
            }
            else{
                $return.=$current;
            }
        }
        return $return;
    } 

    public function get_ayah(Request $request)
    {
        $keyword  = $this->arquery($request['ayah']);
        $modules  = [4,19,21,23,24,26];

        $ayah = Ayah::where('body', 'REGEXP',$keyword)->get();
        return   $ayah ;
        
    }
    public function searchKeyword(Request $request)
    {
        $keyword  = $this->arquery($request['search_keyword']);
        $modules  = [4,19,21,23,24,26];
        $articles = Post::where('name', 'REGEXP', $keyword)
                ->orWhere('short', 'REGEXP', $keyword)->get();
       
        return  view('site.articles.search')
            ->with('articles' ,$articles)
            ->with('key' ,$request['search_keyword']);
    }
    public function get_tafseer(Request $request)
    {
        $response = Http::get('http://api.alquran.cloud/v1/ayah/8:1/ar.muyassar');
        return  $response['data'];
       
    }


}
