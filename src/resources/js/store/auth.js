import { OK, CREATED, VALIDATION_ERROR } from '../error_code'

const state = {
  user: null,
  apiStatus: null,
  loginErrorMessages: null,
  registerErrorMessages: null
}

const mutations = {
  SET_USER(state, user) {
    state.user = user
  },
  SET_API_STATUS(state, status) {
    state.apiStatus = status
  },
  SET_LOGIN_ERROR_MESSAGES(state, messages) {
    state.loginErrorMessages = messages
  },
  SET_REGISTER_ERROR_MESSAGES(state, messages) {
    state.registerErrorMessages = messages
  }
}

const actions = {
  async login({ commit }, data) {
    commit('SET_API_STATUS', null)
    const response = await axios.post('api/login', data)

    if (response.status === OK) {
      commit('SET_API_STATUS', true)
      commit('SET_USER', response.data)
      return false
    }

    commit('SET_API_STATUS', false)

    if (response.status === VALIDATION_ERROR) {
      commit('SET_LOGIN_ERROR_MESSAGES', response.data.errors)
    } else {
      commit('error/SET_CODE', response.status, { root: true })
    }
  },

  async register({ commit }, data) {
    commit('SET_API_STATUS', null)
    const response = await axios.post('/api/register', data)

    if (response.status === CREATED) {
      commit('SET_API_STATUS', true)
      commit('SET_USER', response.data)
      return false
    }

    commit('SET_API_STATUS', false)

    if (response.status === VALIDATION_ERROR) {
      commit('SET_REGISTER_ERROR_MESSAGES', response.data.errors)
    } else {
      commit('error/SET_CODE', response.status, { root: true })
    }
  },

  async logout({ commit }) {
    commit('SET_API_STATUS', null)
    const response = await axios.post('/api/logout')

    if (response.status === OK) {
      commit('SET_API_STATUS', true)
      commit('SET_USER', null)
      return false
    }

    commit('SET_API_STATUS', false)
    commit('error/SET_CODE', response.status, { root: true })
  },

  async loginUser({ commit }) {
    commit('SET_API_STATUS', null)
    const response = await axios.get('/api/user')
    const user = response.data || null

    if (response.status === OK) {
      commit('SET_API_STATUS', true)
      commit('SET_USER', user)
      return false
    }

    commit('SET_API_STATUS', false)
    commit('error/SET_CODE', response.status, { root: true })
  }
}

const getters = {
  check: state => !!state.user,
  username: state => (state.user ? state.user.name : '')
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
