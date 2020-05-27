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
          <v-card-text class="mb-0">
            <v-textarea
              class="textarea"
              :label="addSnippet ? 'Please create your snippet' : ''"
              :append-icon="!addSnippet && newSnippet && newSnippet.trim().length !== 0 ? 'mdi-content-copy' : ''"
              @click:append
              outlined 
              clearable
              color="indigo"
              background-color="blue lighten-5"
              height="540"
              v-model="newSnippet"
            ></v-textarea>
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
    editSnippet() {
      this.$emit('edit-snippet', this.newSnippet)
      this.$emit('input', false)
    }
  }
}
</script>

<style scoped>
.title {
  margin-left: 215px;
}
.textarea {
  margin-top: 10px !important;
  padding-bottom: 0 !important;
}
</style>