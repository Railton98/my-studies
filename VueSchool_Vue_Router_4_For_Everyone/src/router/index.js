import { createRouter, createWebHistory } from 'vue-router'

import HomeView from '@/views/HomeView.vue'
import BrazilView from '@/views/BrazilView.vue'
import HawaiiView from '@/views/HawaiiView.vue'
import JamaicaView from '@/views/JamaicaView.vue'
import PanamaView from '@/views/PanamaView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/brazil',
      name: 'brazil',
      component: BrazilView
    },
    {
      path: '/hawaii',
      name: 'hawaii',
      component: HawaiiView
    },
    {
      path: '/jamaica',
      name: 'jamaica',
      component: JamaicaView
    },
    {
      path: '/panama',
      name: 'panama',
      component: PanamaView
    }
  ]
})

export default router
