import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import CustomerView from '../views/CustomersView.vue'
import ReportsView from '../views/ReportsView.vue'


const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/customers',
        name: 'Clientes',
        component: CustomerView
    },
    {
        path: '/reports',
        name: 'Relatórios',
        component: ReportsView
    },

    // Adicione mais rotas aqui conforme necessário
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
