<template>
  <v-app>
    <header>
      <transition name="slide" appear  mode="out-in">
        <Message v-show="notification" v-model="msg" :isSuccess="isSuccess"/>
      </transition>
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
import Message from './components/Message.vue'

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
      isSuccess: true
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
    successMsg: {
      handler (val) {
        if (val !== null) {
          this.notification = true
          this.msg = val  
          this.isSuccess = true
        }
        this.msg = val
      },
      immediate: true
    },
    errorMsg: {
      handler (val) {
        if (val !== null) {
          this.notification = true
          this.msg = val 
          this.isSuccess = false
        }
        this.msg = val
      },
      immediate: true
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
  opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
  transition: all .5s ease;
}

.fade-leave-to {
  opacity: 0;
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