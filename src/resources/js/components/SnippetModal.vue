<template>
  <!-- Snippet作成モーダルここから -->
  <v-row justify="center">
    <v-dialog v-model="value" persistent max-width="600px">
      <v-card outlined>
        <v-form @submit.prevent>
          <v-card-title class="title">
            <v-icon v-if="addSnippet" class="mr-2">mdi-text-box-outline</v-icon>
            <v-icon v-else class="mr-2">mdi-text-box-check-outline</v-icon>
            <span class="headliner">Snippet</span>
          </v-card-title>
          <v-card-subtitle 
            class="subtitle" 
            v-if="!addSnippet && newSnippet && newSnippet.trim().length !== 0"
          >
            <v-icon @click="copyToClipboard()">mdi-content-copy</v-icon>
            Copy Snippet 
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
            <small class="pl-1" v-if="!addSnippet">Please click X button ( top and right ) and update if you wanna delete your snippet</small>
          </v-card-text>
          <v-card-actions class="pt-0 mr-2">
            <v-spacer></v-spacer>
            <v-btn v-if="addSnippet" @click="closeAddSnippetModal()">Cancel</v-btn>   
            <v-btn v-else @click="closeEditSnippetModal()">Cancel</v-btn>        
            <v-btn v-if="addSnippet" color="primary" :disabled="!newSnippet || newSnippet.trim().length === 0" @click="editSnippet()">Create</v-btn>
            <v-btn v-else color="success" :disabled="newSnippet === snippetValue" @click="editSnippet()">Update</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
  <!-- Snippet作成モーダルここまで -->
</template>
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
      newSnippet: '',
    }
  },
  watch: {
    snippetValue: {
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
    
    // snippetモーダルを閉じる
    closeAddSnippetModal() {
      this.$emit('input', false)
      this.newSnippet = ''
    },

    // snippetモーダルを閉じる
    closeEditSnippetModal() {
      this.$emit('input', false)
      this.newSnippet = this.snippetValue
    },

    // 新規snippetを親にemit
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
        'The Snippet is successfully copied to the clipboard !!'
      )
    }
  }
}
</script>

<style scoped>
.title {
  margin-left: 218px;
}
.subtitle {
  padding-bottom: 0px;
  padding-top: 15px;
}
.textarea {
  margin-top: 10px !important;
  padding-bottom: 0 !important;
}
</style>