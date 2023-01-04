<template>

  <div v-if="open" class="inline-block absolute -top-12 right-1 bg-yellow-400 border-2">
      <svg class="w-6 h-6 inline-block mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
      <svg class="w-6 h-6 inline-block mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>

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
        open: true, 
        }
    },
    methods :{

    
    
   
    },
       
    
}
</script>