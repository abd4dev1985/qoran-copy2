<template>

  <div class="py-4 text-rose-500 border-gray-400 border-dotted border-b-2 ">
        <div  class="w-full  relative flex flex-row-reverse larg:justify-around justify-center  larg:gap-0  gap-8 align-middle ">  
            
            <slot  @click="open= !open" name="svg">
            </slot>  

            <div  @click="open= !open" class="  larg:text-sm text-base text-right min-w-fit font-semibold">
                <slot name="title">
                </slot>  
            </div> 

            <svg   @click="open= !open" :class="{' -rotate-90': open }"  class=" w-5 h-5 place-self-center justify-self-end transform " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>                                  
        
        </div>
        <div v-if="open" v-click-outside="close">
            <Transition name="slide-fade" >
                <div  class="flex text-left flex-col justify-around items-center  mt-1  ">
                    <div  class=" w-full text-center text-sm  py-2 ">
                        <div  class=" w-11/12 my-3  bg-[#f4f2f1] dark:bg-slate-700 mx-auto rounded-xl text-gray-800 dark:text-gray-200 ">
                            <slot    name="menue_items">

                            </slot>
                        </div> 
                    </div>   
                </div> 
            </Transition>        
        </div>
    </div>

</template>

<script>
 import { Head, Link } from '@inertiajs/inertia-vue3';
 import { Inertia } from '@inertiajs/inertia';
import {  Transition } from 'vue' 


 const axios = require('axios').default;


 



export default  {
    props:{
    items:Object,    

    },
    components: {
            Head, Link,
        },
   
    data() {
        return {
        open: false, 
        }
    },
    methods :{
        close(){
            this.open = false
            console.log("hrer")
            console.log(this.open)
        },
    
    
   
    },
       
    
}
</script>
<style>
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.4s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translatey(-15px);
  opacity: 0;
}

</style>