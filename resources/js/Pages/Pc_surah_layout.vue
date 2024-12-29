<template>
<div v-if="screen_is_big" class="min-h-screen dark:bg-black bg-white opacity-[.85] " style="direction: rtl;" >
    
    <!--basic pages -->    
    <div   class="relative   dark:text-gray-200  text-zinc-700  shadow-lg  mx-auto  text-center leading-10 px-3  w-full  overflow-auto scroll-smooth "  >
        <div class="mt-6 "   v-for="(page, index) in pages" :key="index">
        
            <svg  v-if="page.id===first_page" ref="previous_navigator" @click="previous_page2(page.id)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-6 mx-auto w-8 h-8 text-gray-500">
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
                    <h2 class="text-2xl my2"  v-if="ayah.surah_id != 9 || ayah.surah_id != 1 "> بسم الله الرحمن الرحيم </h2>
                </div>
                <span
                :id="ayah.id"  
                :class="{'text-white bg-rose-500 ': check_audio(ayah.surah_id,ayah.ayah_number),}"
                v-click-outside="remove_highlight"
                class="text-2xl   mx-0.5 " >
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
    </div>
          
</div>
</template>

<script>

 import { computed,reactive ,ref} from 'vue'
 import { usePage } from '@inertiajs/inertia-vue3'
 import { Head, Link } from '@inertiajs/inertia-vue3';
 import { Inertia, Method } from '@inertiajs/inertia';
 
 import Ayahshape from './ayahshape.vue';
 import  Chatbox from './Chatbox.vue';
 import ConfirmationModal from './ConfirmationModal.vue';

 let db = require(__dirname + '/../DB');
 import store from '../store.vue';


 


export default  {

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

     // let pages_to_save =_.cloneDeep(this.pages)  
    // db.store(pages_to_save,'qurandata',this.surah.name)
     store.audio_url.value=""   ;
     store.show_audio.value=false ;
     store.audio_surah_number.value=0;
     store.audio_ayah_number.value=0 ;
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
            get_ayah_tafseer:(id)=>{
                let ayah_tafseer ;
                for (const key in this.tafseers) {
                    if (Object.hasOwnProperty.call(this.tafseers, key)) {
                        const single_tafseer = this.tafseers[key];
                        if(id==single_tafseer.ayah_id){ayah_tafseer =single_tafseer.all_myasar_text}
                    }
                }
                return ayah_tafseer
            },
           
            
        }
    },
    computed:{
        screen_is_big(){
            return store.screen_size.value>=900||window.innerHeight >=900  ?true:false;  
        },
        screen_is_small(){
            return store.screen_size.value<=900  && window.innerHeight <=900 ?true:false;  
        },
        tafseer_of_ayah(){
            
            if (this.tafseers!=null) {
                console.log('online')
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
    get_highlighted(){
        if (store.audio_box.value=="closed") {
           return "0"  
        }else{return null}
    },
    remove_highlight(){
    
    },
    previous_page2(current_page_number){
        let my_array=this.additional_previouc_pages
        let previous_surah_number
        this.$refs.previous_navigator[0].style.display="none"  
        let n = this.$refs.previous_navigator.length
        if (n>1) {
           //  this.$refs.previous_navigator[n-1].style.display="none"
        }
        if (store.pages_list.length!==0) {
            let surahs_of_page= store.pages_list.value[current_page_number-1].surahs
            let pages_of_first_surah=store.surahs_list.value[surahs_of_page[0].id-1].pages.length

            if (surahs_of_page.length>1 && pages_of_first_surah>1 ) {
               previous_surah_number=surahs_of_page[0].id
            }else{ previous_surah_number=surahs_of_page[0].id-1}
            
            fetch('/surahs/more_pages/'+previous_surah_number ).then((res)=> res.json()).then((data)=>{
              
                for (const key in data) {
                    if (Object.hasOwnProperty.call(data, key)) {
                        const page = data[key];
                        my_array.push(page)
                    }
                }
                this.additional_previouc_pages=my_array
                console.log(this.additional_previouc_pages)
                setTimeout(() => {
                window.scrollBy(0, -0.75* window.innerHeight) 
                // n = this.$refs.previous_navigator.length
                //console.log(this.$refs.mynavigator[n-1])
                this.$refs.previous_navigator[0].style.display="block"
                }, 300);
               
            })
        }

        
    },
    next_page2(current_page_number){
        let my_array=this.additional_next_pages
        let last_surah
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
               
            }
             console.log("last_surah_pages is " +pages_of_last_surah)
            console.log(store.surahs_list.value[last_surah.id-1])

            let next_surah_number=  last_surah.id+1
            //console.log(store.surahs_list.value[last_surah.id-1].pages)
            fetch('/surahs/more_pages/'+next_surah_number ).then((res)=> res.json()).then((data)=>{
              
                for (const key in data) {
                    if (Object.hasOwnProperty.call(data, key)) {
                        const page = data[key];
                        my_array.push(page)
                    }
                }
                this.additional_next_pages=my_array
                setTimeout(() => {
                window.scrollBy(0, 0.75* window.innerHeight) 
                 n = this.$refs.mynavigator.length
                console.log(this.$refs.mynavigator[n-1])
                this.$refs.mynavigator[n-1].style.display="block"
                }, 300);
               
            })
        }
         
    },
    },
       
    
}
</script>
