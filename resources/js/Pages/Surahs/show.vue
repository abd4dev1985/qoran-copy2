<template>

<Head>
  <title> سورة  {{title}}     </title>

</Head>
    
    <div class="relative bg-qurancover   larg:bg-contain bg-cover ">
            <!--page for mobile -->   
            <div   v-if="screen_is_small" class="text-sm sticky top-0 z-10 flex justify-between w-full  bg-rose-400  dark:bg-gray-900 text-white font-semibold "> 
                <div v-if="store.pages_list.length!==0" class="py-2 mx-4 dark:bg-rose-500 px-2 rounded-lg shadow-lg dark:shadow-rose-600 dark:text-slate-200 ">
                    <span  v-for="(surah, index) in store.pages_list[curent_page-1].surahs" :key="index"   >
                            {{surah.name}} &nbsp; 
                    </span>
                </div>
                <div class="dark:text-gray-200 dark:bg-rose-500 dark:shadow-rose-600 py-2  text-center rounded-xl">
                    <svg @click="next_page"  xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block mx-2 rotate-180">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                    </svg>
                    <span v-if="store.pages_list.length!==0">{{ store.pages_list[curent_page-1].id}}</span>
                    <svg @click="previous_page" xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block mx-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                    </svg>
                </div>
                <div class=" text-center py-2 mx-4 dark:bg-rose-500 px-2  rounded-xl shadow-md dark:shadow-rose-600 ">
                    جزء {{juz_id}} 
                </div>
            </div>   
            <div   v-if="screen_is_small" @click="toggel_navebar" v-on:touchstart.passive ="swipe_start($event)" v-on:touchmove.passive="swipe_move($event)" v-on:touchend ="swipe_end($event)"
             style="direction: rtl;" class="relative dark:text-gray-200  text-zinc-700 dark:bg-black bg-white opacity-[.85] min-h-screen  shadow-lg  mobile:py-0.5 mx-auto text-justify leading-10  px-3  w-full  overflow-auto"  >
                    <div   class=" inline  align-bottom relative focus-within:bg-rose-400  focus-within:text-white "
                    v-for="(ayah, index) in ayahas_of_current_page" :key="index" ref="ayahas_of_current_page"  >
                        <div v-if="ayah.ayah_number==1" class="block text-center align-text-bottom dark:bg-black  " >
                            <h1 class=" my-2 py-1 bg-rose-500 text-white  dark:text-gray-100 w-1/2 mx-auto rounded-xl  align-text-bottom font-bold text-lg dark:shadow-md shadow-xl dark:shadow-rose-600  ">
                            سورة {{get_surah_name(ayah.surah_id)}} {{ayah.surah_id}}
                            </h1>
                            <h2 class="text-[2.95vmax] font-semibold " v-if="ayah.surah_id != 9 && ayah.surah_id != 1"> بسم الله الرحمن الرحيم </h2>
                        </div>
                        <span
                        :id="ayah.id"  
                        :class="{ 'text-white bg-rose-400 ': check_audio(ayah.surah_id,ayah.ayah_number),}"
                        v-click-outside="remove_highlight"
                        class="text-[2.95vmax]  font-serif  font-semibold mx-0.5   " >
                        {{ayah.body }} 
                        </span>
                        <div :tabindex="get_highlighted()"  class=" inline-block align-bottom xxx" >
                            <ayahshape  :number="ayah.ayah_number" :body="ayah.body" :surah_id="ayah.surah_id"
                            :id="ayah.id"  :page="curent_page" :surah_name="get_surah_name(ayah.surah_id)"  >
                            </ayahshape >
                        </div>    
                    </div>
                
                    <!--paganation  for mobile -->  
                    <div  class="mx-auto my-4 px-5 w-[300px] flex justify-around items-center  " >
                        <svg @click="previous_page"   xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                        <div  class="h-6 w-10  text-center " >{{curent_page}}</div>
                        <svg @click="next_page"    xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                        </svg>
                    </div>
                
            </div>

             <!--page for pc and tabs --> 
            <div v-if="screen_is_big" @click="toggel_navebar"  class="min-h-screen dark:bg-black bg-white opacity-[.85] " style="direction: rtl;" >

                <!--additional previous pages -->
                <div v-if="additional_previouc_pages.length>0"  class="relative   dark:text-gray-200  text-zinc-700  shadow-lg  mx-auto  text-center leading-10 px-3  w-full  overflow-auto scroll-smooth "  >
                    <div class="mt-6 "   v-for="(page, index) in additional_previouc_pages" :key="index">
                    
                        <svg   ref="previous_navigator" @click="previous_page2(page.id)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden -mt-6 mx-auto w-8 h-8 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5-7.5 7.5 7.5m-15 6l7.5-7.5 7.5 7.5" />
                        </svg>
                        <!--header for qran page --> 
                        <div :id="'page'+page.id" v-if="screen_is_big" class="text-sm  flex justify-between w-full  bg-rose-400  dark:bg-rose-500 shadow-md dark:shadow-rose-600 text-white font-semibold mb-0.5 "> 
                            <div v-if="store.pages_list.length!==0" class="py-2  mx-4 px-2  dark:text-slate-200 ">
                                <span>  الجزء  </span>  <span>  {{page.juz_id}} ,  </span>
                                <span>سورة </span>
                                <span  v-for="(surah, index) in store.pages_list[page.id-1].surahs" :key="index"   >
                                    {{surah.name}} &nbsp;
                                </span> 
                            </div>
                           
                            <div class=" text-center py-2 mx-4 dark:bg-rose-500 px-2  rounded-xl shadow-md dark:shadow-rose-600 ">صفحة 
                                {{page.id}}
                            </div>
                        </div>

                        <div   class="inline  align-bottom  relative focus-within:bg-rose-400  focus-within:text-white "
                        v-for="(ayah, index) in page.ayahs" :key="index" ref="page.ayahs" >
                            <div v-if="ayah.ayah_number==1" class="block text-center dark:bg-black  " >
                                
                                <h1 class="text-white my-1 bg-rose-500 shadow-xl dark:shadow-rose-600 py-2 rounded-xl    text-3xl  w-1/4  min-w-fit font-bold   mx-auto  "  >
                                سورة {{get_surah_name(ayah.surah_id)}} {{ayah.surah_id}}
                                </h1>
                                <h2 class="text-3xl  font-serif my2"  v-if="ayah.surah_id != 9 && ayah.surah_id != 1 "> بسم الله الرحمن الرحيم </h2>
                            </div>
                            <span
                            :id="ayah.id"  
                            :class="{'text-white bg-rose-500 ': check_audio(ayah.surah_id,ayah.ayah_number),}"
                            v-click-outside="remove_highlight"
                            class="text-3xl font-serif  mx-0.5 " >
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


                 <!--basic pages -->    
                <div   class="relative   dark:text-gray-200  text-zinc-700  shadow-lg  mx-auto  text-center leading-10 px-3  w-full  overflow-auto  "  >
                    <div class="mt-6  max-h-screen "   v-for="(page, index) in pages" :key="index">
                    
                        <svg  v-if="page.id===first_page" ref="previous_navigator" @click="previous_page2(page.id)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-6 mx-auto w-8 h-8 text-gray-500">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5-7.5 7.5 7.5m-15 6l7.5-7.5 7.5 7.5" />
                        </svg>
                        <!--header for qran page --> 
                        <div :id="'page'+page.id" v-if="screen_is_big" class="text-lg  flex justify-between w-full  bg-rose-400  dark:bg-rose-500 shadow-md dark:shadow-rose-600 text-white font-semibold mb-0.5 "> 
                            <div v-if="store.pages_list.length!==0" class="py-2  mx-4 px-2  dark:text-slate-200 ">
                                <span>  الجزء  </span>  <span>  {{page.juz_id}} ,  </span>
                                <span>سورة </span>
                                <span  v-for="(surah, index) in store.pages_list[page.id-1].surahs" :key="index"   >
                                    {{surah.name}} &nbsp;
                                </span> 
                            </div>
                           
                            <div class=" text-center py-2 mx-4 dark:bg-rose-500 px-2  rounded-xl shadow-md dark:shadow-rose-600 ">صفحة 
                                {{page.id}}
                            </div>
                        </div>

                        <div   class="inline  align-bottom  relative focus-within:bg-rose-400  focus-within:text-white "
                        v-for="(ayah, index) in page.ayahs" :key="index" ref="page.ayahs" >
                            <div v-if="ayah.ayah_number==1" class="block text-center dark:bg-black  " >
                                
                                <h1 class="text-white my-1 bg-rose-500 shadow-xl dark:shadow-rose-600 py-2 rounded-xl    text-3xl  w-1/4  min-w-fit font-bold   mx-auto  "  >
                                سورة {{get_surah_name(ayah.surah_id)}} {{ayah.surah_id}}
                                </h1>
                                <h2 class="text-3xl my2 font-serif"  v-if="ayah.surah_id != 9 && ayah.surah_id != 1 "> بسم الله الرحمن الرحيم </h2>
                            </div>
                            <span
                            :id="ayah.id"  
                            :class="{'text-white bg-rose-500 ': check_audio(ayah.surah_id,ayah.ayah_number),}"
                            v-click-outside="remove_highlight"
                            class="text-3xl font-serif  mx-0.5 " >
                            {{ayah.body }} 
                            </span>
                            <div :tabindex="get_highlighted()"  class="inline-block align-bottom xxx" >
                                <ayahshape  :number="ayah.ayah_number" :body="ayah.body" :surah_id="ayah.surah_id"
                                :id="ayah.id" :page="first_page"  :surah_name="get_surah_name(ayah.surah_id)" >
                                </ayahshape >
                            </div>   
                        </div>
                        <!--next  page  for pc --> 
                        <svg ref="mynavigator"   v-if="page.id===last_page" @click="next_page2(page.id)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" w-1/4 h-14 mx-auto text-gray-500 my-10 ">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    <!--next & previouc page  for pc -->  
                    <div class="hidden  w-full my-2  justify-around">
                        <a class="block rounded-xl px-2 text-center bg-rose-500 dark:bg-rose-600 shadow-xl font-semibold text-white" @click="previous_page" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                            <span>السورة السابقة </span>
                        </a>
                        <a class="block rounded-xl px-2  text-center bg-rose-500 dark:bg-rose-600 shadow-xl text-white font-semibold " @click="next_page" href="#" >
                            <span>السورة التالية </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>  
                        </a>
                    </div>
                </div>
                
                <!--additional NEXT pages -->
                <div  v-if="additional_next_pages.length>0" class="relative dark:text-gray-200  text-zinc-700   shadow-lg  mx-auto text-center leading-10 px-3  w-full  overflow-auto  "  >
                    <div class="mt-6 "   v-for="(page, index) in additional_next_pages" :key="index">
                    
                        <!--header for qran page --> 
                        <div :id="'page'+page.id" v-if="screen_is_big" class="text-sm  flex justify-between w-full  bg-rose-400  dark:bg-rose-500 shadow-md dark:shadow-rose-600 text-white font-semibold mb-3 "> 
                            <div v-if="store.pages_list.length!==0" class="py-2  mx-4 px-2  dark:text-slate-200 ">
                            <span>  الجزء  </span>  <span>  {{page.juz_id}} ,  </span>
                            <span>سورة </span>
                            
                            <span  v-for="(surah, index) in store.pages_list[page.id-1].surahs" :key="index"   >
                                {{surah.name}} &nbsp;
                            </span> 
                            
                            </div>
                            <div class=" text-center py-2 mx-4 dark:bg-rose-500 px-2  rounded-xl shadow-md dark:shadow-rose-600 ">صفحة {{page.id}}</div>
                        </div>

                        <div   class="inline  align-bottom  relative focus-within:bg-rose-400  focus-within:text-white "
                        v-for="(ayah, index) in page.ayahs" :key="index" ref="page.ayahs" >
                            <div v-if="ayah.ayah_number==1" class="block text-center dark:bg-black  " >
                                <h1 class="text-white my-1 bg-rose-500 shadow-xl dark:shadow-rose-600 py-2 rounded-xl    text-3xl  w-1/4  min-w-fit font-bold   mx-auto  "  >
                                سورة {{get_surah_name(ayah.surah_id)}} {{ayah.surah_id}}
                                </h1>
                                <h2  class="text-3xl font-serif my2" v-if="ayah.surah_id != 9 && ayah.surah_id != 1 "> بسم الله الرحمن الرحيم </h2>
                            </div>
                            <span
                            :id="ayah.id"  
                            :class="{'text-white bg-rose-500 ': check_audio(ayah.surah_id,ayah.ayah_number),}"
                            v-click-outside="remove_highlight"
                            class="text-3xl font-serif  mx-0.5 " >
                            {{ayah.body }} 
                            </span>
                            <div :tabindex="get_highlighted()"  class="inline-block align-bottom xxx" >
                                <ayahshape  :number="ayah.ayah_number" :body="ayah.body" :surah_id="ayah.surah_id"
                                :id="ayah.id" :page="first_page"  :surah_name="get_surah_name(ayah.surah_id)" >
                                </ayahshape >
                            </div>   
                        </div>
                        <!--next  page  for pc --> 
                        <svg ref="mynavigator"  @click="next_page2(page.id)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden w-1/4 h-14 mx-auto text-gray-500 my-10 ">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    
                </div>
            </div>
           
            
            <!--audio  bar -->
            <Teleport to="#sound_area">
                <div v-show="store.audio_box=='opened'" class="w-11/12  larg:w-6/12 bg-rose-400  mx-auto  rounded-full " v-click-outside="togel_show_audio" >
                    <audio v-show="show_audio"   ref="my_audio" class="inline-block w-10/12  border-2  border-rose-400 rounded-full " controls  preload="auto"  >
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
                        <div   class="dark:text-gray-200">
                            {{tafseer_of_ayah}}
                        </div> 
                    
                </template>

                <template #footer>
                    <button @click="store.show_tafseer=false;tafseers=[]">
                    اغلاق
                    </button> 
                </template>
            </confirmation-modal>
            
        
        
         
   
    </div>

   
