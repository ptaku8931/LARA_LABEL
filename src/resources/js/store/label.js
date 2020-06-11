const state = {
  currentFolderId: '',
  backgroundImg: {
    name: 'white',
    url: '/img/white.jpg'
  },
  currentPage: '',
  drawerStatus: true
}

const mutations = {
  SET_CURRENT_FOLDER_ID(state, id) {
    state.currentFolderId = id
  },
  SET_BACKGROUND_IMG(state, img) {
    state.backgroundImg = img
  },
  SET_CURRENT_PAGE(state, page) {
    state.currentPage = page
  },
  SET_DRAWER(state, status) {
    state.drawerStatus = status
  }
}

export default {
  namespaced: true,
  state,
  mutations
}