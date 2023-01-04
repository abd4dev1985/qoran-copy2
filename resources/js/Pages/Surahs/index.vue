<template>

<Head>
  <title>القران الكريم كامل      </title>

</Head>
    
    <div class="relative bg-qurancover larg:bg-contain bg-cover ">
        <!--page for mobile --> 
        <div   v-if="screen_is_small" class="text-sm sticky top-0 z-10 flex justify-between w-full  bg-rose-400  dark:bg-gray-900 text-white font-semibold "> 
            <div v-if="store.pages_list.length!==0" class="py-2 mx-4 dark:bg-rose-500 px-2 rounded-lg shadow-lg dark:shadow-rose-600 dark:text-slate-200 ">
               <span  v-for="(surah, index) in store.pages_list[store.current_page-1].surahs" :key="index"   >
                        {{surah.name}} &nbsp; 
                    </span>
            </div>
            <div class=" text-center py-2 mx-4 dark:bg-rose-500 px-2  rounded-xl shadow-md dark:shadow-rose-600 ">جزء {{juz_id}}</div>
        </div>      
        <div  v-if="screen_is_small" style="direction: rtl;" class="relative dark:text-gray-200  text-zinc-700 dark:bg-black bg-white opacity-[.85] h-[790px]  shadow-lg  mobile:py-0.5 mx-auto text-justify leading-10  px-3  w-full  overflow-auto"  >
                <div v-for="(ayah, index) in ayahas_of_current_page" :key="index"  class=" inline  align-bottom relative focus-within:bg-rose-400  focus-within:text-white "
                ref="ayahas_of_current_page"  >
                    <div v-if="ayah.ayah_number==1" class="block text-center align-text-bottom dark:bg-black  " >
                        <h1 class=" my-2 py-1 bg-rose-500 text-white  dark:text-gray-100 w-1/2 mx-auto rounded-xl  align-text-bottom font-bold text-2xl dark:shadow-md shadow-xl dark:shadow-rose-600  "> سورة {{get_surah_name(ayah.surah_id)}} {{ayah.surah_id}}  </h1>
                        <h2 class="text-2xl " v-if="ayah.surah_id != 9 && ayah.surah_id != 1 "> بسم الله الرحمن الرحيم </h2>
                    </div>
                    <span
                    :id="ayah.id"  
                    :class="{ 'text-white bg-rose-400 ': check_audio(ayah.surah_id,ayah.ayah_number),}"
                    v-click-outside="remove_highlight"
                    class="text-xl leading-normal  font-semibold mx-0.5 font-serif  " >
                    {{ayah.body }}
                    </span>
                    <div :tabindex="get_highlighted()"  class=" inline-block align-bottom xxx" >
                        <ayahshape  :number="ayah.ayah_number" :body="ayah.body" :surah_id="ayah.surah_id"
                         :id="ayah.id"  :page="curent_page" :surah_name="get_surah_name(ayah.surah_id)"  >
                        </ayahshape >
                    </div>    
                </div>
            
                <div class="hidden">
                    <input class="border-2 border-red-600 w-96 " v-model="name"  />
                    <button v-on:click="show_surah" > get surah </button>
                </div>

                <div  class="mx-auto my-4 px-5 w-[300px] flex justify-around items-center  " >
                    <svg @click="previous_page"   xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                    <div  class="h-6 w-10  text-center " >{{store.current_page}}</div>
                    <svg @click="next_page"    xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                </div>
            
        </div>
        <!--page for pc -->   
         
        <div  v-if="screen_is_big"  style="direction: rtl;" class="relative dark:text-gray-200  text-zinc-700 dark:bg-black bg-white opacity-[.85] h-[620px]  shadow-lg  mobile:py-0.5 mx-auto text-justify leading-10 px-3  w-full  overflow-auto   dark:divide-rose-400 "  >
            <div class=" py-2 relative "   v-for="(page, index) in pages" :key="index">
                 <!--header for qran page --> 
                <div  v-if="screen_is_big" class="text-sm  flex justify-between w-full  bg-rose-400  dark:bg-rose-500 shadow-md dark:shadow-rose-600 text-white font-semibold dark:mb-3 "> 
                    <div  class="py-2  mx-4 px-2  dark:text-slate-200 ">
                    <span>  الجزء  </span>  <span>  {{page.juz_id}} ,  </span>
                     
                    <span>سورة </span>
                    <span  v-for="(surah, index) in page.surahs" :key="index"   >
                        {{surah.name}} 
                    </span> 
                    
                    </div>
                    <div class=" text-center py-2 mx-4 dark:bg-rose-500 px-2  rounded-xl shadow-md dark:shadow-rose-600 ">صفحة {{page.id}}</div>
                </div>

                <div   class="inline  align-bottom  relative focus-within:bg-rose-400  focus-within:text-white "
                v-for="(ayah, index) in page.ayahs" :key="index" ref="page.ayahs" >
                    <div v-if="ayah.ayah_number==1" class="block text-center dark:bg-black " >
                        <h1 v-bind:id="get_surah_name(ayah.surah_id)" class="text-white my-1 bg-rose-500 shadow-xl dark:shadow-rose-600 py-2 rounded-xl mt-4   text-xl     font-bold   w-1/4 mx-auto  "  > سورة {{get_surah_name(ayah.surah_id)}} {{ayah.surah_id}}</h1>
                        <h2 v-if="ayah.surah_id != 9 &&ayah.surah_id != 1"> بسم الله الرحمن الرحيم </h2>
                    </div>
                    <span
                    :id="ayah.id"  
                    :class="{'text-white bg-rose-500 ': check_audio(ayah.surah_id,ayah.ayah_number),}"
                    v-click-outside="remove_highlight"
                    class="text-xl font-serif font-semibold mx-0.5 " >
                    {{ayah.body }} 
                    </span>
                    <div :tabindex="get_highlighted()"  class="inline-block align-bottom xxx" >
                        <ayahshape  :number="ayah.ayah_number" :body="ayah.body" :surah_id="ayah.surah_id"
                          :id="ayah.id" :page="first_page"  :surah_name="get_surah_name(ayah.surah_id)" >
                        </ayahshape >
                    </div>   
                </div>
              
            </div>
        </div>
        <!--audio  bar -->
        <Teleport to="#sound_area">
            <div v-show="store.audio_box=='opened'" class="w-11/12  larg:w-6/12 bg-rose-400  mx-auto  border-2 border-rose-400 rounded-full " v-click-outside="togel_show_audio" >
                <audio v-show="show_audio"   ref="my_audio" class="inline-block w-10/12   border-rose-400 rounded-full " controls  preload="auto"  >


                    <source :src="audio_url" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
                <div v-show="show_audio" class="inline-block w-2/12 text-white text-center align-middle">
                    <svg @click="close_audio_box" xmlns="http://www.w3.org/2000/svg" class=" inline-block  h-7 w-8 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div> 
        </Teleport>

         <!--tafseer  modal -->
        <confirmation-modal :show="store.show_tafseer" @close="store.show_tafseer=false "  >
            <template #title>
                تفسير قوله تعالى 
            </template>

            <template #content>
                <div class="text-rose-500 dark:text-rose-400 font-semibold" >{{store.globa_ayah_body}}  </div>  
                <div class="dark:text-gray-200">{{store.get_ayah_tafseer()}}</div>   
            </template>

            <template #footer>
                <button  @click="store.show_tafseer=false">
                  اغلاق
                </button>
              
            </template>
        </confirmation-modal>
        
      
        <!--    
            <button v-on:click="get_user" > get user </button>
                
            <div>{{info}}</div>
        -->
         
   
    </div>

   
