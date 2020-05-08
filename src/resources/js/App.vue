<template>
  <v-app>
    <header>
      <Navbar />
    </header>
    <main>
      <transition name="fade" appear mode="out-in">
        <router-view></router-view>
      </transition>
    </main>
    <footer>
      <Footer />
    </footer>
  </v-app>
</template>

<script>
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'
import { INTERNAL_SERVER_ERROR } from './error_code'

export default {
  components: {
    Navbar,
    Footer
  },
  computed: {
    errorCode() {
      return this.$store.state.error.code
    }
  },
  watch: {
    errorCode: {
      handler (val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push('/500')
        }
      },
      immediate: true
    },
    $route () {
      this.$store.commit('error/SET_CODE', null)
    }
  }
}
</script>

<style scoped>
.fade-enter {
  /* transform: translateX(200px); */
  opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}

.fade-leave-to {
  /* transform: translateX(-200px); */
  opacity: 0;
}
</style>