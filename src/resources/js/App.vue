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

  export default {
    components: {
      Navbar,
      Footer
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
  transition: all 0.2s ease;
}

.fade-leave-to {
  /* transform: translateX(-200px); */
  opacity: 0;
}
</style>