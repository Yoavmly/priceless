import { createApp } from 'vue'
import App from './App.vue'
import store from './store'
import router from './router'
import './index.css'


import { library } from '@fortawesome/fontawesome-svg-core'
import {fas, faThumbTack} from '@fortawesome/free-solid-svg-icons'
import {faCaretUp} from "@fortawesome/free-solid-svg-icons";
import {faCaretDown} from "@fortawesome/free-solid-svg-icons";
import {faComment} from "@fortawesome/free-solid-svg-icons";
import { far } from '@fortawesome/free-regular-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
library.add(faThumbTack)
library.add(faCaretUp)
library.add(faCaretDown)
library.add(faComment)
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import ClipLoader from 'vue-spinner/src/ClipLoader.vue';
library.add(fas, far, fab)

import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

createApp(App)
    .use(store)
    .use(router)
    .use(Toast)
    .component('font-awesome-icon', FontAwesomeIcon)
    .component('clip-loader' , ClipLoader)
    .mount('#app')
