import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store/store'

import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import LabelPage from './pages/LabelPage.vue'
import SystemError from './pages/errors/System.vue'
import NotFound from './pages/errors/NotFound.vue'

Vue.use(VueRouter)

// 認証のナビゲーションガードをそれぞれのルートで設定
const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    beforeEnter (to, from, next) {
      if (store.getters['auth/check']) {
        next('/label')
      } else {
        next()
      }
    }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    beforeEnter (to, from, next) {
      if (store.getters['auth/check']) {
        next('/label')
      } else {
        next()
      }
    }
  },
  {
    path: '/label',
    name: 'LabelPage',
    component: LabelPage,
    beforeEnter (to, from, next) {
      if (store.getters['auth/check']) {
        next()
      } else {
        next('/login')
      }
    }
  },
  {
    path: '/500',
    component: SystemError
  },
  {
    path: '*',
    component: NotFound
  },
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
