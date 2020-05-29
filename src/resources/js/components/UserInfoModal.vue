<template>
  <v-row justify="center">
    <v-dialog v-model="value" persistent max-width="350">
      <v-card outlined class="modal">
        <v-card-title class="title">
          Account Information
        </v-card-title>
        <v-card-text class="text">
          <div class="mt-5 scroll">
            <span class="ml-5">Name :</span>
            {{ username }}
          </div>
          <div class="mt-5 scroll">
            <span class="ml-5">E-mail :</span>
            {{ userEmail }}
          </div>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn small @click="closeModal()">Close</v-btn>
          <v-btn small color="error" @click="openConfirm()">Delete</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  props: {
    value: {
      type: Boolean,
      required: true
    }
  },
  methods: {
    closeModal() {
      this.$emit('input', false)
    },
    openConfirm() {
      this.$emit('open-confirm-modal')
    }
  },
  computed: {
    username() {
      return this.$store.getters['auth/username']
    },
    userEmail() {
      return this.$store.getters['auth/userEmail']
    }
  }
}
</script>

<style scoped>
.title {
  margin-left: 44px;
}
.scroll {
  overflow: scroll;
  white-space: nowrap;
  width: 90%;
  height: 20px;
}
</style>