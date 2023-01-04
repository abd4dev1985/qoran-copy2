<template>
    <div v-show="show_side_bar"  class="bg-[#ede8e7] dark:bg-slate-900  mobile:w-full  min-h-full  mobile:absolute mobile:right-0 z-20   border-l-[7px]  dark:border-l-[3px]  border-white dark:border-black">
        <div    class="  flex flex-col content-center  sticky top-0" >
        <div ref="testme" class="w-full h-4  "></div>
            <!--menues & sub menues  --> 

            <!--home page link  -->
            <subMenue v-if="store.screen_size.value<=900" @click="$emit('close_side_bar')"   class="dark:text-rose-400 " >
                        <template #svg  >
                            <Link  href="/">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </Link>
                        </template>
                        <template #title>
                            <Link href="/" @click="show_side_bar=(store.screen_size<=900)?false:true" class="cursor-pointer" >  &nbsp;  &nbsp;   الصفحة الرئيسية </Link>
                        </template> 

                        <template  #menue_items >
                        
                        </template> 
            </subMenue>
            <!--index link   -->
            <subMenue   ref="subMenue" class="dark:text-rose-400" >
                <template #svg  >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </template>
                <template #title>
                    <div  @click="store.fitch_pages_list" class="cursor-pointer " >&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  الفهرس </div>
                </template> 

                <template  #menue_items >
                    <div class=" font-bold dark:text-rose-300 text-rose-500 px-3 py-2 larg:text-right">ترتيب حسب </div>   
                    <div class="flex justify-around py-1 mb-4 font-semibold dark:text-rose-300 text-rose-500">
                        <div @click="indexing_typ='سور'" >
                            <svg  v-show="indexing_typ==='سور'" class="inline-block w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <div class="inline-block">السور</div>    
                        </div>
                        <div @click="indexing_typ='صفحات'">
                            <svg  v-show="indexing_typ==='صفحات'" class="inline-block w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <div class="inline-block">الصفحات</div>   
                        </div>
                        <div @click="indexing_typ='اجزاء'">
                            <svg v-show="indexing_typ==='اجزاء'"  class="inline-block w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <div class="inline-block">الاجزاء</div>   
                        </div>
                    </div>
                    <!--index by surah   -->     
                    <div v-show="indexing_typ==='سور'"  >
                        <div class="text-right px-3  ">اسم السورة </div>
                        <selectingMenue   :list="store.surahs_list.value" :default_value="current_surah"  > 
                                    <template v-slot:selectedoption="{selected}">
                                            {{ selected.name }}
                                    </template>
                                    <template v-slot:listing="{item}">
                                            {{ item.name }}
                                    </template>
                                    <template #default="defaultProps"> 
                                        <div v-if="(ussing_offline_app && store.screen_size.value>900) " class="my-2 bg-rose-600 text-white py-1.5 font-semibold w-14 mx-auto rounded-2xl">
                                            <a v-bind:href="'#'+defaultProps.selected.name">انتقل </a>
                                        </div>
                                        <div v-else  @click="navigate_by_surah(defaultProps.selected)"  class="my-2 bg-rose-600 text-white py-1.5 font-semibold w-14 mx-auto rounded-2xl">
                                            انتقل 
                                        </div>
                                    </template>
                        </selectingMenue >   
                    </div> 
                     <!--index by page   -->
                    <div v-show="indexing_typ==='صفحات'"  >    
                        <div class="text-right px-3">رقم الصفحة </div>    
                        <selectingMenue  :list="list_of_pages"  :default_value="selected_page"  >  
                            <template v-slot:selectedoption="{selected}">
                                            {{ selected.id }}
                            </template>
                            <template v-slot:listing="{item}">
                                            {{ item.id }}
                            </template>
                            <template #default="defaultProps"> 
                                <div   @click="navigate_by_page(defaultProps.selected)"  class="my-2 bg-rose-600 text-white py-1.5 font-semibold w-14 mx-auto rounded-2xl">
                                            انتقل 
                                </div>
                            </template>
                        </selectingMenue >   
                    </div>  
                      <!--index by juz   -->
                    <div v-show="indexing_typ==='اجزاء'"  >
                                <div class="text-right px-3"> رقم الجزء </div>
                                <autoComplete :items="store.juzs.value" :default_value="{ id: 1, juz_id: 1 }" filtered_by="juz_id"  >  
                                    <template #default="defaultProps"> 
                                        <div   @click="navigate_by_juz(defaultProps.selected)"  class="my-2 bg-rose-600 text-white py-1.5 font-semibold w-14 mx-auto rounded-2xl">
                                            انتقل 
                                        </div>
                                    </template>
                                </autoComplete >   
                    </div>  

                </template> 
            </subMenue>
            <!--marks menue  -->
            <subMenue ref="subMenue"  class="dark:text-rose-400" >
                        <template #svg  >
                            <svg class="w-6 h-6  " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        </template>

                        <template #title>
                            <a class="cursor-pointer font-semibold" >  علامات مرجعية  </a>
                        </template> 

                        <template  #menue_items >
                            <div v-for="(mark, index) in store.markes.list " :key="index" class="p-1 text-right">
                                <div  class="p-1 font-semibold text-rose-400 " >  اية رقم {{mark.ayah_number}} سورة {{mark.surah_name}} </div>
                                <div @click="close_side_bar" class="inline-block  ">
                                    <Link :href="mark.url" >   {{mark.body}} </Link>
                                </div>
                                <div   @click="delete_mark(mark.id)"  class="inline-block mobile:mx-5 text-xs font-bold text-rose-400 " > حذف </div>
                            </div>
                        </template> 
                        

            </subMenue>
            <!--sound menue  -->
            <subMenue ref="subMenue" class="dark:text-rose-400" >
                <template #svg  >
                    <svg class=" w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>       
                </template>

                <template #title>
                    <a class="cursor-pointer" > &nbsp;  &nbsp;  تلاوة  </a>
                </template> 

                <template  #menue_items >
        
                    <selectingMenue  :list="persons"  :default_value="current_recitation"  >  
                        <template v-slot:selectedoption="{selected}">
                            {{ selected.name }}
                        </template>
                        <template v-slot:listing="{item}">
                                    {{ item.name }}
                        </template>
                        <template #default="defaultProps"> 
                            <div   @click="choose_recitation(defaultProps.selected.value)"  class="my-2 bg-rose-600 text-white py-1.5 font-semibold w-14 mx-auto rounded-2xl">
                                حفظ 
                            </div>
                        </template> 
                    </selectingMenue >   
                    
                </template> 
            </subMenue>

            <!--tafseers menue  -->
            <subMenue ref="subMenue" class="dark:text-rose-400" >
                <template #svg  >
                    <svg class=" w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>       
                </template>

                <template #title>
                    <a class="cursor-pointer" > &nbsp;  &nbsp;  تفسير  </a>
                </template> 

                <template  #menue_items >
                    <selectingMenue  :list="available_tafseers"  :default_value="current_tafseer"  >  
                        <template v-slot:selectedoption="{selected}">
                            {{ selected.name }}
                        </template>
                        <template v-slot:listing="{item}">
                                    {{ item.name }}
                        </template>
                        <template #default="defaultProps"> 
                            <div   @click="choose_tafseer(defaultProps.selected.value)"  class="my-2 bg-rose-600 text-white py-1.5 font-semibold w-14 mx-auto rounded-2xl">
                                حفظ 
                            </div>
                        </template> 
                    </selectingMenue >   
                    
                </template> 
            </subMenue>

            <!--download offline app  -->
            <subMenue ref="subMenue"  @click="close_side_bar"   class="dark:text-rose-400" >
                <template #svg  >
                    <Link  href="/download">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </Link>
                </template>
                <template #title>
                    <Link href="/download"  class="cursor-pointer" > offline تحميل تطبيق القران </Link>
                </template> 

                <template  #menue_items >
                
                </template> 
            </subMenue>
        
            <!--offline search  -->
            <subMenue ref="subMenue"    class="dark:text-rose-400" >
                <template #svg  >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </template>
                <template #title>
                    <div   class="cursor-pointer" >     البحث </div>
                    <input ref="input_search" type="text"   >
                    <div></div>
                    <button @click="set_input_search" >عرض النتائج </button>
                    <div></div>
                </template> 
                <template  #menue_items >
                    <div   v-for="(ayah, index) in searched_ayahs" :key="index">{{ayah.body}}</div>
                </template> 
            </subMenue>
        
        </div>   


    </div>
    

