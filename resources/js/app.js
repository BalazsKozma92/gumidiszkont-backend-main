import { createApp } from 'vue'
import App from './App.vue'
import store from './store/index'
import router from './router/index'
import './index.css'
import 'flowbite'

createApp(App)
    .use(store)
    .use(router)
    .mount('#app')
