require('./bootstrap');
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Myapplayout from './Pages/Myapplayout.vue';
import Ayahshape from './Pages/ayahshape.vue';
import  Subcompnent from './Pages/subcompnent.vue';
import  SubMenue from './Pages/SubMenue.vue';
import  SelectingMenue from './Pages/SelectingMenue.vue';
import  AutoComplete from './Pages/AutoComplete.vue';
import  SideBar from './Pages/SideBar.vue';
import  Chatbox from './Pages/Chatbox.vue';
import  Test from './Pages/Test.vue';
import Modal from './Pages/Modal.vue';
import ConfirmationModal from './Pages/ConfirmationModal.vue';
import vClickOutside from 'click-outside-vue3'
createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .directive('clickOutside',vClickOutside.directive)
      .mixin({
        methods: { route },
        components :{Subcompnent,Myapplayout,Ayahshape,Test,Modal,ConfirmationModal,SubMenue,SideBar,Chatbox,SelectingMenue,AutoComplete,},
        })
      .mount(el)
  },
})

InertiaProgress.init();
