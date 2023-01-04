<script  >


import { ref, computed,reactive,onMounted, } from 'vue';
import { Inertia } from '@inertiajs/inertia';
let db = require(__dirname + '/DB');

let count = ref( 0 )

let audio_surah_number= ref(0)

let audio_ayah_number= ref(0)

let recitation= ref('Alafasy')
recitation.value = (localStorage.recitation !=null) ? localStorage.recitation:recitation.value

let current_page = ref( 1)

let audio_box = ref('closed') 
let show_audio = ref(false) 
let screen_size= ref( window.innerWidth)
let globa_ayah_id=ref(0)
let show_tafseer = ref(false) 
let audio_url = ref('')
let markes=reactive({list: db.get('qurandata','url-list'),})

// tafseers
localStorage.tafseer_type=( localStorage.tafseer_type==undefined)?'all_myasar_text':localStorage.tafseer_type
let tafseers=reactive({type:localStorage.tafseer_type,body:[],});

db.get('qurandata',tafseers.type,(data)=>{
  tafseers.body=data
 })
 
 
let tafseers_all_myasar= ref([])
db.get('qurandata','tafseers_all_myasar',(data)=>{
  tafseers_all_myasar.value=data
 })

let globa_ayah_body = ref('بسم الله ')

let obj={name:"cahnge",age:36}
let mytest= ref(obj)
let change_name=function(){
  mytest.value.name= "robi"
}
let ayah_tafseer_id = ref("1");

 let get_ayah_tafseer=function(){
  if (tafseers_all_myasar.value.length>0) {
     return tafseers_all_myasar.value[ayah_tafseer_id.value-1].all_myasar_text
  }
 
 }
//list of surahs 
let surahs_list=  ref([])
db.get('qurandata','surahs_list',(data)=>{
      surahs_list.value = data
      // if db dose not have surahs_list empty make fecth request for new data and save it in db  ,
      if (data.length==0) {
        fetch('/surahs_list').then((res)=>res.json()).
        then((new_data)=>{
            store.surahs_list.value=new_data
            db.store(new_data,'qurandata','surahs_list')
        })
      }
})

//list of pages 
let pages_list=ref([])
db.get('qurandata','pages_list',(data)=>{
      pages_list.value = data
      // if db dose not have pages_list empty make fecth request for new data and save it in db  ,
       if (data.length==0) {
        fetch('/pages_list').then((res)=>res.json()).
        then((new_data)=>{
            store.pages_list.value=new_data
            db.store(new_data,'qurandata','pages_list')
        })
      } 
})

//list of juzs 
let juzs=ref([])
db.get('qurandata','juzs_list',(data)=>{
      juzs.value = data
      // if db dose not have juzs_list or empty then  make fecth request for new data and save it in db  ,
       if (data.length==0) {
        fetch('/juzs').then((res)=>res.json()).
        then((new_data)=>{
            store.juzs.value=new_data
            db.store(new_data,'qurandata','juzs_list')
        })
      } 
})






/*
let fitch_pages_list=()=>{
  fetch('/pages_list').then((res)=> res.json()).then((data)=>{
    console.log('fetching pages list')
    pages_list.value=data
  })
}
*/




let set_audio_surah_number =function(surah_number) { 
  audio_surah_number.value = surah_number
}
let set_audio_ayah_number =function(ayah_number) { 
  audio_ayah_number.value = ayah_number
}
let set_globa_ayah_body =function(body) { 
  globa_ayah_body.value = body
}


let get_url =function(surah_number,ayah_number){
  let part1 ;
  let part2 ;
  audio_surah_number.value=surah_number
  audio_ayah_number.value =ayah_number
  // get  part1 depending on surah_number digits
  switch (surah_number.toString().length) {
    case 1:  part1 = "00";  break;
    case 2:  part1 = "0";   break;
    case 3:  part1 = "";
  }
  part1 = part1 + surah_number ;
  // get  part2 depending on ayah_number digits
  switch (ayah_number.toString().length) {
    case 1:  part2 = "00";    break;
    case 2:  part2 = "0";     break;
    case 3:  part2 = "";
  }  
  part2 = part2 + ayah_number ;
  // final url
  audio_url.value= 'https://download.quranicaudio.com/verses/'+recitation.value+'/mp3/'+part1+part2+'.mp3';

  show_audio.value=true;




}
 

let increas =()=>{
    count.value++ 
    audio_ayah_number.value++
} 
let decreas =()=>{
   count.value--
   console.log(count.value)  
} 

let add_mark= (surah_id,ayah_number,ayah_id,ayah_body,page,surah_name)=>{
    let url="/surahs/"+surah_id+"?page="+page+"#"+ayah_id
    let obj_url =[{surah_id:surah_id,ayah_number:ayah_number,id:ayah_id,url:url,body:ayah_body,surah_name :surah_name}]
    db.store(obj_url,'qurandata','url-list')
    markes.list=db.get('qurandata','url-list')
}

let remove_mark=function(ayah_id){
  //remove mark frome markes.list array objects
  let index=markes.list.findIndex((marke)=>{
  return marke.id===ayah_id })
  markes.list.splice(index, 1); 
 
  // remove mark frome indexed db
  db.destroy('qurandata','url-list',ayah_id)

}


let store ={
    count:count,
    current_page:current_page,
    audio_box:audio_box,
    show_audio:show_audio,
    show_tafseer:show_tafseer,
    globa_ayah_body:globa_ayah_body,
    globa_ayah_id:globa_ayah_id,
    audio_url:audio_url,
    recitation:recitation,
    audio_surah_number:audio_surah_number,
    audio_ayah_number:audio_ayah_number,
    set_audio_surah_number:set_audio_surah_number,
    set_audio_ayah_number:set_audio_ayah_number,
    set_globa_ayah_body:set_globa_ayah_body,
    get_url:get_url,
    ayah_tafseer_id:ayah_tafseer_id,
    get_ayah_tafseer:get_ayah_tafseer,
    increas:increas ,
    decreas:decreas,
    screen_size:screen_size,
    add_mark:add_mark,
    remove_mark:remove_mark,
    markes,
    tafseers,
    tafseers_all_myasar,
    mytest:mytest,
    change_name:change_name,
    pages_list,
    surahs_list,
    juzs,

} 
export  default   store ;
    
</script>