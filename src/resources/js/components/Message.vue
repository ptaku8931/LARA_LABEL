<template>
  <!-- サクセスもしくはエラーメッセージ -->
  <v-snackbar v-model="snackbar" :color="isSuccess ? 'teal' : 'red' " top right :timeout="timeout">
    {{ value }}
  </v-snackbar>
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
      timeout: 3000,
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

