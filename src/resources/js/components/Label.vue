<template>
  <v-container>
    <!-- ラベルナビバーここから -->
    <v-bottom-navigation class="labelbar" height="70px" :dark="theme">
      <!-- 新規作成ボタン -->
      <v-btn :disabled="!value" @click="createModal = true">
        Create Label
        <v-icon class="pt-3">mdi-image-filter-none</v-icon>
      </v-btn>
      <!-- 検索エリア -->
      <v-text-field
        class="mt-2"
        outlined
        label="Search Label"
        append-icon="mdi-magnify"
        v-model="keyword"
      ></v-text-field>
      <!-- color検索エリア -->
      <v-select
        class="mt-2"
        label="Search of color"
        outlined
        prepend-inner-icon="mdi-file-search"
        :items="searchColors"
        v-model="selectedColor"
      ></v-select>
      <v-select class="mt-2" label="sort" outlined></v-select>
    </v-bottom-navigation>
    <!-- ラベルナビバーここまで -->
    <!-- ラベルバーテーマ -->
    <v-switch class="switch" dark v-model="theme"></v-switch>
    <!-- ラベル一覧 ここから-->
    <v-row>
      <v-col 
        cols="4" 
        class="label" 
        v-for="(label, index) in filteredLabels" 
        :key="label.id"
        draggable
        @dragover.prevent
        @dragenter.prevent
        @dragstart="pickupLabel($event, index)"
        @drop="moveLabel($event, index)"
      >
        <v-card raised dark :color="label.color" ref="labelColor">
          <v-card-title class="title">
            <input type="text" :value="label.title" @blur="editLabelTitle($event, index, label.id)" />
          </v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left class="copy-btn" @click="copyToClipboard(index)">mdi-content-copy</v-icon>
            <input
              type="text"
              :value="label.text"
              ref="labelText"
              @blur="editLabelText($event, index, label.id)"
            />
          </v-card-subtitle>
          <div class="text-right">
            <!-- ドラッグボタン -->
            <v-icon class="draggable" left>mdi-gesture-swipe</v-icon>
            <!-- カラー変更ボタン -->
            <v-icon @click="editColorModal(index, label.id)" left>mdi-pencil</v-icon>
            <!-- URLボタン -->
            <a v-if="label.url" :href="label.url" target="_blank">
              <v-icon left>mdi-microsoft-internet-explorer</v-icon>
            </a>
            <!-- URL変更ボタン -->
            <v-icon v-if="label.url" left @click="editUrlModal(label.id)">mdi-microsoft-windows</v-icon>
            <!-- URL 追加ボタン -->
            <v-icon left v-else @click="addUrlModal(label.id)">mdi-microsoft-windows</v-icon>
            <!-- ラベル削除ボタン -->
            <v-icon @click="deleteLabel(label.id, index)" left>mdi-delete</v-icon>
          </div>
        </v-card>
      </v-col>
      <!-- ラベル一覧 ここまで -->
      <!-- 新規作成モーダルここから -->
      <v-row justify="center">
        <v-dialog v-model="createModal" persistent max-width="500px">
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
              <v-btn text @click="clearCreateModal()">Cancel</v-btn>
              <v-btn text @click="createLabel()">Create</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
      <!-- 新規作成モーダルここまで -->
      <!-- カラー変更モーダルここから -->
      <v-row justify="center">
        <v-dialog v-model="colorModal" scrollable max-width="250px">
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
                  ref="editRadioColor"
                  @click="editRadioColor(index)"
                ></v-radio>
              </v-radio-group>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="grey" text @click="colorModal = false">Cancel</v-btn>
              <v-btn color="success" text @click="editLabelColor()">Update</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
      <!-- カラー変更モーダルここまで -->
      <!-- URL追加及び編集モーダルここから -->
      <v-row justify="center">
        <v-dialog v-model="urlModal" persistent max-width="350">
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
                <v-btn color="black" text @click="clearUrlModal()">Cancel</v-btn>
                <v-btn color="primary" text @click="editLabelUrl()">Submit</v-btn>
              </v-card-actions>
            </v-container>
          </v-card>
        </v-dialog>
      </v-row>
    </v-row>
  </v-container>
</template>

