import { createRouter, createWebHistory } from 'vue-router'
import sourceData from '@/data.json'

import HomeView from '@/views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior(to, from, savedPosition) {
    return (
      savedPosition ||
      new Promise((resolve) => {
        setTimeout(() => resolve({ top: 0 }), 300)
      })
    )
  },
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/protected',
      name: 'protected',
      component: () => import('@/views/ProtectedView.vue'),
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/LoginView.vue')
    },
    {
      path: '/invoices',
      name: 'invoices',
      component: () => import('@/views/InvoicesView.vue'),
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/destination/:id/:slug',
      name: 'destination.show',
      component: () => import('@/views/DestinationShow.vue'),
      props: (route) => ({ id: parseInt(route.params.id) }),
      beforeEnter(to) {
        const exists = sourceData.destinations.find(
          (destination) => destination.id === parseInt(to.params.id)
        )

        if (!exists) {
          return {
            name: 'not-found',
            // allows keeping the URL while rendering a different page
            params: { pathMath: to.path.split('/').slice(1) },
            query: to.query,
            hash: to.hash
          }
        }
      },
      children: [
        {
          path: ':experienceSlug',
          name: 'experience.show',
          component: () => import('@/views/ExperienceShow.vue'),
          props: (route) => ({ ...route.params, id: parseInt(route.params.id) })
        }
      ]
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: () => import('@/views/NotFound.vue')
    }
  ]
})

router.beforeEach((to) => {
  if (to.meta.requiresAuth && !window.user) {
    return { name: 'login', query: { redirect: to.fullPath } }
  }
})

export default router
