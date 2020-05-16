import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store/store'

import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import LabelPage from './pages/LabelPage.vue'
import SnippetPage from './pages/SnippetPage.vue'
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
    name: 'LabelPage',
    component: LabelPage,
  },
  {
    path: '/snippet',
    name: 'SnippetPage',
    component: SnippetPage
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
