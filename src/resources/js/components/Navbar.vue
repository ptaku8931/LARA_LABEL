<template>
  <div>
    <v-app-bar app clipped-left color="indigo" dark>
      <!-- フォルダ用ハンバーガー-->
      <v-app-bar-nav-icon class="ml-2" v-if="isLogin" @click.stop="openDrawer"></v-app-bar-nav-icon>
      <!-- アカウント情報 -->
      <v-btn v-if="isLogin" text rounded class="user-icon ml-2" @click="openInfoModal">
        <v-icon class="mr-2">mdi-account-circle</v-icon>
        {{ userName }}
      </v-btn>
      <v-container d-flex align-items-center>
        <v-btn v-if="!isLogin" text rounded to="/">Lara_label</v-btn>
        <v-spacer></v-spacer>
        <v-btn v-if="isLogin" text rounded to="/label">Lara_label</v-btn>
        <!-- 新規登録&ログイン -->
        <v-btn v-if="!isLogin" text rounded to="/login">Login / Register</v-btn>
        <v-btn v-if="isLogin" text rounded @click="logout">logout</v-btn>
      </v-container>
    </v-app-bar>
    <!-- アカウント情報コンポーネント -->
    <UserInfoModal v-model="userInfoModal" @open-confirm-modal="openConfirmModal" />
    <!-- アカウント削除コンポーネント -->
    <UserConfirmModal v-model="userConfirmModal" @do-delete="softDelete" />
  </div>
</template>

<script>
import UserInfoModal from './UserInfoModal.vue'
import UserConfirmModal from './UserConfirmModal.vue'
export default {
  components: {
    UserInfoModal,
    UserConfirmModal
  },
  data() {
    return {
      userInfoModal: false,
      userConfirmModal: false,
      drawer: true
    }
  },
  mounted() {
    if (this.isLogin) {
      this.$store.commit('message/SET_SUCCESS_MSG', 'Welcome to LARA_LABEL !!')
    }
  },
  methods: {
    async logout() {
      await this.$store.dispatch('auth/logout')
      this.$router.push('/')
    },
    async softDelete() {
      await this.$store.dispatch('auth/softDelete')
      this.userInfoModal = false
      this.$router.push('/')
    },
    openInfoModal() {
      this.userInfoModal = true
    },
    openConfirmModal() {
      this.userConfirmModal = true
    },
    openDrawer() {
      this.drawer = !this.drawer
      this.$store.commit('label/SET_DRAWER', this.drawer)
    }

  },
  computed: {
    isLogin() {
      return this.$store.getters['auth/check']
    },
    userName() {
      return this.$store.getters['auth/userName']
    }
  }
}
</script>

<style scoped>
.user-icon {
  text-transform: none;
  font-size: 14px;
  overflow: hidden;
  white-space: nowrap;
  max-width: 300px;
}
</style>