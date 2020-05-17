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
      <!-- 背景画像変更エリア -->
      <v-select 
        class="mt-2" 
        label="background-img" 
        outlined
        prepend-inner-icon="mdi-file-image-outline"
        :items="images"
        item-text="name"
        item-value="url"
        return-object
        v-model="selectedImage"
      ></v-select>
    </v-bottom-navigation>
    <!-- ラベルナビバーここまで -->
    <div class="d-flex">
      <!-- ページネーションコンポーネント -->
      <Pagination
        class="mt-4"
        v-model="page"
        :totalPage="totalPage"
        :afterSearchLabel="afterSearchLabel"
      />
      <!-- ラベルバーテーマ -->
      <v-switch class="switch" v-model="theme" dark></v-switch>
    </div>
    <v-row>
      <!-- ラベル一覧 ここから-->
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
        <v-card raised :color="label.color" ref="labelColor">
          <v-card-title class="title">
            <input type="text" :value="label.title" @blur="editLabelTitle($event, index, label.id)" />
          </v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left dark class="copy-btn" @click="copyToClipboard(index)">mdi-content-copy</v-icon>
            <input
              type="text"
              :value="label.text"
              ref="labelText"
              @blur="editLabelText($event, index, label.id)"
            />
          </v-card-subtitle>
          <div class="text-right">
            <!-- ドラッグボタン -->
            <v-icon class="draggable" left dark>mdi-gesture-swipe</v-icon>
            <!-- カラー変更ボタン -->
            <v-icon @click="editColorModal(index, label.id)" left dark>mdi-pencil</v-icon>
            <!-- URLボタン -->
            <a v-if="label.url" :href="label.url" target="_blank">
              <v-icon left dark>mdi-microsoft-internet-explorer</v-icon>
            </a>
            <!-- URL変更ボタン -->
            <v-icon v-if="label.url" left dark @click="editUrlModal(label.id)">mdi-microsoft-windows</v-icon>
            <!-- URL 追加ボタン -->
            <v-icon v-else left dark @click="addUrlModal(label.id)">mdi-microsoft-windows</v-icon>
            <!-- ラベル削除ボタン -->
            <v-icon left dark @click="deleteLabel(label.id, index)">mdi-delete</v-icon>
          </div>
        </v-card>
      </v-col>
      <!-- ラベル一覧 ここまで -->
      <!-- 新規登録モーダルコンポーネント -->
      <CreateModal :colors="colors" @create-label="createLabel" v-model="createModal" />
      <!-- カラー編集モーダルコンポーネント -->
      <ColorModal :colors="colors" @edit-label-color="editLabelColor" v-model="colorModal" />
      <!-- URL追加及び編集モーダル -->
      <UrlModal :editUrl="editUrl" @edit-label-url="editLabelUrl" v-model="urlModal" />

      <!-- <div class="text-center">
    <v-snackbar
      v-model="snackbar"
      color="red"
      top
      vertical
      left
      :timeout="timeout"
    >
      <ul>
        <li>{{ text1 }}</li>
        <li>{{ text2 }}</li>
      </ul>
     
    </v-snackbar>
  </div>
      -->
    </v-row>
  </v-container>
</template>

