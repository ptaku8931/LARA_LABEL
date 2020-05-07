import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import Label from './pages/Label.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    components: Home
  },
  {
    path: '/login',
    name: 'Login',
    components: Login
  },
  {
    path: '/Label',
    name: 'Label',
    components: Label
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
