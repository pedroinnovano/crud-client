import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import CustomerView from '../views/CustomersView.vue'

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
    }
    // Adicione mais rotas aqui conforme necessário
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
