import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import createServer from '@inertiajs/server'
import Myapplayout from './Pages/Myapplayout.vue';
import Ayahshape from './Pages/ayahshape.vue';
import  Subcompnent from './Pages/subcompnent.vue';
import  SubMenue from './Pages/SubMenue.vue';
import  SelectingMenue from './Pages/SelectingMenue.vue';
import  SideBar from './Pages/SideBar.vue';
import  Chatbox from './Pages/Chatbox.vue';
import  Test from './Pages/Test.vue';
import Modal from './Pages/Modal.vue';
import ConfirmationModal from './Pages/ConfirmationModal.vue';
import vClickOutside from 'click-outside-vue3'

createServer((page) => createInertiaApp({
  page,
  render: renderToString,
  resolve: name => require(`./Pages/${name}`),
  setup({ app, props, plugin }) {
    return createSSRApp({
      render: () => h(app, props),
    }).use(plugin)
    .directive('clickOutside',vClickOutside.directive)
    .mixin({
        components :{Subcompnent,Myapplayout,Ayahshape,Test,Modal,ConfirmationModal,SubMenue,SideBar,Chatbox,SelectingMenue,},
        })
     
  },
}))