<template>
  <v-row justify="center">
    <v-dialog persistent max-width="350" v-model="value">
      <v-card outlined>
        <v-card-title class="title">Are you sure?</v-card-title>
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
  margin-left: 75px;
}
</style>
