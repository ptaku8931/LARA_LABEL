<template>
  <!-- カラー変更モーダルここから -->
  <v-row justify="center">
    <v-dialog v-model="value" scrollable max-width="250px">
      <v-card>
        <v-card-title>
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
          <v-btn color="grey" text @click="closeColorModal()">Cancel</v-btn>
          <v-btn color="success" text @click="editLabelColor()">Update</v-btn>
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
  watch: {
    // valueの値をwatchしてfalseになれば値をリセット
    value: {
      handler (val) {
        if (val === false) {
          this.clearColorModal()
        }
      },
      immediate: true
    }
  },
  methods: {

    // カラーモーダルクリア
    clearColorModal() {
      this.changedColor = ''
    },

    // カラーモーダルを閉じる
    closeColorModal() {
      this.$emit('input', false)
    },

    // 変更カラーを親にemit
    editLabelColor() {
      this.$emit('edit-label-color', this.changedColor)
    }
  }
}
</script>

