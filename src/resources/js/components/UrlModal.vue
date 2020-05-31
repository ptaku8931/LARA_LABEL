<template>
  <v-row justify="center">
    <v-dialog persistent max-width="400" v-model="value">
      <v-card outlined>
        <v-container>
          <v-card-title class="title">
            <v-icon class="mr-2">mdi-microsoft-windows</v-icon>
            <!-- editUrlが真なら編集モーダル -->
            <span v-if="editUrl">Edit URL</span>
            <!-- 偽なら追加モーダル -->
            <span v-else>Add URL</span>
          </v-card-title>
          <v-form ref="form" v-model="valid" @submit.prevent>
            <!-- 編集モーダルの場合はnullで送信可能 -->
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
              <!-- 追加モーダルの場合、nullもしくは空文字の場合は送信できない -->
              <v-btn
                small
                color="primary"
                :disabled="!valid || !editUrl && newUrl === '' || !editUrl && newUrl === null"
                @click="editLabelUrl"
              >Submit</v-btn>
            </v-card-actions>
          </v-form>
        </v-container>
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
    editUrl: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      newUrl: '',
      valid: true,
      // nullもしくはURLが有効であるバリデーション
      urlRules: [
        v => !v || 'ok' && /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w-.\/?%&=]*)?/.test(v) || 'URL must be valid'
      ]
    }
  },
  methods: {
    resetValidation() {
      this.$refs.form.resetValidation()
    },

    closeUrlModal() {
      this.$emit('input', false)
      this.newUrl = ''
      this.resetValidation()
    },
    
    editLabelUrl() {
      this.$emit('edit-label-url', this.newUrl)
      this.closeUrlModal()
    }
  }
}
</script>

<style scoped>
.title {
  margin-left: 108px;
}
</style>