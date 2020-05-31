<template>
  <v-row justify="center">
    <v-dialog scrollable persistent max-width="300px" v-model="value">
      <v-card outlined>
        <v-card-title class="title">
          <v-icon class="mr-3">mdi-pencil</v-icon>Edit Label Color
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text style="height: 200px;">
          <v-radio-group v-model="changedColor" column>
            <v-radio
              v-for="(color, index) in colors"
              :key="color"
              :color="color"
              :label="color"
              :value="color"
            ></v-radio>
          </v-radio-group>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn small @click="closeColorModal">Cancel</v-btn>
          <!-- 変更なしの場合は送信不可 -->
          <v-btn small color="success" :disabled="beforeChangeColor === changedColor" @click="editLabelColor">Update</v-btn>
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
    },
    colors: '',
    beforeChangeColor: '',
  },
  data() {
    return {
      changedColor: ''
    }
  },
  watch: {
    value: {
      handler(val) {
        // 変更前のカラーを代入
        if(val === true) {
          this.changedColor = this.beforeChangeColor
        }
      }
    }
  },
  methods: {
    closeColorModal() {
      this.$emit('input', false)
      this.changedColor = this.beforeChangeColor
    },

    editLabelColor() {
      this.$emit('edit-label-color', this.changedColor)
      this.closeColorModal()
    }
  }
}
</script>

<style scoped>
.title {
  margin-left: 20px;
}
</style>

