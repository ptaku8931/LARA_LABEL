<template>
  <div>
    <v-app-bar app color="indigo" dark>
      <v-container d-flex align-items-center>
        <v-btn v-if="!isLogin" text rounded to="/">Lara_label</v-btn>
        <v-btn v-if="isLogin" text rounded class="user-icon" @click="openModal">
          <v-icon class="mr-2">mdi-account-circle</v-icon>
          {{ username }}
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn v-if="isLogin" text rounded to="/label">Lara_label</v-btn>
        <v-spacer></v-spacer>
        <v-btn v-if="!isLogin" text rounded to="/login">Login / Register</v-btn>
        <v-btn v-if="isLogin" text rounded @click="logout">logout</v-btn>
      </v-container>
    </v-app-bar>
    <UserConfirmModal v-model="userConfirmModal" @do-delete="softDelete"/>
  </div>

</template>

<script>
import UserConfirmModal from './UserConfirmModal.vue'
export default {
  components: {
    UserConfirmModal
  },
  data() {
    return {
      userConfirmModal: false
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
      this.$router.push('/')
    },
    openModal() {
      this.userConfirmModal = true
    }

  },
  computed: {
    isLogin() {
      return this.$store.getters['auth/check']
    },
    username() {
      return this.$store.getters['auth/username']
    }
  }
}
</script>

<style scoped>
.user-icon {
text-transform: none;
font-size: 14px;
}
</style>