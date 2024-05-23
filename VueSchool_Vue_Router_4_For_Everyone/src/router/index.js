import { createRouter, createWebHistory } from 'vue-router'
import sourceData from '@/data.json'

import HomeView from '@/views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
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

export default router
