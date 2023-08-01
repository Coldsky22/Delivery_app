import './bootstrap.js'
import { createApp } from 'vue'
import { Quasar, Notify } from 'quasar'
import 'quasar/src/css/index.sass'
import '@quasar/extras/material-icons/material-icons.css'
import router from './router.js'
import AdminTable from './components/AdminTable/AdminTable.vue'

const app = createApp({})

app.component('admin-table', AdminTable)

app.use(Quasar, {
    plugins: {
        Notify
    },
    config: {
        notify: {
            position: 'top-right',
        }
    }
})

app.use(router)

app.mount('#app')
