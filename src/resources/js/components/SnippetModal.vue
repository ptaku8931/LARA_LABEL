<template>
  <v-row justify="center">
    <v-dialog persistent max-width="600px" v-model="value">
      <v-card outlined>
        <v-form @submit.prevent>
          <v-card-title class="title">
            <!-- snippetが登録されるとアイコンにチェックが入る -->
            <v-icon v-if="addSnippet" class="mr-1">mdi-text-box-outline</v-icon>
            <v-icon v-else class="mr-1">mdi-text-box-check-outline</v-icon>
            <span class="lato">Snippet</span>
          </v-card-title>
          <!-- 編集モーダルかつnullでない場合はコピー用アイコン表示 -->
          <v-card-subtitle
            class="subtitle"
            v-if="!addSnippet && newSnippet && newSnippet.trim().length !== 0"
          >
            <v-icon @click="copyToClipboard">mdi-content-copy</v-icon>Copy Snippet
          </v-card-subtitle>
          <v-card-text class="mb-0">
            <v-textarea
              class="textarea"
              outlined
              clearable
              dark
              color="white"
              background-color="black"
              height="500"
              v-model="newSnippet"
            ></v-textarea>
            <small
              class="pl-1 small"
              v-if="!addSnippet"
            >Please click X button ( top and right ) and update if you wanna delete your snippet</small>
          </v-card-text>
          <v-card-actions class="pt-0 mr-2">
            <v-spacer></v-spacer>
            <v-btn v-if="addSnippet" @click="closeAddSnippetModal">Cancel</v-btn>
            <v-btn v-else @click="closeEditSnippetModal">Cancel</v-btn>
            <!-- 追加モーダルの場合はnullで送信不可 -->
            <v-btn
              v-if="addSnippet"
              color="primary"
              :disabled="!newSnippet || newSnippet.trim().length === 0"
              @click="editSnippet"
            >Create</v-btn>
            <!-- 編集モーダルの場合は変更なしの場合送信不可 -->
            <v-btn
              v-else
              color="success"
              :disabled="newSnippet === snippetValue"
              @click="editSnippet"
            >Update</v-btn>
          </v-card-actions>
        </v-form>
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
    snippetValue: '',
    addSnippet: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      newSnippet: ''
    }
  },
  watch: {
    snippetValue: {
      immediate:true,
      handler(val) {
        if (val !== null) {
          this.newSnippet = this.snippetValue
        } else {
          this.newSnippet = ''
        }
      }
    }
  },
  methods: {
    closeAddSnippetModal() {
      this.$emit('input', false)
      this.newSnippet = ''
    },

    closeEditSnippetModal() {
      this.$emit('input', false)
      this.newSnippet = this.snippetValue
    },

    async editSnippet() {
      await this.$emit('edit-snippet', this.newSnippet)
      this.newSnippet = ''
      this.$emit('input', false)
    },

    async copyToClipboard() {
      this.$store.commit('message/SET_SUCCESS_MSG', null)
      const copyText = await this.newSnippet
      navigator.clipboard.writeText(copyText)
      this.$store.commit(
        'message/SET_SUCCESS_MSG',
        'The snippet was copied successfully !!'
      )
    }
  }
}
</script>

<style scoped>
.title {
  margin-left: 224px;
}
.subtitle {
  padding-bottom: 0px;
  padding-top: 15px;
  font-size: 17px;
}
.textarea {
  margin-top: 10px !important;
  padding-bottom: 0 !important;
  font-size: 18px !important;
  font-style: normal;
}
.lato {
  font-size: 24px;
}
.small {
  font-size: 16px;
}
</style>