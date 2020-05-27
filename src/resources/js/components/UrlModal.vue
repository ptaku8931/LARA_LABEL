<template>
  <!-- URL追加及び編集モーダルここから -->
  <v-row justify="center">
    <v-dialog v-model="value" persistent max-width="400">
      <v-card outlined> 
        <v-container>
          <v-card-title class="headline title">
            <v-icon class="mr-2">mdi-microsoft-windows</v-icon>
            <span v-if="editUrl">Edit URL</span>
            <span v-else>Add URL</span>
          </v-card-title>
          <v-form ref="form" v-model="valid" @submit.prevent>
            <v-text-field
              label="URL"
              :hint="editUrl ? 'Please send empty field if you wanna delete URL' : 'URL is required'"
              persistent-hint
              prepend-icon="mdi-microsoft-internet-explorer"
              clearable
              :rules="urlRules"
              v-model="newUrl"
            ></v-text-field>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn small @click="closeUrlModal">Cancel</v-btn>
              <v-btn small color="primary" :disabled="!valid || !editUrl && newUrl === '' || !editUrl && newUrl === null" @click="editLabelUrl()">Submit</v-btn>
            </v-card-actions>
          </v-form>
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
      newUrl: '',
      valid: true,
      urlRules: [
        v =>  !v || 'ok' && /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w-.\/?%&=]*)?/.test(v) || 'URL must be valid',
      ],
    }
  },
  methods: {

    // バリデーションリセット
    resetValidation() {
      this.$refs.form.resetValidation()
    },

    // urlモーダルを閉じる
    closeUrlModal() {
      this.$emit('input', false)
      this.newUrl = ''
      this.resetValidation()
    },

    // 新規Urlを親にemit
    editLabelUrl() {
      this.$emit('edit-label-url', this.newUrl)
      this.closeUrlModal()
    },
  }
}
</script>
<style scoped>
.title {
  margin-left: 100px;
}
</style>