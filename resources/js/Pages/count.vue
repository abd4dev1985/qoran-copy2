
<script setup >

import store from '../store.vue';
 
</script>
<template>

<div>{{store.count}}</div>
  <button @click="store.increas">
   increment
  </button>
  <p></p>
  <button @click="store.decreas">
   decreas
  </button>
  <div>surah number  {{store.audio_surah_number}}</div>
   <div>ayah number {{store.audio_ayah_number}}</div>
   <button  @click="store.set_audio_surah_number(2)" >set surah number</button>
</template>