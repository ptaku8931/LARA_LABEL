<template>
  <transition name="slide" appear mode="out-in">
    <!-- サクセスもしくはエラーメッセージ -->
    <v-snackbar
      class="snackbar"
      v-model="snackbar"
      :color="isSuccess ? 'teal' : 'red' "
      top
      right
      :timeout="timeout"
    >{{ value }}</v-snackbar>
  </transition>
</template>

<script>
export default {
  props: {
    value: '',
    isSuccess: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      snackbar: false,
      timeout: 4000
    }
  },
  watch: {
    value: {
      handler() {
        this.snackbar = true
      }
    }
  }
}
</script>

<style scoped>
.snackbar {
  font-size: 18px;
}
.slide-enter {
  transform: translateX(500px);
}
.slide-enter-active,
.slide-leave-active {
  transition: all 1.2s ease;
}
.slide-leave-to {
  transform: translateX(-500px);
}
</style>

