<template>
  <v-row justify="center">
    <v-dialog persistent max-width="350" v-model="value">
      <v-card outlined>
        <v-card-title class="title">
          <span class="lato delete">Delete Account</span>
        </v-card-title>
        <v-card-text class="text">
          <span class="lato">Are you sure?</span>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn small @click="closeModal">Cancel</v-btn>
          <v-btn small color="error" @click="doDelete">Delete</v-btn>
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
    doDelete() {
      this.$emit('do-delete')
      this.closeModal()
    }
  }
}
</script>

<style scoped>
.title {
  margin-left: 62px;
}
.delete {
  font-size: 26px;
}
.text {
  margin-left: 90px;
  margin-top: 10px;
  font-size: 20px;
}
</style>