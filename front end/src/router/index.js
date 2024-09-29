import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      beforeEnter: (to, from, next) => {
        if(!sessionStorage.getItem('token')){
          next()
        }else{
          next({ name: 'dashboard' });
        }
      }
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('../views/DashboardView.vue'),
      beforeEnter: (to, from, next) => {
        if(sessionStorage.getItem('token')){
          next()
        }else{
          next({ name: 'home' });
        }
      }
    }
  ]
})

export default router
