<template>
  <!-- カラー変更モーダルここから -->
  <v-row justify="center">
    <v-dialog v-model="value" scrollable persistent max-width="300px">
      <v-card outlined>
        <v-card-title class="title">
          <v-icon class="mr-3">mdi-pencil</v-icon>Edit Label Color
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text style="height: 200px;">
          <!-- ラベルカラー変更フォーム -->
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
          <v-btn small @click="closeColorModal()">Cancel</v-btn>
          <v-btn small color="success" :disabled="beforeChangeColor === changedColor" @click="editLabelColor()">Update</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
  <!-- カラー変更モーダルここまで -->
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
      // 変更したいカラー
      changedColor: ''
    }
  },
  watch: {
    value: {
      handler(val) {
        if(val === true) {
          this.changedColor = this.beforeChangeColor
        }
      }
    }
  },
  methods: {

    // カラーモーダルを閉じる
    closeColorModal() {
      this.$emit('input', false)
      this.changedColor = 'indigo'
    },

    // 変更カラーを親にemit
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

