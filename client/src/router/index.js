import { createRouter, createWebHistory } from 'vue-router'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: () => import('../views/Home.vue'),
      meta: {
        requiresAuth: false,
        requireNavigator: true,
      }
    },
    {
      path: '/My',
      name: 'My',
      component: () => import('../views/My.vue'),
      meta: {
        requireNavigator: true,
      }
    },
    {
      path: '/auth/:task?',
      name: 'Auth',
      component: () => import('../views/Auth.vue'),
      meta: {
        requiresAuth: false,
      }
    }
  ]
})

export default router
