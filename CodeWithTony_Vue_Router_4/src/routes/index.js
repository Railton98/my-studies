import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  { path: '/', name: 'Home', component: () => import('../views/Home.vue') },
  {
    path: '/about',
    name: 'About',
    component: () => import('../views/About.vue'),
  },
  {
    path: '/movies',
    name: 'MovieLists',
    component: () => import('../views/Movies.vue'),
  },
  {
    path: '/movies/:id',
    name: 'MovieDetails',
    component: () => import('../views/MovieDetails.vue'),
    props: true,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
