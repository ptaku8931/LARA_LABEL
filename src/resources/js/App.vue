<template>
  <v-app class="lato">
    <header>
      <!-- notificationコンポーネント -->
      <Message v-show="notification" v-model="msg" :isSuccess="isSuccess" />
      <!-- Nav barコンポーネント -->
      <Navbar />
    </header>
    <main>
      <!-- view-routerによるページコンポーネント -->
      <router-view></router-view>
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
      isSuccess: true
    }
  },
  watch: {
    errorCode: {
      immediate: true,
      handler(val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push('/500')
        }
      }
    },
    successMsg: {
      immediate: true,
      handler(val) {
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
      handler(val) {
        if (val !== null) {
          this.notification = true
          this.msg = val
          this.isSuccess = false
        }
        this.msg = val
      }
    },
    $route() {
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
    }
  }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Lato:ital@1&family=Noto+Sans+JP&display=swap');
.lato {
  font-family: 'Lato', 'Noto Sans JP', sans-serif !important;
  font-style: italic;
}
.v-text-field input {
  font-size: 17px;
}
.v-text-field label {
  font-size: 19px;
}
.v-text-field .v-messages {
  font-size: 16px !important;
}
.v-list-item__title {
  font-size: 18px !important;
}
.theme--dark.v-select .v-select__selection--comma {
  font-size: 17px !important;
}
.theme--light.v-label {
  font-size: 18px !important;
}
.delay-enter {
  opacity: 0;
}
.delay-enter-active,
.delay-leave-active {
  transition: all 2.5s ease;
}
.delay-leave-to {
  opacity: 0;
}
</style>