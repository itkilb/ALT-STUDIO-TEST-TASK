import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Auth from './components/Auth'
import Location from './components/Location'
import Main from './components/Main'
import Register from './components/Register'


const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Main
    },
    {
      path: '/Login',
      component: Auth,
    },
    {
      path: '/Register',
      component: Register
    },
    {
      path: '/Location',
      component: Location,
    },
  ],
});

export default router;