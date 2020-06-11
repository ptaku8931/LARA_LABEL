<template>
  <v-row justify="center">
    <v-dialog persistent max-width="350" v-model="value">
      <v-card outlined>
        <v-card-title class="title">
          <span class="lato account">Account Information</span>
        </v-card-title>
        <v-card-text>
          <div class="mt-5 scroll lato">
            <span class="ml-5">Name :</span>
            {{ userName }}
          </div>
          <div class="mt-5 scroll lato">
            <span class="ml-5">E-mail :</span>
            {{ userEmail }}
          </div>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn small @click="closeModal">Close</v-btn>
          <v-btn small color="error" @click="openConfirm">Delete</v-btn>
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
    userName() {
      return this.$store.getters['auth/userName']
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
.account {
  font-size: 24px;
}
.scroll {
  overflow: scroll;
  white-space: nowrap;
  width: 90%;
  height: 30px;
  font-size: 20px;
}
</style>