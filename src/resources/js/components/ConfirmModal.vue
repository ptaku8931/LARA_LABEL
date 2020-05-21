<template>
  <v-row justify="center">
    <v-dialog v-model="value" persistent max-width="350">
      <v-card dark outlined class="modal">
        <v-card-title class="title">Are you sure?</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text small @click="closeModal()">Cancel</v-btn>
          <v-btn text small @click="doDelete()">Delete</v-btn>
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
.modal {
  border-width: 2px !important;
  border-color: white !important;
}
.title {
  margin-left: 70px;
}
</style>
