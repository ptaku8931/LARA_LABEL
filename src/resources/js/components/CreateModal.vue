<template>
  <!-- 新規作成モーダルここから -->
  <v-row justify="center">
    <v-dialog v-model="value" persistent max-width="500px">
      <v-card>
        <v-card-title>
          <v-icon class="mr-4">mdi-image-filter-none</v-icon>
          <span class="headliner">Create Label</span>
        </v-card-title>
        <v-card-text>
          <v-container d-flex>
            <v-row>
              <!-- ラベルタイトル入力フォーム -->
              <v-col cols="10">
                <v-text-field
                  label="Title"
                  required
                  prepend-icon="mdi-file-check-outline"
                  v-model="newLabel.title"
                ></v-text-field>
              </v-col>
              <!-- ラベルテキスト入力フォーム -->
              <v-col cols="10">
                <v-text-field
                  label="Text"
                  required
                  prepend-icon="mdi-file-document-outline"
                  v-model="newLabel.text"
                ></v-text-field>
              </v-col>
              <!-- ラベルURL入力フォーム -->
              <v-col cols="10">
                <v-text-field
                  label="URL"
                  prepend-icon="mdi-microsoft-internet-explorer"
                  v-model="newLabel.url"
                ></v-text-field>
                <small>URLは必須ではありません。</small>
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
                    ref="createRadioColor"
                    @click="createRadioColor(index)"
                  ></v-radio>
                </v-radio-group>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="closeCreateModal()">Cancel</v-btn>
          <v-btn text @click="createLabel()">Create</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
  <!-- 新規作成モーダルここまで -->
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
      // 新規作成用データ格納
      newLabel: {
        label_folder_id: '',
        title: '',
        text: '',
        color: '',
        url: ''
      },
      // 新規作成カラー
      createdColor: ''
    }
  },
  watch: {
    // valueの値をwatchしてfalseになれば値をリセット
    value: {
      handler (val) {
        if (val === false) {
          this.clearCreateModal()
        }
      },
      immediate: true
    }
  },
  methods: {
    // 新規作成用カラーをget
    createRadioColor(index) {
      this.createdColor = this.$refs.createRadioColor[index].value
      this.newLabel.color = this.createdColor
    },

    // 新規作成モーダルリセット
    clearCreateModal() {
      this.newLabel.title = ''
      this.newLabel.text = ''
      this.newLabel.url = ''
    },

    // 新規作成モーダル閉じる
    closeCreateModal() {
      this.$emit('input', false)
    },

    // 新規作成データを親コンポーネントにemit
    createLabel() {
      this.$emit('create-label', this.newLabel)
    }
  }
}
</script>