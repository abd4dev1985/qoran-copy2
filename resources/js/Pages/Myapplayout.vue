<template>
    <div  class="w-full   relative   dark:bg-[#130f0e]  dark:text-white  text-gray-800 shadow-xl "  >
        <nav  class="flex sticky top-0 justify-start  items-center larg:h-[60px] h-[50px] z-30  bg-white dark:bg-[#130f0e]  overflow-hidden">   
            <svg @click=" show_side= !show_side " class=" block larg:hidden w-7 h-10 absolute  top-2 right-2 stroke-red-400 " fill="none"  viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>        
            <img class="dark:inline hidden larg:w-36 larg:h-14  w-28 h-10 absolute top-1 larg:top-0 right-4 mobile:right-16 mobile:top-1 " src="/img/redqurandark.jpg" alt="">
            <img class="dark:hidden  larg:w-36 larg:h-14  w-28 h-10 absolute top-1 larg:top-0   right-4 mobile:right-16 " src="/img/redquran.jpg" alt="">
            <!-- search  icon -->  
            <svg @click="open_search_bar" class="larg:hidden   bg-clip-text dark:bg-gray-800 mx-3 w-5 h-5 text-red-400  fill-white dark:fill-gray-800"  stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>

             <!-- select dark or light theme -->
            <div class="mx-3 "  @click="change_theme()" >
                <svg  v-if="theme==='dark'"  viewBox="0 0 24 24" fill="black" class="w-5 h-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" class="fill-black stroke-red-400"></path><path d="M12 4v1M17.66 6.344l-.828.828M20.005 12.004h-1M17.66 17.664l-.828-.828M12 20.01V19M6.34 17.664l.835-.836M3.995 12.004h1.01M6 6l.835.836" class="stroke-red-400"></path></svg>
                <svg   v-if="theme==='light'"  viewBox="0 0 24 24" fill="none" class="w-5 h-5"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.715 15.15A6.5 6.5 0 0 1 9 6.035C6.106 6.922 4 9.645 4 12.867c0 3.94 3.153 7.136 7.042 7.136 3.101 0 5.734-2.032 6.673-4.853Z" class="fill-white"></path><path d="m17.715 15.15.95.316a1 1 0 0 0-1.445-1.185l.495.869ZM9 6.035l.846.534a1 1 0 0 0-1.14-1.49L9 6.035Zm8.221 8.246a5.47 5.47 0 0 1-2.72.718v2a7.47 7.47 0 0 0 3.71-.98l-.99-1.738Zm-2.72.718A5.5 5.5 0 0 1 9 9.5H7a7.5 7.5 0 0 0 7.5 7.5v-2ZM9 9.5c0-1.079.31-2.082.845-2.93L8.153 5.5A7.47 7.47 0 0 0 7 9.5h2Zm-4 3.368C5 10.089 6.815 7.75 9.292 6.99L8.706 5.08C5.397 6.094 3 9.201 3 12.867h2Zm6.042 6.136C7.718 19.003 5 16.268 5 12.867H3c0 4.48 3.588 8.136 8.042 8.136v-2Zm5.725-4.17c-.81 2.433-3.074 4.17-5.725 4.17v2c3.552 0 6.553-2.327 7.622-5.537l-1.897-.632Z" class="fill-red-400"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M17 3a1 1 0 0 1 1 1 2 2 0 0 0 2 2 1 1 0 1 1 0 2 2 2 0 0 0-2 2 1 1 0 1 1-2 0 2 2 0 0 0-2-2 1 1 0 1 1 0-2 2 2 0 0 0 2-2 1 1 0 0 1 1-1Z" class="fill-red-400"></path></svg>
            </div>  
            
             <!-- show index of surahs -->
            <div class="mx-3  mobile:hidden " >
                <svg xmlns="http://www.w3.org/2000/svg" class="  hidden  h-5 w-6 " fill="none" viewBox="0 0 24 24" stroke="#f87171">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <Link href="/" class=" align-top text-red-400  text-sm font-semibold  " >الرئيسية  </Link>
            </div>
        
             <!-- install app button -->
            <div @click="insatllApp" class="text-red-400 mx-3  mobile:hidden  cursor-pointer ">
                <svg  class="hidden  w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span  class="align-top text-red-400 text-sm  font-semibold ">تنزيل </span>
            </div>
              <!-- search bar for disktop -->   
            <div class=" mobile:hidden mx-12 border-2 border-red-400 bg-gray-50 dark:bg-gray-800 h-7  w-40 flex flex-row-reverse rounded-xl shadow-sm">
                <svg class="bg-clip-text  dark:bg-gray-800 mr-0.5 w-8 h-8 text-red-400 self-center fill-white dark:fill-gray-800"  stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input v-model="search"  @keyup.enter="makeSearch()"
                class="w-full text-xs dark:bg-gray-800  bg-gray-50 text-red- placeholder-red-400 place-content-end text-right rounded-xl shadow-sm outline-none " placeholder="البحث عن ">
            </div>  
            
            
        </nav>
         <!-- search bar for mobile  -->   
         <div v-if="show_mobile_search_bar" v-click-outside="close_search_bar" class=" larg:hidden  border-2 border-rose-400 bg-gray-50 dark:bg-gray-800 h-11 mx-auto w-full  flex flex-row-reverse  items-center rounded-sm shadow-sm">
            <svg class=" bg-clip-text dark:bg-gray-800 mx-3 w-7 h-7 text-red-300  fill-white dark:fill-gray-800"  stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input ref="search_input" v-model="search"  @keyup.enter="makeSearch()"
            class="w-8/12 grow text-base text-gray-500 dark:text-gray-100 dark:bg-gray-800  bg-gray-50  placeholder-red-300 place-content-end text-right font-semibold  outline-none " placeholder="البحث عن">
            <svg  @click="makeSearch()"  fill="none" viewBox="0 0 24 24" strokeWidth="6" stroke="#6c7381" class="w-8 h-8 mx-1 ">
                <path strokeLinecap="round" strokeLinejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
            </svg>
        </div>   
         <!--search result modal -->
        <confirmation-modal :show="showmodal" @close="showmodal= false ; "  >
            <template #title>
                <div class=" text-right w-full"> نتائج البحث عن (                 
                    {{search}} )
                </div>
            </template>

            <template #content>
                 
                <div v-for="(result, index) in search_results" :key="index" class="text-right w-full" >
                    <h3 class=" w-full  mt-2 mobile:mt-1 text-xl mobile:text-base  text-red-500" >سورة {{ result.surah.name}} - اية رقم {{result.ayah_number}} </h3>
                    <Link  @click="showmodal = false"  v-bind="{ href: '/surahs/'+ result.surah.id+'#'+result.id }"  class="mobile:text-sm w-full">
                    {{ result.body}}
                    </Link>  
                </div> 
            </template>

            <template #footer>
                <button @click="showmodal = false ; ">
                  اغلاق
                </button>
              
                
            </template>
        </confirmation-modal>

         <!--download modal -->
        <confirmation-modal :show="show_download_modal" @close="show_download_modal= false ; "  >
            <template #title>
                <div class=" text-right w-full text-2xl">                 
                     تنزيل تطبيق نورالقران   
                </div>
            </template>

            <template #content> 
                <div  class="text-right dark:text-gray-100 w-full " >
                    يمكنك الان قراءة و سماع السور و الايات مع التفاسير دون ضرورة 
                    الاتصال بالانترنت 
                </div> 
                <div  class="text-right dark:text-gray-100  w-full" >
                   Android,IOS,Windows,Linux  يعمل على جميع انظمة التشغيل 
                </div> 
            </template>

            <template #footer>
                <button @click="show_download_modal = false ; ">
                  اغلاق
                </button>
              
                
            </template>
        </confirmation-modal>
    

        <div class="  grid grid-cols-5  min-h-full  relative">

             <!-- Page Content -->
            <main ref="main" class="col-span-4 mobile:col-span-5">
                <!--
                    <subcompnent class="" v-if="surah !='فهرس'" :surah="surah"   >
                    </subcompnent >   
                -->
                <slot></slot>
            </main>
            
             <!-- side bar  -->
            <Transition name="slide-side-bar" >
            <sideBar  :show_side_bar='show_side' @close_side_bar="show_side=false"
             @open_download_modal="open_download_modal" > 
            </sideBar   >
            </Transition>  

       </div>  
      
        <!--audio modal -->
        <div class="bg-emerald-400 hidden" @click="get_ayahe_sound" >download</div>
      

    </div>
