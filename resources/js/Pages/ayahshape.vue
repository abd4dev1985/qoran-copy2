<template>


    <!--tool bar -->
    <Teleport v-if="open"   to='#tool_bar' >
        <div   v-click-outside="close" class="text-white flex justify-around items-center larg:h-16   h-14  w-full  bg-rose-400 shadow-xl  z-40 ">
            
            <div @click="get_audio(surah_id,number,id)" class="mx-2 hidden" >         
                <svg  class="w-6 h-6 mx-auto rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                <span class="text-xs align-top" >استماع   </span>
            </div>
             <div  @click="get_audio(surah_id,number,id)" class="mx-2" >  
                <svg class="mx-auto  w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>       
                <span class="text-xs align-top" >استماع   </span>
            </div>

            <div  @click="get_tafseers(id,body)"   class="mx-2" >
                <svg class="w-6 h-6  mx-auto " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class=" text-xs align-top " > تفسير  </span>
            </div>

            <div  @click="add_marke(surah_id,number,id)"  class="mx-2"  >
                <svg class="w-6 h-6 mx-auto " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                <span class="text-xs align-top" > علامة   </span>
            </div>
              
           <!-- <div>{{store.markes.list}}</div>-->
            <!--tool bar -->
        </div>
    </Teleport >
    
       
    <div @click="opne_tool_bar" class="inline-block  align-bottom  relative overflow-auto  " > 
        
        <img class="dark:hidden inline-block w-10 h-8 mobile:w-8 mobile:h-7   "  src=" /img/quranayah.png">
        <img class="dark:inline-block hidden w-10 h-8 mobile:w-8 mobile:h-7   "  src=" /img/darkquranayah3.png">
        <span class=" w-6 text-center text-red-300 dark:text-gray-200  text-xs font-bold absolute mobile:left-[10%] left-[20%] top-[14px] z-10">{{number}}</span> 

    </div>   
      
   
</template>
<script>
import { nextTick } from 'vue'
import store from '../store.vue';
import { Inertia } from '@inertiajs/inertia'
let db = require(__dirname + '/../DB');

export default{

props:[
        'number','body','surah_id','id','page','surah_name',
    ],
//data
data() {
    return {
        store,
        open: false, 
        play_audio:false,
        url:"",
    }
},
// mount
setup() {
 
 let show_audio =store.show_audio;
 let audio_url=store.audio_url;
 
 return {show_audio,audio_url}   
    
},

methods: {
    close()
    {this.open = !this.open
       // if (store.show_audio.value ==false) {
         //   store.audio_surah_number.value=0
          //  store.audio_ayah_number.value=0
           // console.log(store.audio_ayah_number.value) 
      //  }
    },
    opne_tool_bar(){
      this.open=!this.open; 

    },
    get_tafseers(ayah_id,body){
        
        store.show_tafseer.value=true
        this.open=false
        store.globa_ayah_id.value = ayah_id
        store.ayah_tafseer_id.value = ayah_id
        store.globa_ayah_body=body
        //check if tafseers has been downloaded befor in local storage

        db.get('qurandata',store.tafseers.type,(data)=>{
            //get tafseers from local storage
            if (data.length>0) {
                
               console.log(store.tafseers.type)
                console.log(data)
               console.log('tafseers has been downloaded befor') 
            }else{
            //make request for tafseers if   local storage is empty 
                Inertia.reload({
                   data:{tafseer_id:ayah_id,},
                   only: ['tafseers'],
                })
                let exceptionEventListener = (event) => { alert('عذرا لا يوجداتصال بشبكةالانترنت  يرجى التحقق') } 
                document.addEventListener('inertia:exception', exceptionEventListener)
                // Remove the listener
                setTimeout(() => {
                document.removeEventListener('inertia:exception', exceptionEventListener)  
                }, 4000);

            }
        })


        
       
    },
    get_audio(surah_num,ayah_num,id){
        store.audio_box.value='opened'
        store.audio_surah_number.value=surah_num ;
        store.audio_ayah_number.value=ayah_num ;
        store.audio_ayah_id.value=id ;
        store.get_url(surah_num,ayah_num,id)
        this.open=false
    },
    add_marke(surah_id,ayah_number,ayah_id){
       
       store.add_mark(surah_id,ayah_number,ayah_id,this.body,this.page,this.surah_name)
        this.open=false
    },
     
   get_marks(){
    console.log(store.markes.list)
   },
},       
}
</script>