<template>
  <v-app-bar app color="indigo" dark>
    <v-container d-flex align-items-center>
      <v-btn v-if="!isLogin" text rounded to="/">POST IT APP</v-btn>
      <v-btn v-if="isLogin" text rounded class="user-icon">
        <v-icon class="mr-2">mdi-account-circle</v-icon>
        {{ username }}
      </v-btn>
      <v-spacer></v-spacer>
      <v-btn v-if="isLogin" text rounded to="/label">Post it</v-btn>
      <v-btn v-if="isLogin" text rounded to="/snippet">Snippet</v-btn>
      <v-spacer></v-spacer>
      <v-btn v-if="!isLogin" text rounded to="/login">Login / Register</v-btn>
      <v-btn v-if="isLogin" text rounded @click="logout">logout</v-btn>
    </v-container>
  </v-app-bar>
</template>

<script>
export default {
  methods: {
    async logout() {
      await this.$store.dispatch('auth/logout')
      this.$router.push('/login')
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