</template>

<script>
   
//define audio context  for manging audio
const ctx = new AudioContext ;

//create  installApp event  
const installApp  = new Event('installApp');
   

//display InstallPrompt when installApp event fired

    // use event handler for processing beforeinstallprompt event
        window.addEventListener("beforeinstallprompt",function(beforeInstallPromptEvent) {
            beforeInstallPromptEvent.preventDefault();
            // Shows InstallPrompt after firing "installAPP" by btn  EVENT
            window.addEventListener("installApp", function(e) {
                beforeInstallPromptEvent.prompt()
                .then(function(value) {console.log(value) })      
            }); 
        });
    

    import { computed ,nextTick} from 'vue'
    import { Inertia } from '@inertiajs/inertia';
    import { usePage } from '@inertiajs/inertia-vue3'
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import  Subcompnent from './subcompnent.vue';
    import  SubMenue from './SubMenue.vue';
    import  SideBar from './SideBar.vue';
    import  Test from './Test.vue';
    import ConfirmationModal from './ConfirmationModal.vue';
    import {  Transition } from 'vue'   
    import store from '../store.vue';
    let db = require(__dirname + '/../DB');
   
    export default ({
    
        mounted() {
        // Register an event listener when window resized
        window.addEventListener('resize', this.onResize)
      
      



        },

        props: {
            title: String,
            search:String,
            fortest:String ,
        },
        components: {
            Head,
            Link,
            Subcompnent,
            Test,
            ConfirmationModal,
            SubMenue,
            SideBar,
        }, 
        emits: ['BigScreen','download_from_cache','testemit',],  
        setup() {
            let surah = computed(() => usePage().props.value.surah)
            let search_results = computed(() => usePage().props.value.search_results)
            //let show_side_bar =computed(()=>screen.width >700?true:false) 
            return { surah ,search_results, }
        },
    
        data() {
            return {
                
                show_mobile_search_bar:false,
                showmodal :false,
                show_download_modal:false,
                theme:localStorage.theme ,
                show_side : window.innerWidth >900?true:false,
                menues:{
                    tafseer:{
                        title:"تفاسير " ,
                        svg:' <svg class="mr-4 w-6 h-6 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                        items:{
                            item1 :{name:'تفسير كامل القران ',method:'get_all_tafseer'},
                            item2 :{name:'تفسير اية  ',method:'get_all_tafseer'}    
                              }
                            },

                    sound:{
                        title:"مقاطع صوتية  " ,
                        svg:' <svg class="mr-4 w-6 h-6 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                        items:{
                            item1 :{name:'تنزيل مقطع سورة ',method:'get_all_tafseer'},
                            item2 :{name:'تنزيل مقطع اية  ',method:'get_all_tafseer'}    
                              }
                            },
                },    
            }
        },

        methods: {
            makeSearch(){
                if ( this.search  && this.search != " " && this.search != "  " ) {
                    console.log(this.search);
                    this.showmodal=true;
                    this.$inertia.reload({                
                        data:{text:this.search} } ); 
                }
             //this.$inertia.reload(this.route('surahs.index', {search: this.search})); 
            },
            insatllApp(event){ 
                // firing "installAPP" EVENT   
                window.dispatchEvent(installApp);
                
               event.target.hidden=false ;       
            },
            open_search_bar(){
                this.show_mobile_search_bar=true
                nextTick(()=>{
                    let search_input = this.$refs.search_input
                    search_input.focus() 
                })
                
            },
            close_search_bar(){
                this.show_mobile_search_bar=false
            },
            change_theme(){
                
                if ( this.theme==='light' ) {
                    localStorage.theme = 'dark'
                    this.theme='dark'
                    document.documentElement.classList.add('dark')
                }
                 else  {
                    localStorage.theme = 'light'
                    this.theme='light'
                    document.documentElement.classList.remove('dark');
                }
            },
            onResize(){
                this.show_side =  window.innerWidth >900?true:false 
                store.screen_size.value= window.innerWidth   
            },
            // tafseer api 
            get_all_tafseer(){
                console.log( "it work ");
            },
            // mp3  api 
            get_ayahe_sound(){
                const html_media_node=document.getElementById("html_media");
               
                let audio ;
               async function get_data()
               { 
                   let my_response = await fetch('https://download.quranicaudio.com/verses/Alafasy/mp3/114006.mp3');
                   let arraybuffer= await my_response.arrayBuffer();
                   let audio = await ctx.decodeAudioData(arraybuffer)
                  
                   console.log(audio);
                   return audio ;
                }
                get_data().then(
                    (audio)=>{
                        //var playsound = ctx.createMediaElementSource(html_media_node);
                       // playsound.srcObject= audio;
                       // playsound.load();
                       // playsound.play();
                       // console.log(source) 
                           // console.log(source.srcObject)  


                        const playsound =ctx.createBufferSource();
                        playsound.buffer= audio ;
                        playsound.connect(ctx.destination);
                       playsound.start(ctx.currentTime);
                    }
                    );
            },
            open_download_modal(){
                this.show_download_modal=true
            },
            play_aya(){
                console.log("worked")
            },

        }
    })
 
</script>





<style>
.slide-side-bar-enter-active {
  transition: all 0.5s ease-in;
}

.slide-side-bar-leave-active {
  transition:  all 0.5s ease-in;
}

.slide-side-bar-enter-from,
.slide-side-bar-leave-to {
  transform: translateX(300px);
 
}

</style>