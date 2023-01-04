<template>
       <div class=" bg-qurancover bg-cover  max-w-max bg-no-repeat">
            <div class="  dark:bg-black bg-white opacity-[.8]  dark:opacity-[.85] b py-4 justify-center flex flex-wrap flex-row-reverse  ">
                <Link  v-bind:href="route('surahs.show',{id:surah.id})" v-for="(surah, index) in surahs" :key="index"
                class="block text-opacity-100 w-16 py-2 m-2 text-black  dark:text-rose-400 text-center  "  >
                    {{surah.name}}
                </Link>
            </div>
       </div>

</template>
<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Myapplayout from './Myapplayout.vue';
    export default defineComponent({
        layout: Myapplayout 
        ,
        components: {
            Head,
            Link,
        },

        props: [
        'surahs',
        ],
    })
</script>