</template>
<script>
import { computed } from 'vue'
 import { usePage } from '@inertiajs/inertia-vue3'
 import { Head, Link } from '@inertiajs/inertia-vue3';
 import { Inertia, Method } from '@inertiajs/inertia';
 import Myapplayout from '../Myapplayout.vue';
 import Ayahshape from '../ayahshape.vue';
 import  Chatbox from '../Chatbox.vue';
 import ConfirmationModal from '../ConfirmationModal.vue';

 let mydb = require(__dirname + '/../../DB');
 import store from '../../store.vue';

 const axios = require('axios').default;

const users =
 [{ id: "1", name: "userabd", age: 35, email: "gopal@tutorialspoint.com" },
 { id: "2", name: "userrobi", age: 32, email: "prasad@tutorialspoint.com" } ];  
let fruits =
 [{ id: "1", name: "banan" },
 { id: "2", name: "appel" } ]; 

 



export default  {

    layout: Myapplayout,
    components: {
            Head, Link,Ayahshape,Chatbox,ConfirmationModal,
        },
    props:[
        'surah','first_page','last_page','pages','surahs','title',
        'requested_page','tafseers',
    ],
    setup() {
        //let all_pages =computed(() => usePage().props.value.all_pages)
        let show_audio =store.show_audio;
        let audio_url=store.audio_url
        let audio_ayah_number = store.audio_ayah_number
        let audio_surah_number=store.audio_surah_number
        let increas =store.increas
        return {show_audio ,audio_url,audio_ayah_number,audio_surah_number,increas, }   
            
    },
    mounted(){
     store.audio_url.value=""   ;
     store.show_audio.value=false ;
     store.audio_surah_number.value=0;
     store.audio_ayah_number.value=0 ;
     store.current_page.value=(this.requested_page >= this.first_page && this.requested_page<=this.last_page ) ? this.requested_page:this.first_page
      ;

    },
    watch:{
        audio_url(new_url,old_url){
             let my_audio = this.$refs.my_audio
             my_audio.load();
             my_audio.play();
             my_audio.onended =this.play_next_audio;
        },
        show_audio(new_state,old_state){
            setTimeout(() => {
               this.can_togel_show_audio=true;  
            }, 1300);
           
        },
    },
    data() {
        return {
            store,    
            name: "",
            info: "gggg", 
            can_togel_show_audio:false,
            highlight:true, 
            curent_page:(this.requested_page >= this.first_page && this.requested_page<=this.last_page ) ? this.requested_page:this.first_page ,
            get_surah_name :(id)=>{
                let name= this.surahs[id].name;
                return name
            },
            get_ayah:(id)=>{
                if (store.tafseer_page.value===0) {
                    return id
                } else {
                    console.log(' page store'+store.tafseer_page.value)
                     return this.pages[store.tafseer_page.value].ayahs[id-1].body    
                }
               
                
                //console.log(this.get_ayah_tafseer.page_id)
               // return this.get_ayah_tafseer;
            },
            
        }
    },
    computed:{
        ayahas_of_current_page(){
         return this.pages[store.current_page.value].ayahs
        },
        surahs_of_current_page(){
         return this.pages[this.curent_page].surahs
        },
       juz_id(){
          return this.pages[this.curent_page].juz_id 
        },
        screen_is_big(){
            return store.screen_size.value>=900 ?true:false;  
        },
        screen_is_small(){
            return store.screen_size.value<=900 ?true:false;  
        },

         
    },
    methods :{
    get_surah()
    {    
        async function get_data()
        { 
            let my_response = await fetch('http://api.alquran.cloud/v1/quran/ar.muyassar');
            let my_data=await my_response.json();
            return my_data;
        }
        get_data().then( (data)=>{
            //this.name=data;
           console.log(data.data.surahs[1].ayahs[1].text);
            //Inertia.post('/surahs',{surahs:data});
             });
    } 
    ,
     show_surah()
    { this.get_surah(); }  
    ,

    async  get_user(){this.info = await  mydb.read_data('fruittable','mufruits'); }
    ,
     togel_show_audio(){
        if(this.can_togel_show_audio){ 
            this.show_audio=!this.show_audio
         }   
    },

    play_next_audio(){
        store.increas() 
        store.get_url(store.audio_surah_number.value,store.audio_ayah_number.value);
        if (this.screen_is_small) {
            let number_of_last_ayah = this.ayahas_of_current_page[Object.keys(this.ayahas_of_current_page)[Object.keys(this.ayahas_of_current_page).length-1]].ayah_number
            if (number_of_last_ayah<store.audio_ayah_number.value) { this.next_page()}
        } 
    },

    check_audio(surah_num,ayah_num){
      if (surah_num==store.audio_surah_number.value&&ayah_num==store.audio_ayah_number.value) {
       return  true ;
      }  

    },
    close_audio_box(){
        store.audio_box.value="closed"
        this.can_togel_show_audio=false
        store.show_audio.value=false
        store.audio_ayah_number.value=0
        store.audio_surah_number.value=0
        let my_audio = this.$refs.my_audio
        my_audio.pause()
    },
    bbbb(){
      console.log(window.navigator.standalone )
 
    },
    get_highlighted(){
        if (store.audio_box.value=="closed") {
           return "0"  
        }else{return null}
  
    },
    remove_highlight(){
      //  if (this.can_togel_show_audio==false) {
          // store.audio_surah_number.value=0
           // store.audio_ayah_number.value=0
       // }
        
    },
    next_page(){

      if (this.curent_page==this.last_page) {
        let targeted_surh_id = this.surah.id + 1;
        if (targeted_surh_id>112) {return false}
       }else{
            this.curent_page++
            store.current_page.value++
            window.scrollBy(0,-600)
       }
    },
    previous_page(){

       if (this.curent_page==this.first_page) {
            let targeted_surh_id = this.surah.id-1;
            if (targeted_surh_id<1) {return false}
       }else{
            this.curent_page--
            store.current_page.value--
            window.scrollBy(0,-600)
       }
    },




    },
       
    
}
</script>