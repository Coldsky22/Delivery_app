import { createRouter, createWebHistory } from 'vue-router'
import AdminTable from './components/AdminTable/AdminTable.vue'

const routes = [
    { path: '/admin', component: AdminTable },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
