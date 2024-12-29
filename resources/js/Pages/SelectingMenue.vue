
<template>
  <div class="text-gray-800 dark:text-gray-100">
  <Listbox as="div" v-model="selected">

    <ListboxLabel class="block text-sm  my-2 font-medium text-gray-700 ">  </ListboxLabel>
    <div class="mt-1 relative">
      <ListboxButton class="relative w-full bg-white border dark:bg-slate-700 border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        <span class="flex items-center">
          <span class="mx-auto text-gray-800  dark:text-rose-300 font-semibold text-right block truncate">
             <slot name="selectedoption" :selected="selected" ></slot>
           
          </span>
          <div  class="mx-4">
            <svg class="w-4 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
            <svg class="w-4 h-3 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </div>
        </span>
        <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
        </span>
      </ListboxButton>

      <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-56 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm text-center">
          <ListboxOption as="template" v-for="(item, index) in list" :key="index" :value="item" v-slot="{ active, selected }">
            <li :class="[active ? 'text-white bg-rose-600 ' : 'text-gray-900 dark:text-rose-300 dark:bg-slate-700', 'font-semibold cursor-default select-none relative py-2 pl-3 pr-9']">
              <div class="flex items-center ">
                  <span :class="[selected ? 'font-semibold' : 'font-normal', 'mx-auto block truncate']">
                    <slot name="listing" :item="item" ></slot>
                 </span>
              </div>

              <span v-if="selected" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
              </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </div>
  </Listbox>
  <div class="my-2 py-2 "> <slot :selected="selected" ></slot> </div>
  </div>
</template>


<script setup>
import { ref } from 'vue'
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'

const props = defineProps(['list','default_value'])

const selected = ref(props.default_value)




</script>
