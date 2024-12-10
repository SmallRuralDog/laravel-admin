import 'virtual:uno.css'

import { createApp } from 'vue'

import App from './App.vue'
import router from './router'
import store from './stores'

import 'nprogress/nprogress.css'
import '@/assets/style/global.less'

const app = createApp(App)

useAppI18n(app)

app.use(router)
app.use(store)

app.mount('#app')