</template>
<script>

 import { computed,reactive ,ref} from 'vue'
 import { usePage } from '@inertiajs/inertia-vue3'
 import { Head, Link } from '@inertiajs/inertia-vue3';
 import { Inertia, Method } from '@inertiajs/inertia';
 import Myapplayout from '../Myapplayout.vue';
 import Ayahshape from '../ayahshape.vue';
 import  Chatbox from '../Chatbox.vue';
 import ConfirmationModal from '../ConfirmationModal.vue';
 import store from '../../store.vue';

//let db = require(__dirname + '/../../DB');
//const axios = require('axios').default;
let show_navbar = ref( true )
let touch_start_point 
let touch_moving_point 
let active_distance =window.innerWidth*0.35

export default  {

    layout: (h,page)=>h(Myapplayout,{show_navbar:show_navbar.value},()=>page),
    components: {
            Head, Link,Ayahshape,Chatbox,ConfirmationModal,
        },
    props:[
        'surah','first_page','last_page','pages','title','requested_page','tafseers',
    ],
    setup() {
        
        let show_audio =store.show_audio;
        let audio_url=store.audio_url
        let audio_ayah_number = store.audio_ayah_number
        let audio_surah_number=store.audio_surah_number
        let increas =store.increas
        return {show_audio ,audio_url,audio_ayah_number,audio_surah_number,increas, }   
            
    },

    mounted(){ 

     if (this.screen_is_small) {
        show_navbar.value=false
      }  
      window.addEventListener('resize', this.onResize)
      store.audio_url.value=""   ;
      store.show_audio.value=false ;
      store.audio_surah_number.value=0;
      store.audio_ayah_number.value=0 ;
      store.current_page.value=(this.requested_page >= this.first_page && this.requested_page<=this.last_page ) ? this.requested_page:this.first_page ;
    },
    watch:{
        audio_url(new_url,old_url){
             let my_audio = this.$refs.my_audio
             my_audio.load();
             my_audio.play();
            setTimeout(() => {
               this.show_audio=false;  
            }, 2000);
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
             show_navbar, 
            additional_next_pages:[],
            additional_previouc_pages :[],
            testarray:{name:'abd',wife:'robi'},
            info: "gggg", 
            can_togel_show_audio:false,
            highlight:true, 
            my_first_page:Object.values(this.pages)[0].id,
            curent_page:(this.requested_page >= this.first_page && this.requested_page<=this.last_page ) ? this.requested_page:this.first_page ,
            get_surah_name :(id)=>{
                if (store.surahs_list.value.length>0) {
                     let name= store.surahs_list.value[id-1].name;
                    return name
                }    
            },
           
           
            
        }
    },
    computed:{
        ayahas_of_current_page(){
         return this.pages[this.curent_page].ayahs
        },
       juz_id(){
          return this.pages[this.curent_page].juz_id 
        },
        screen_is_big(){
            return store.screen_size.value>=1000||window.innerHeight >=1000  ?true:false;  
        },
        screen_is_small(){
            return store.screen_size.value<=1000  && window.innerHeight <=1000 ?true:false;  
        },
        tafseer_of_ayah(){
            
            if (this.tafseers!=null&&this.tafseers.length!=0) {
                console.log('online yes')
                console.log(this.tafseers)
                console.log(store.tafseers.type)
               return  this.tafseers[store.tafseers.type]
            } else if (store.tafseers.body.length>0) {
                 let index=store.globa_ayah_id.value-1
                 let text=store.tafseers.type
                 console.log('offline')
                return store.tafseers.body[index][text]

            }
           
        },
    },
    methods :{
    // navigating page in mobile by swipe using  swipe_start,swipe_move & swipe_end
    swipe_start(event){
        touch_start_point=event.touches[0].clientX
    },
    swipe_move(event){
        touch_moving_point=event.touches[0].clientX
        console.log(touch_moving_point)
    },
    swipe_end(event){
        let swipe_distance =touch_start_point-touch_moving_point
        console.log("distancs "+swipe_distance)
        console.log("touch_start_point "+touch_start_point)
        console.log("touch_moving_point "+touch_moving_point)
        
        if (swipe_distance<-active_distance && touch_moving_point!=0 ) {
            this.previous_page()
        } else { 
            if (swipe_distance>active_distance && touch_moving_point!=0) {
                this.next_page()
            } 
        }
        // reset touching point 
        touch_moving_point=0
    },

    // show & hide navbar
    togel_show_audio(){
        if(this.can_togel_show_audio){ 
            this.show_audio=!this.show_audio
         }   
    },

    play_next_audio(){
        store.increas() 
        store.get_url(store.audio_surah_number.value,store.audio_ayah_number.value,store.audio_ayah_id.value);
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
        store.audio_ayah_id.value=0
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
     toggel_navebar(){
        
           show_navbar.value=!show_navbar.value
        
    },
    onResize(){
        show_navbar.value=false
        this.set_font_size() 
    }
    ,
    previous_page2(current_page_number){
        let my_array=[]
        let previous_surah_number  
        let cut_last_page =false
        let n = this.$refs.previous_navigator.length
        if (n>2) {
           // console.log(this.$refs.previous_navigator)
        } else {
            this.$refs.previous_navigator[0].style.display="none" 
        }
        if (store.pages_list.length!==0) {
            let surahs_of_page= store.pages_list.value[current_page_number-1].surahs
            let pages_of_first_surah=store.surahs_list.value[surahs_of_page[0].id-1].pages.length

            if (surahs_of_page.length>1 && pages_of_first_surah>1 ) {
               previous_surah_number=surahs_of_page[0].id
               cut_last_page =true
            }else{
                 previous_surah_number=surahs_of_page[0].id-1
            }
            
            fetch('/surahs/more_pages/'+previous_surah_number ).then((res)=> res.json()).then((data)=>{
                console.log('in fetch '+previous_surah_number )
                console.log(data)
                for (const key in data) {
                    if (Object.hasOwnProperty.call(data, key)) {
                        const page = data[key];
                        my_array.push(page)
                    }
                }
                if (cut_last_page) {
                  my_array.splice(my_array.length-1, 1);  
                }
                this.additional_previouc_pages.splice(0,0,...my_array)
               // my_array=my_array.concat(this.additional_previouc_pages)
               //this.additional_previouc_pages=my_array
                console.log( this.additional_previouc_pages)
                setTimeout(() => {
                let link_id= my_array[my_array.length-1].ayahs.slice(-1)[0].id
                this.$refs.previous_navigator[1].style.display="block"
                window.location.replace('#'+ link_id);
                //window.scrollBy(0, -0.20* window.innerHeight)
                }, 300);
               
            })  
        }

        
    },

    next_page2(current_page_number){
        let my_array=this.additional_next_pages
        let last_surah
        let cut_first_page =false
        let next_surah_number
        this.$refs.mynavigator[0].style.display="none"  
        let n = this.$refs.mynavigator.length
        if (n>1) {
             this.$refs.mynavigator[n-1].style.display="none"
        }
        
        if (store.pages_list.length!==0) {
            let surahs= store.pages_list.value[current_page_number-1].surahs
            last_surah=surahs[surahs.length-1]
            let pages_of_last_surah=store.surahs_list.value[last_surah.id-1].pages.length
            if (surahs.length>1 && pages_of_last_surah>1 ) {
                next_surah_number=  last_surah.id
                cut_first_page=true
            }else{
                 next_surah_number=  last_surah.id+1
            }
             //console.log("last_surah_pages is " +pages_of_last_surah)
            //console.log(store.surahs_list.value[last_surah.id-1])

            
            //console.log(store.surahs_list.value[last_surah.id-1].pages)
            fetch('/surahs/more_pages/'+next_surah_number ).then((res)=> res.json()).then((data)=>{
              
                for (const key in data) {
                    if (Object.hasOwnProperty.call(data, key)) {
                        const page = data[key];
                        my_array.push(page)
                    }
                }
                if (cut_first_page) {
                   my_array.shift() 
                }
                this.additional_next_pages=my_array
                setTimeout(() => {
                window.scrollBy(0, 0.5* window.innerHeight) 
                 n = this.$refs.mynavigator.length
                console.log(this.$refs.mynavigator[n-1])
                this.$refs.mynavigator[n-1].style.display="block"
                }, 300);
               
            })
        }
         
    },
    next_page(){

       if (this.screen_is_big) {
        let next_surah_number=this.surah.id+1
        Inertia.visit("/surahs/"+next_surah_number,{method:'get',});
       
       } 
      if (this.curent_page==this.last_page) {
        let next_page = store.pages_list.value[this.last_page]
        let surah_id = next_page.surahs[0].id;
        if (surah_id>112) {return false}

        let url="/surahs/"+surah_id;
        Inertia.visit(url,{
            method:'get',
            data:{
                page:this.last_page+1,
            },
        });
       }else{
            this.curent_page++
            store.current_page.value++
            window.scrollBy(0,-600)
       }
    },
    previous_page(){
        if (this.screen_is_big) {
            let previous_surah_number=this.surah.id-1
            Inertia.visit("/surahs/"+previous_surah_number,{method:'get',});
        }
       if (this.curent_page==this.first_page) {
            let previous_page=store.pages_list.value[this.first_page-2]
            let index_of_last_surah_in_page=previous_page.surahs.length-1
            let surah_id =previous_page.surahs[index_of_last_surah_in_page].id;
            if (surah_id<1) {return false}
           

           let url="/surahs/"+surah_id;
           Inertia.visit(url,{
               method:'get',
               data:{
                   page:this.first_page-1,
               },
           });
       }else{
             this.curent_page--
              store.current_page.value--
              window.scrollBy(0,-600)
       }
    },




    },
       
    
}
</script>