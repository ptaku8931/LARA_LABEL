<template>
  <v-app class="lato">
    <transition name="top" appear mode="out-in">
      <div v-if="topPage" class="top">
        <transition name="header" appear mode="out-in">
          <p>LARA_LABEL</p>
        </transition>
      </div>
    </transition>
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
      topPage: true,
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
  created() {
    setTimeout(() => {
      this.topPage = false
    }, 3000)
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
.top {
  background-color: black;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  z-index: 9000;
}
.top p {
  color: white;
  text-shadow: 0 -40px 100px, 0 0 2px, 0 0 1em yellow, 0 0 0.5em yellow,
    0 0 0.1em yellow;
  font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
  font-size: 110px;
  position: fixed;
  text-align: center;
  left: 31%;
  top: 35%;
}
.top-leave-active {
  transition: all 1.8s ease;
}
.top-leave-to {
  opacity: 0;
}
.header-enter {
  opacity: 0;
}
.header-enter-active,
.header-leave-active {
  transition: all 4.5s ease;
}
.header-leave-to {
  opacity: 0;
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