<script>
import Pagination from './Pagination.vue'
import CreateModal from './CreateModal.vue'
import ColorModal from './ColorModal.vue'
import UrlModal from './UrlModal.vue'
export default {
  components: {
    Pagination,
    CreateModal,
    ColorModal,
    UrlModal
  },
  // 親コンポーネントから選択されたフォルダidをもらう
  props: {
    value: ''
  },
  data() {
    return {
      // snackbar: true,
      // text1: 'フォルダタイトルは20文字以下です。',
      // text2: 'フォルダタイトルは必須です。',
      // timeout: 10000,
      // ラベルデータ格納
      labels: '',
      // 新規作成モーダル
      createModal: false,
      // カラー変更モーダル
      colorModal: false,
      // カラー変更前のラベルのカラー
      beforeChangeColor: '',
      // カラー変更前のラベルid
      beforeChangeLabelId: '',
      // URL追加及び編集用モーダル
      urlModal: false,
      // URL追加及び編集用モーダル切り替え
      editUrl: false,
      // URL追加もしくは編集したいラベルのid
      urlId: '',
      // 検索ワード
      keyword: '',
      // カラー検索用
      selectedColor: '',
      // darkテーマ切り替え
      theme: false,
      // 現在のページ番号
      page: 1,
      // 1ページあたりのラベル数
      perPage: 12,
      // ページ総数
      totalPage: 1,
      // 検索で絞ったあとのラベル数
      afterSearchLabel: 1,
      // colors新規作成、編集用
      colors: ['red', 'pink', 'purple', 'indigo', 'blue', 'cyan', 'teal', 'green', 'yellow', 'orange', 'grey', 'white'],
      // background-image用
      images: [ 
        { name: 'dark', url: '/img/ramiro-mendes-CjS3QsRuxnE-unsplash.jpg'},
        { name: 'light', url: '/img/markus-spiske-zJDqiEGUCHY-unsplash.jpg'},
        { name: 'board', url: '/img/joanna-kosinska-1_CMoFsPfso-unsplash.jpg'},
      ],
      // 選択されたbackground-image
      selectedImage: {
        name: '',
        url: ''
      }
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
        this.totalPage = Math.ceil(this.labels.length / this.perPage)
        // folder_idがnullならばlabelsをリセット
      } else {
        this.labels = ''
        this.totalPage = 1
      }
    },
    theme: {
      handler () {
        this.$store.commit('label/SET_LABEL_THEME', this.theme)
      }
    },
    // background-imgの変更を監視する
    selectedImage: {
      handler (val) {
        if(val.name !== "" && val.url !== "") {
          this.$store.commit('label/SET_BACKGROUND_IMG', this.selectedImage)
        }
      },
      immediate: true
    },
  },

  created () {
    this.theme = this.getLabelTheme
    this.selectedImage = this.getBackgroundImg
  },

  methods: {

    // カラー変更モーダルオープン&カラー変更するラベルの色とidをget
    editColorModal(index, id) {
      this.colorModal = true
      this.beforeChangeColor = this.$refs.labelColor[index].color
      this.beforeChangeLabelId = id
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
    async createLabel(newLabel) {
      // 現在開いているフォルダidを代入
      newLabel.label_folder_id = this.value
      const response = await axios.post('api/label', newLabel)
      this.labels.push(response.data)
      this.createModal = false
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
    async editLabelColor(newColor) {
      if (newColor !== this.beforeChangeLabelColor) {
        const response = await axios.patch(
          'api/label/' + this.beforeChangeLabelId,
          { color: newColor }
        )
        let labelsIndex = ''
        this.labels.map((label, index) => {
          if (label.id === this.beforeChangeLabelId) {
            labelsIndex = index
          }
        })
        this.labels[labelsIndex].color = newColor
      }
      this.colorModal = false
    },

    // ラベルURL追加及び更新 patch
    async editLabelUrl(newUrl) {
      const response = await axios.patch('api/label/' + this.urlId, {
        url: newUrl
      })
      let labelsIndex = ''
      this.labels.map((label, index) => {
        if (label.id === this.urlId) {
          labelsIndex = index
        }
      })
      this.labels[labelsIndex].url = newUrl
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

    getLabelTheme () {
      return this.$store.state.label.labelTheme
    },

    getBackgroundImg() {
      return this.$store.state.label.backgroundImg
      
    },

    // カラー検索用カラー配列作成 先頭に空文字を挿入する
    searchColors () {
      // カラー配列のコピーを作成
      const searchColors = this.colors.slice()
      // 先頭に空文字を追加して返す
      searchColors.unshift('')
      return searchColors
    },

    // ラベル検索
    filteredLabels() {
      // 空配列をもつ変数をセット
      var filteredLabels = []
      // キーワードとキーワードを小文字にしたものを変数に代入
      // v-modelのkeywordに変更があれば、その都度このcomputedが走る
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
      // 検索で絞ったあとのラベル数をget
      this.afterSearchLabel = filteredLabels.length
      // keyowordの文字列が存在したものだけ格納された配列を12ラベルごとにスライスしてreturn
      // v-modelのpageに変更があれば、その都度このcomputedが走る
      return filteredLabels.slice(
        (this.page - 1) * this.perPage,
        this.page * this.perPage
      )
    }
  }
}
</script>

<style scoped>
.v-content .v-card.v-sheet.theme--light {
  background-color: rgb(49, 48, 48) !important;
  border-left-width: 30px !important;
  border-left-style: solid !important;
}
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
  padding-right: 0;
  padding-top: 5px;
  padding-bottom: 20px;
  height: 50px;
}
.subtitle {
  font-size: 15px;
  padding-left: 10px;
  padding-right: 0;
  padding-bottom: 0;
  padding-top: 5px;
  height: 25px;
}
.copy-btn {
  margin-right: 0;
}
.draggable {
  cursor: pointer;
}
input {
  width: 85%;
  height: 25px;
  color: white;
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande',
    'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}
a {
  text-decoration: none;
}
</style>