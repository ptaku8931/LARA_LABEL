<template>
  <!-- カラー変更モーダルここから -->
  <v-row justify="center">
    <v-dialog v-model="value" scrollable max-width="300px">
      <v-card dark outlined class="modal">
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
          <v-btn text @click="closeColorModal()">Cancel</v-btn>
          <v-btn text @click="editLabelColor()">Update</v-btn>
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
    colors: ''
  },
  data() {
    return {
      // 変更したいカラー
      changedColor: ''
    }
  },
  
  created() {
    this.changedColor = 'white'
  },

  methods: {

    // カラーモーダルを閉じる
    closeColorModal() {
      this.$emit('input', false)
      this.changedColor = 'white'
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
.modal {
  border-width: 2px !important;
  border-color: white !important;
}
.title {
  margin-left: 20px;
}
</style>