<script>
export default {
  // 親コンポーネントから選択されたフォルダidをもらう
  props: {
    value: ''
  },
  data() {
    return {
      // ラベルデータ格納
      labels: '',
      // 新規作成用データ格納
      newLabel: {
        label_folder_id: '',
        title: '',
        text: '',
        color: '',
        url: ''
      },
      // 新規作成モーダル
      createModal: false,
      // 新規作成カラー
      createdColor: '',
      // カラー変更モーダル
      colorModal: false,
      // カラー変更前のラベルのカラー
      beforeChangeColor: '',
      // カラー変更前のラベルid
      beforeChangeLabelId: '',
      // 変更したいカラー
      changedColor: '',
      // URL追加及び編集用モーダル
      urlModal: false,
      // URL追加及び編集用モーダル
      editUrl: false,
      // URL追加もしくは編集したいラベルのid
      urlId: '',
      // 追加もしくは変更したいURL
      newUrl: '',
      // 検索ワード
      keyword: '',
      // カラー検索用
      selectedColor: '',
      // darkテーマ切り替え
      theme: false,
      // colors新規作成、編集用
      colors: [
        'red',
        'indigo',
        'black',
        'grey',
        'cyan',
        'pink',
        'teal',
        'blue',
        'green'
      ]
    }
  },
  // propsのvalue つまり selectedFolderを監視
  watch: {
    value: async function(folder_id) {
      const selected_id = folder_id
      // folder_idがnullでなければapiを叩いてデータをリクエスト
      if (selected_id !== null) {
        const response = await axios.get('api/label/' + folder_id)
        this.labels = response.data
        // folder_idがnullならばlabelsをリセット
      } else {
        this.labels = ''
      }
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
      this.createModal = false
    },

    // カラー変更モーダルオープン&カラー変更するラベルの色とidをget
    editColorModal(index, id) {
      this.colorModal = true
      this.beforeChangeColor = this.$refs.labelColor[index].color
      this.beforeChangeLabelId = id
    },

    // 変更したいカラーをget
    editRadioColor(index) {
      this.changedColor = this.$refs.editRadioColor[index].value
    },

    // addUrlModalを開く
    addUrlModal(id) {
      this.urlModal = true
      this.editUrl = false
      this.urlId = id
    },

    // editUrlModalを開く
    editUrlModal(id) {
      this.urlModal = true
      this.editUrl = true
      this.urlId = id
    },

    // urlModalを閉じる
    clearUrlModal() {
      this.newUrl = ''
      this.urlModal = false
    },

    // クリックしたテキストをクリップボードにコピー
    copyToClipboard(index) {
      const copyText = this.$refs.labelText[index].value
      navigator.clipboard.writeText(copyText)
    },

    pickupLabel(e, index) {
      e.dataTransfer.effectAllowed = 'move'
      e.dataTransfer.dropEffect = 'move'
      e.dataTransfer.setData('from-label-index', index)
    },

    moveLabel(e, toLabelIndex) {
      const fromLabelIndex = e.dataTransfer.getData('from-label-index')
      const labelToMove = this.labels.splice(fromLabelIndex, 1)[0]
      this.labels.splice(toLabelIndex, 0, labelToMove)
    },
    
    // ラベル新規作成 post
    async createLabel() {
      // 現在開いているフォルダidを代入
      this.newLabel.label_folder_id = this.value
      const response = await axios.post('api/label', this.newLabel)
      this.labels.push(response.data)
      this.clearCreateModal()
    },

    // ラベルタイトル更新 patch
    async editLabelTitle(e, index, id) {
      // 変更があったinputを取得し変数に代入
      const changedTitle = e.target.value
      // タイトルの変更があれば、apiで更新を行う
      if (changedTitle !== this.labels[index].title) {
        const response = await axios.patch('api/label/' + id, {
          title: changedTitle
        })
        let labelsIndex = ''
        this.labels.map((label, index) => {
          // 変更があったラベルのidと一致するラベルを探す
          if (label.id === id) {
            labelsIndex = index
          }
        })
        // 一致したラベルのタイトルに変更されたタイトルを代入
        this.labels[labelsIndex].title = changedTitle
      }
      // タイトルに変更がなければfalseを返して終了
      return false
    },

    // ラベルテキスト更新 patch
    async editLabelText(e, index, id) {
      // 変更があったinputを取得し変数に代入
      const changedText = e.target.value
      // タイトルの変更があれば、apiで更新を行う
      if (changedText !== this.labels[index].text) {
        const response = await axios.patch('api/label/' + id, {
          text: changedText
        })
        let labelsIndex = ''
        this.labels.map((label, index) => {
          // 変更があったラベルのidと一致するラベルを探す
          if (label.id === id) {
            labelsIndex = index
          }
        })
        // 一致したラベルのタイトルに変更されたタイトルを代入
        this.labels[labelsIndex].text = changedText
      }
      // タイトルに変更がなければfalseを返して終了
      return false
    },

    // ラベルカラー更新 patch
    async editLabelColor() {
      if (this.changedColor !== this.beforeChangeLabelColor) {
        const response = await axios.patch(
          'api/label/' + this.beforeChangeLabelId,
          { color: this.changedColor }
        )
        let labelsIndex = ''
        this.labels.map((label, index) => {
          if (label.id === this.beforeChangeLabelId) {
            labelsIndex = index
          }
        })
        this.labels[labelsIndex].color = this.changedColor
      }
      this.colorModal = false
    },

    // ラベルURL追加及び更新 patch
    async editLabelUrl() {
      const response = await axios.patch('api/label/' + this.urlId, {
        url: this.newUrl
      })
      let labelsIndex = ''
      this.labels.map((label, index) => {
        if (label.id === this.urlId) {
          labelsIndex = index
        }
      })
      this.labels[labelsIndex].url = this.newUrl
      this.newUrl = ''
      this.urlModal = false
    },

    // ラベル削除 delete
    async deleteLabel(id, index) {
      if (confirm('are you sure?')) {
        const response = await axios.delete('api/label/' + id)
        this.labels.splice(index, 1)
      }
      return false
    }
  },
  computed: {
    // ラベル検索
    filteredLabels() {
      // 空配列をもつ変数をセット
      var filteredLabels = []
      // キーワードとキーワードを小文字にしたものを変数に代入
      var searchWord = this.keyword && this.keyword.toLowerCase()
      for (var i in this.labels) {
        // apiでgetしたlabelsをfor文で一つずつ変数に代入していく
        var label = this.labels[i]
        // titleもしくはtextの中でkeywordと一致する文字列(大文字小文字の区別はなし)があればfilteredLabelsにpush
        if (
          label.title.toLowerCase().indexOf(searchWord) !== -1 ||
          label.text.toLowerCase().indexOf(searchWord) !== -1
        ) {
          // electedColorがfalseならばfilteredLabelsにpush
          if (!this.selectedColor) {
            filteredLabels.push(label)
            // selectedColorがtrueならば一致した場合のみpush
          } else {
            if (label.color === this.selectedColor) {
              filteredLabels.push(label)
            }
          }
        }
      }
      // keyowordの文字列が存在したものだけ格納された配列を返す
      return filteredLabels
    },
    
    // カラー検索用カラー配列作成
    searchColors() {
      // カラー配列のコピーを作成
      const searchColors = this.colors.slice()
      // 先頭に空文字を追加して返す
      searchColors.unshift('')
      return searchColors
    }
  }
}
</script>

<style scoped>
/* .v-content .v-card.v-sheet.theme--light {
    background-color: white !important;
    border-left: 8px solid rgb(30, 112, 219) !important;
} */
.labelbar {
  margin-top: 5px;
}
.switch {
  width: 50px;
  height: 10px;
  margin-bottom: 20px;
  margin-left: auto;
}
.label {
  transition: all .9s;
}
.label:hover {
  transform: scale(1.08, 1.08);
}
.title {
  padding-left: 14px;
  padding-top: 5px;
  padding-bottom: 20px;
}
.subtitle {
  font-size: 14px;
  padding-left: 10px;
  padding-bottom: 0;
  padding-top: 5px;
  height: 30px;
}
.copy-btn {
  margin-right: 0;
}
.draggable {
  cursor: pointer;
}
input {
  width: 90%;
  color: rgb(245, 243, 243);
}
a {
  text-decoration: none;
}
</style>