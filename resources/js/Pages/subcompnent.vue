<template>
  
        <h1 v-if="surah == 'فهرس'" class="text-2xl text-center px-4  py-3 top-20 w-full ">
       فهرس السور 
      </h1>

      <h1 v-else class="text-2xl mobile:text-lg text-center px-4  py-2 top-14 w-full  ">
         سورة {{surah.name}} 
      </h1>
   
</template>
<script>
export default{
 props:[
        'name','number','surah'
    ],
}
</script>