</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'

import { nextTick } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import  SubMenue from './SubMenue.vue';
import  SelectingMenue from './SelectingMenue.vue';
import  AutoComplete from './AutoComplete.vue';
import store from '../store.vue';
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
let db = require(__dirname + '/../DB');

 export default ({

        mounted() {
        // Register an event listener when the Vue component is ready
        window.addEventListener('resize', this.onResize)
        

        },

        props: {
            title: String,
            fortest:String ,
            show_side_bar:Boolean,
           
        },
        
        components: {
            SubMenue,  Head, Link, SelectingMenue,AutoComplete,
        }, 
        emits: ['BigScreen','close_side_bar','open_download_modal']  
        ,
        setup() {
            let selected_page = computed(()=>store.pages_list.value[store.current_page.value-1])
            let list_of_pages=computed(()=>store.pages_list.value)
            let current_surah = computed(() => usePage().props.value.surah)
            let letters = computed(() => usePage().props.value.letters)
            let pages = computed(() => usePage().props.value.pages)
            
            return {
                store,
                persons:[
                    { value:'Rifai',name:' رفاعي'}, { value:'Alafasy',name:'العفاسي'},{ value:'Sudais',name:'السديس'},{ value:'Jibreel',name:'جبريل'},{ value:'AbdulBaset/Mujawwad',name:'عبد الباسط'}
                ],
                available_tafseers:[
                    { value:'all_myasar_text',name:' الميسر'}, { value:'jalalayn',name:'الجلالين'},{ value:'baghawi',name:'البغوي'}
                ],
                current_surah ,
                pages,
                letters,
                selected_page,
                list_of_pages,

            }       
        },
        data() {
            return {
                 indexing_typ:"سور",
                 input_search:"ابحث عن ",
                 search:false,
                 ussing_offline_app:window.location.href.includes('all')? true:false
            }
        },
        computed:{
            current_recitation(){
                let recitation =this.persons.filter( (person)=>{
                    return person.value === store.recitation.value   
                })
                return recitation[0]
            },
            current_tafseer(){
                 let current_tafseer=this.available_tafseers.filter((tafseer)=>{
                    return tafseer.value===store.tafseers.type
                 })   
                return current_tafseer[0]

            },
            searched_ayahs(){
                let searched_ayahs=[] ;
            
                if (this.search) {
                    for (let key in this.pages) {
                        if (Object.hasOwnProperty.call(this.pages, key)) {
                            let ayahs = this.pages[key].ayahs;
                            ayahs.forEach(ayah => {
                                if (ayah.body.replace(/ْ|َ|ِ|ُ|~|ً|ٌ|ٍ|ّ|َّ|ْ|ُّ|ِّ/g, "").includes(this.input_search)) {
                                    searched_ayahs.push(ayah)     
                                }
                            });  
                        }
                    }
                return searched_ayahs
                } else {
                    return searched_ayahs
                }    
               
            },
        },
      
        methods: {
           
            close_side_bar(){
                this.$refs.subMenue.close() 
                this.$refs.testme.click()
                if (store.screen_size.value<900) {
                    this.$emit('close_side_bar')
                }
        
            },
            download_offline_app(){
                console.log('side')
                this.$emit('open_download_modal')
                this.close_side_bar()
            },
             navigate_by_surah(surah){  
                
                if (window.location.href.includes('all')) {
                    console.log("you are ussing offline app")
                    //console.log(surah.pages[0].id)
                    store.current_page.value=surah.pages[0].id
                    this.close_side_bar()
                    return true
                }

                let url="/surahs/"+surah.id;
               // console.log(window.location.href)
                this.close_side_bar()
                Inertia.visit(url,{
                    method:'get',
                    data:{
                       // page:this.last_page+1,
                    },
                })  
            },
             navigate_by_page(page){
                this.close_side_bar()
                if (window.location.href.includes('all')) {
                    store.current_page.value=page.id
                    return true
                }
                let url
                if (page.surahs.length>1) {
                    url="/surahs/"+page.surahs[1].id +"#"+page.id
                } else {
                    url="/surahs/"+page.surahs[0].id+"#page"+page.id  
                }
                Inertia.visit(url,{
                    method:'get',
                    data:{
                        page:page.id,
                    },
                })  
              
            },
            navigate_by_juz(juz){
                this.close_side_bar()
                let page=store.pages_list.value[juz.id-1]
                this.navigate_by_page(page)    
            },
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
                   let decodedd = await ctx.decodeAudioData(arraybuffer)
                   audio = decodedd;
                   console.log(audio);
                   return audio ;
                }
                get_data().then(
                    (audio)=>{
                        var playsound = ctx.createMediaElementSource(html_media_node);
                        playsound.srcObject= audio;
                        playsound.load();
                        playsound.play();
                        console.log(source) 
                            console.log(source.srcObject)  


                        //const playsound =ctx.createBufferSource();
                       // playsound.buffer= audio ;
                        //playsound.connect(ctx.destination);
                       //playsound.start(ctx.currentTime);
                    }
                    );
            },
              delete_mark(ayah_id){
                store.remove_mark(ayah_id)      
            },
            choose_recitation(selected){
                this.close_side_bar()
                store.recitation.value=selected
                localStorage.recitation=selected
                console.log(selected)
                store.audio_box.value='closed'
                store.show_audio.value=false
                store.audio_surah_number.value=0;
                store.audio_ayah_number.value=0 ;
               // this.close_side_bar()
            },
             choose_tafseer(selected){
                this.close_side_bar()
                localStorage.tafseer_type=selected
                store.tafseers.type=selected
                console.log('type is  '+ store.tafseers.type)
            
               // this.close_side_bar()
            },

            set_input_search(){
              this.input_search =this.$refs.input_search.value
              this.search=true;
              
            }

           
        }
    })

</script>