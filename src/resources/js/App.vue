<template>
  <v-app>
    <header>
      <transition name="slide" appear  mode="out-in">
        <!-- notificationコンポーネント -->
        <Message v-show="notification" v-model="msg" :isSuccess="isSuccess"/>
      </transition>
      <!-- Nav barコンポーネント -->
      <Navbar />
    </header>
    <main>
      <transition name="fade" mode="out-in">
        <!-- view-routerによるページコンポーネント -->
        <router-view></router-view>
      </transition>
    </main>
    <footer>
      <!-- Footerコンポーネント -->
      <Footer />
    </footer>
  </v-app>
</template>

<script>
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'
import Message from './components/Message.vue'
import { INTERNAL_SERVER_ERROR } from './error_code'

export default {
  components: {
    Navbar,
    Footer,
    Message
  },
  data() {
    return {
      notification: false,
      msg: null,
      isSuccess: true,
    }
  },
  watch: {
    errorCode: {
      immediate: true,
      handler (val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push('/500')
        }
      }
    },
    successMsg: {
      immediate: true,
      handler (val) {
        if (val !== null) {
          this.notification = true
          this.msg = val  
          this.isSuccess = true
        }
        this.msg = val
      }
    },
    errorMsg: {
      immediate: true,
      handler (val) {
        if (val !== null) {
          this.notification = true
          this.msg = val 
          this.isSuccess = false
        }
        this.msg = val
      }
    },
    $route () {
      this.$store.commit('error/SET_CODE', null)
    }
  },
  computed: {
    errorCode() {
      return this.$store.state.error.code
    },
    successMsg() {
      return this.$store.state.message.successMsg
    },
    errorMsg() {
      return this.$store.state.message.errorMsg
    },
  }
}
</script>

<style scoped>
.fade-enter {
  transform: translateX(20px);
  opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}

.fade-leave-to {
  opacity: 0;
  transform: translateX(-20px);
}

.slide-enter {
  transform: translateX(500px);
  opacity: 0;
}

.slide-enter-active,
.slide-leave-active {
  transition: all .9s ease;
}

.slide-leave-to {
  transform: translateX(500px);
  opacity: 0;
}
</style>