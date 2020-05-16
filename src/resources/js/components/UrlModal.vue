<template>
  <!-- URL追加及び編集モーダルここから -->
  <v-row justify="center">
    <v-dialog v-model="value" persistent max-width="350">
      <v-card>
        <v-container>
          <v-card-title class="headline">
            <v-icon class="mr-2">mdi-microsoft-windows</v-icon>
            <span v-if="editUrl">Edit URL</span>
            <span v-else>Add URL</span>
          </v-card-title>
          <v-text-field
            label="URL"
            :hint="editUrl ? 'URLを削除する場合は未入力のまま送信してください' : ''"
            prepend-icon="mdi-microsoft-internet-explorer"
            clearable
            v-model="newUrl"
          ></v-text-field>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="black" text @click="closeUrlModal">Cancel</v-btn>
            <v-btn color="primary" text @click="editLabelUrl()">Submit</v-btn>
          </v-card-actions>
        </v-container>
      </v-card>
    </v-dialog>
  </v-row>
  <!-- URL追加及び編集モーダルここまで -->
</template>

<script>
export default {
  props: {
    value: {
      type: Boolean,
      required: true
    },
    editUrl: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      // 追加もしくは変更したいURL
      newUrl: ''
    }
  },
  watch: {
    // valueの値をwatchしてfalseになれば値をリセット
    value: {
      handler (val) {
        if (val === false) {
          this.clearUrlModal()
        }
      },
      immediate: true
    }
  },
  methods: {

    // urlモーダルリセット
    clearUrlModal() {
      this.newUrl = ''
    },

    // urlモーダルを閉じる
    closeUrlModal() {
      this.$emit('input', false)
    },

    // 新規Urlを親にemit
    editLabelUrl() {
      this.$emit('edit-label-url', this.newUrl)
    }
  }
}
</script>