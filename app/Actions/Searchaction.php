<?php

namespace App\Actions;

use App\Models\Surah;
use App\Models\Ayah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;

class Searchaction 
{
    
    public $result ="my result";

    public  function  arquery($text)
    {
        $replace = array("قَ", "ق", "تَ", "ت", "مَ", "م", "خَ", "خ",);
        $with   =array( "(ق|قَ)", "(ق|قَ)", "(ت|تَ)","(ت|تَ)","(م|مَ)","(م|مَ)", "(خ|خَ)", "(خ|خَ)", );
       // $new     = array_combine($replace,$with);
        $new = $this->make_letters();
        $return = "" ;
        $len = strlen(utf8_decode($text));

        for($i=0;$i<$len;$i++){
            $current_letter = mb_substr($text,$i,1,'utf-8');
            if(isset($new[$current_letter])){
                $return.=$new[$current_letter];
            }
            else{
                $return.=$current_letter;
            }
        }
        return $return;
    } 


    public function search($text )
    {
       
      if ($text != "" or $text != null ) {
        $text  = $this->arquery($text);
        $ayahs = Ayah::with('surah')->where('body', 'REGEXP', $text)->get();
        return  $ayahs ; }
    }

    public function make_letters( )
    {    

        //$replace = array("قَ", "ق", "تَ", "ت", "مَ", "م", "خَ", "خ",);
       // $with   =array( "(ق|قَ)", "(ق|قَ)", "(ت|تَ)","(ت|تَ)","(م|مَ)","(م|مَ)", "(خ|خَ)", "(خ|خَ)", );
       // $new     = array_combine($replace,$with);
      //  return   $new ;
        $letters= [
        "ض","ص","ث","ق","ف","غ","ع","","ه","خ","ح","ج","د",
        "ش","س","ي","ب","ل","ا","ت","ن","م","ك","ط","ذ","ئ","ء","ؤ",
        "ر","لا","ى","ة","و","ز","","ظ","أ","إ","آ",] ;

        $harakat=["","ْ","َ","ِ","ُ","~","ً","ٌ","ٍ","ّ","َّ","ْ","ُّ","ِّ",];

        $letters_with_harakat=[];

        foreach ($letters as $letter) {
            foreach ($harakat as $haraka) {
                if ($letter=="ا") {
                    $sub_letter1= "أ";
                    $sub_letter2= "إ";
                    $sub_letter3="آ" ;
                    $letters_with_harakat[$letter] ="(".$letter."|".$letter.$harakat[1]."|" .$letter.$harakat[2]."|".$letter.$harakat[3]."|".$letter.$harakat[4]."|".$letter.$harakat[5]."|".$letter.$harakat[6]."|".$letter.$harakat[7]."|".$letter.$harakat[8]."|".$letter.$harakat[9]."|".$letter.$harakat[9]."|".$letter.$harakat[10]."|".$letter.$harakat[11]."|".$letter.$harakat[12]."|".$letter.$harakat[13]."|".
                        $sub_letter1."|".$sub_letter1.$harakat[1]."|" .$sub_letter1.$harakat[2]."|".$sub_letter1.$harakat[3]."|".$sub_letter1.$harakat[4]."|".$sub_letter1.$harakat[5]."|".$sub_letter1.$harakat[6]."|".$sub_letter1.$harakat[7]."|".$sub_letter1.$harakat[8]."|".$sub_letter1.$harakat[9]."|".$sub_letter1.$harakat[9]."|".$sub_letter1.$harakat[10]."|".$sub_letter1.$harakat[11]."|".$sub_letter1.$harakat[12]."|".$sub_letter1.$harakat[13]."|".
                        $sub_letter2."|".$sub_letter2.$harakat[1]."|" .$sub_letter2.$harakat[2]."|".$sub_letter2.$harakat[3]."|".$sub_letter2.$harakat[4]."|".$sub_letter2.$harakat[5]."|".$sub_letter2.$harakat[6]."|".$sub_letter2.$harakat[7]."|".$sub_letter2.$harakat[8]."|".$sub_letter2.$harakat[9]."|".$sub_letter2.$harakat[9]."|".$sub_letter2.$harakat[10]."|".$sub_letter2.$harakat[11]."|".$sub_letter2.$harakat[12]."|".$sub_letter2.$harakat[13]."|".
                        $sub_letter3."|".$sub_letter3.$harakat[1]."|" .$sub_letter3.$harakat[2]."|".$sub_letter3.$harakat[3]."|".$sub_letter3.$harakat[4]."|".$sub_letter3.$harakat[5]."|".$sub_letter3.$harakat[6]."|".$sub_letter3.$harakat[7]."|".$sub_letter3.$harakat[8]."|".$sub_letter3.$harakat[9]."|".$sub_letter3.$harakat[9]."|".$sub_letter3.$harakat[10]."|".$sub_letter3.$harakat[11]."|".$sub_letter3.$harakat[12]."|".$sub_letter3.$harakat[13]. ")";
                }    
                else{    
                $letters_with_harakat[$letter]        = "(".$letter."|".$letter.$harakat[1]."|" .$letter.$harakat[2]."|".$letter.$harakat[3]."|".$letter.$harakat[4]."|".$letter.$harakat[5]."|".$letter.$harakat[6]."|".$letter.$harakat[7]."|".$letter.$harakat[8]."|".$letter.$harakat[9]."|".$letter.$harakat[9]."|".$letter.$harakat[10]."|".$letter.$harakat[11]."|".$letter.$harakat[12]."|".$letter.$harakat[13]. ")";
                //$letters_with_harakat[$letter.$haraka] = "(".$letter."|".$letter.$haraka.")";   
                }
            }

        }    
        return $letters_with_harakat ;


    }
      
     
    

   
}
