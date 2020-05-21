const state = {
  successMsg: null,
  errorMsg: null
}

const mutations = {
  SET_SUCCESS_MSG (state, msg) {
    state.successMsg = msg
  },
  SET_ERROR_MSG (state, msg) {
    state.errorMsg = msg
  }
}


export default {
  namespaced: true,
  state,
  mutations
}