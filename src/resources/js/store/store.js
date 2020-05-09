import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error'
import label from './label'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    error,
    label
  }
})

export default store