import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import Label from './pages/Label.vue'
import Snippet from './pages/Snippet.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/label',
    name: 'Label',
    component: Label
  },
  {
    path: '/snippet',
    name: 'Snippet',
    component: Snippet
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
