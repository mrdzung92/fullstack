import '@layui/layer-vue/lib/index.css';
import 'vant/lib/index.css';
import './assets/main.scss'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { library } from "@fortawesome/fontawesome-svg-core";
import { far } from '@fortawesome/free-regular-svg-icons'
import { faEarthAmerica, faMoon, faChevronLeft, faUser, faLock, faShield, faUsers, faMagnifyingGlass, faList, faChevronRight, faRotate } from "@fortawesome/free-solid-svg-icons";
library.add(far, faEarthAmerica, faMoon, faChevronLeft, faUser, faLock, faShield, faUsers, faMagnifyingGlass, faList, faChevronRight, faRotate)
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Vant from 'vant';
import apiService from './services/api/apiService'
import io from 'socket.io-client'
const socket = io('http://localhost:3000')
const app = createApp(App)

app.config.globalProperties.$wedApi = apiService
app.config.globalProperties.$socket = socket
app.component("font-awesome-icon", FontAwesomeIcon);
app.use(Vant)
app.use(router)
app.mount('#app')
