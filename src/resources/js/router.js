import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store/store'

import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import Label from './pages/Label.vue'
import Snippet from './pages/Snippet.vue'
import SystemError from './pages/errors/System.vue'

Vue.use(VueRouter)

const beforeEnter = function(to, from, next) {
  if (store.getters['auth/check']) {
    next('/label')
  } else {
    next()
  }
}

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    beforeEnter
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    beforeEnter
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
  },
  {
    path: '/500',
    component: SystemError
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
