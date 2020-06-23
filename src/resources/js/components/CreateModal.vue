<template>
  <v-row justify="center">
    <v-dialog persistent max-width="500px" v-model="value">
      <v-card outlined>
        <v-form ref="form" v-model="valid" @submit.prevent>
          <v-card-title class="form-title">
            <v-icon class="mr-2">mdi-card-plus-outline</v-icon>
            <span class="lato">Create Label</span>
          </v-card-title>
          <v-card-text>
            <v-container d-flex>
              <v-row class="mt-5 pt-5">
                <!-- ラベルタイトル入力フォーム -->
                <v-col cols="10">
                  <v-text-field
                    class="label-title"
                    label="Title"
                    prepend-icon="mdi-file-check-outline"
                    hint="Title is required"
                    persistent-hint
                    counter="30"
                    :rules="titleRules"
                    ref="titleForm"
                    v-model="newLabel.title"
                  ></v-text-field>
                </v-col>
                <!-- ラベルテキスト入力フォーム -->
                <v-col cols="10">
                  <v-text-field
                    class="label-text"
                    label="Text"
                    prepend-icon="mdi-file-document-outline"
                    hint="Text is required"
                    persistent-hint
                    counter="50"
                    :rules="textRules"
                    ref="textForm"
                    v-model="newLabel.text"
                  ></v-text-field>
                </v-col>
                <!-- ラベルURL入力フォーム -->
                <v-col cols="10">
                  <v-text-field
                    label="URL"
                    prepend-icon="mdi-microsoft-internet-explorer"
                    hint="URL is not required"
                    persistent-hint
                    :rules="urlRules"
                    v-model="newLabel.url"
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <!-- ラベルカラー入力フォーム -->
                <v-col>
                  <v-radio-group class="text-center" label="Color" v-model="createdColor" colmn>
                    <v-radio
                      v-for="(color, index) in colors"
                      :key="color"
                      :color="color"
                      :label="color"
                      :value="color"
                    ></v-radio>
                  </v-radio-group>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click="closeCreateModal">Cancel</v-btn>
            <v-btn color="primary" :disabled="!valid" @click="createLabel">Create</v-btn>
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
    colors: ''
  },
  data() {
    return {
      // snippetは最初nullで入れておく、後から追加可
      newLabel: {
        label_folder_id: '',
        title: '',
        text: '',
        color: '',
        url: '',
        snippet: ''
      },
      createdColor: '',
      valid: true,
      titleRules: [
        v => !!v || 'Title is required',
        v => (v && v.length <= 30) || 'Too long !!'
      ],
      textRules: [
        v => !!v || 'Text is required',
        v => (v && v.length <= 50) || 'Too long !!'
      ],
      // null可もしくは有効なURL可
      urlRules: [
        v =>  !v || 'ok' && /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w-.\/?%&=]*)?/.test(v) || 'URL must be valid',
      ],
    }
  },
  watch: {
    // valueの値をwatchしてfalseになれば値をリセット
    value: {
      handler(val) {
        if (val === false) {
          this.clearCreateModal()
        }
      }
    }
  },
  created() {
    this.createdColor = 'indigo'
  },
  methods: {

    resetValidation() {
      this.$refs.form.resetValidation()
    },

    clearCreateModal() {
      this.newLabel.title = ''
      this.newLabel.text = ''
      this.newLabel.url = ''
      this.createdColor = 'indigo'
      this.resetValidation()
    },

    closeCreateModal() {
      this.$emit('input', false)
      this.resetValidation()
    },
    
    createLabel() {
      this.newLabel.color = this.createdColor
      this.$emit('create-label', this.newLabel)
    },
  }
}
</script>

<style scoped>
/* .lato {
  font-size: 24px;
} */
.form-title {
  margin-left: 150px;
}
.label-title {
  font-style: normal;
}
.label-text {
  font-style: normal;
}
</style>