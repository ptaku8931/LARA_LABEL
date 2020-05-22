const state = {
  currentFolderId: '',
  folderTheme: false,
  labelTheme: false,
  backgroundImg: {
    name: 'White',
    url: '/img/the-phope-9X1rJClbnmg-unsplash.jpg'
  },
  currentPage: ''
}

const mutations = {
  SET_CURRENT_FOLDER_ID(state, id) {
    state.currentFolderId = id
  },
  SET_FOLDER_THEME(state, theme) {
    state.folderTheme = theme
  },
  SET_LABEL_THEME(state, theme) {
    state.labelTheme = theme
  },
  SET_BACKGROUND_IMG(state, img) {
    state.backgroundImg = img
  },
  SET_CURRENT_PAGE(state, page) {
    state.currentPage = page
  }
}

export default {
  namespaced: true,
  state,
  mutations
}