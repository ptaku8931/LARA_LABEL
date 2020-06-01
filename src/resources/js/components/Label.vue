<template>
  <v-container>
    <!-- ラベルナビバーここから -->
    <v-bottom-navigation class="labelbar" height="70px" dark outlined v-show="labels">
      <!-- 新規作成ボタン -->
      <v-btn :disabled="!getCurrentFolderId" @click="createModal = true">
        Create Label
        <v-icon>mdi-card-plus-outline</v-icon>
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
        label="Search by color"
        outlined
        prepend-inner-icon="mdi-file-search"
        :items="searchColors"
        v-model="selectedColor"
      ></v-select>
      <!-- 背景画像変更エリア -->
      <v-select
        class="mt-2"
        label="background-image"
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
    <v-row>
      <!-- ラベル一覧 ここから-->
      <v-col
        cols="12"
        md="4"
        class="label"
        v-for="(label, index) in filteredLabels"
        :key="label.id"
        draggable
        @dragover.prevent
        @dragenter.prevent
        @dragstart="pickupLabel($event, index)"
        @drop="moveLabel($event, index)"
        @mouseover="showBtn(index)"
        @mouseleave="hideBtn(index)"
      >
        <v-card raised :color="label.color" ref="labelColor" class="cardBody">
          <v-card-title class="title">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <input
                  type="text"
                  :value="label.title"
                  @change="editLabelTitle($event, index, label.id)"
                  v-on="on"
                />
              </template>
              <span>Please press enter key if you change title</span>
            </v-tooltip>
          </v-card-title>
          <v-card-subtitle class="subtitle">
            <v-tooltip bottom>
              <template v-slot:activator="{ on }">
                <v-icon
                  left
                  dark
                  class="copy-btn"
                  @click="copyToClipboard(index)"
                  v-on="on"
                >mdi-content-copy</v-icon>
              </template>
              <span>Copy Text</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <input
                  type="text"
                  :value="label.text"
                  ref="labelText"
                  @change="editLabelText($event, index, label.id)"
                  v-on="on"
                />
              </template>
              <span>Please press enter key if you change text</span>
            </v-tooltip>
          </v-card-subtitle>
          <div class="text-right" v-show="isBtn && index === btnIndex">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <!-- snippet追加ボタン -->
                <v-icon v-if="label.snippet === null" left dark v-on="on" @click="addSnippetModal(label.id)">mdi-text-box-outline</v-icon>
                <!-- snippet編集ボタン -->
                <v-icon v-else left dark v-on="on" @click="editSnippetModal(label.id, label.snippet)">mdi-text-box-check-outline</v-icon>
              </template>
              <span>Snippet</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <!-- カラー変更ボタン -->
                <v-icon @click="editColorModal(index, label.id)" left dark v-on="on">mdi-pencil</v-icon>
              </template>
              <span>Edit Color</span>
            </v-tooltip>
            <a v-if="label.url" :href="label.url" target="_blank">
              <v-tooltip top>
                <template v-slot:activator="{ on }">
                  <!-- URLボタン -->
                  <v-icon left dark v-on="on">mdi-microsoft-internet-explorer</v-icon>
                </template>
                <span>Bookmark</span>
              </v-tooltip>
            </a>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <!-- URL変更ボタン -->
                <v-icon
                  v-if="label.url"
                  left
                  dark
                  @click="editUrlModal(label.id)"
                  v-on="on"
                >mdi-microsoft-windows</v-icon>
                <!-- URL 追加ボタン -->
                <v-icon
                  v-else
                  left
                  dark
                  @click="addUrlModal(label.id)"
                  v-on="on"
                >mdi-microsoft-windows</v-icon>
              </template>
              <span>Add or Edit URL</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <!-- ラベル削除ボタン -->
                <v-icon left dark @click="deleteConfirm(label.id, index)" v-on="on">mdi-delete</v-icon>
              </template>
              <span>Delete Label</span>
            </v-tooltip>
          </div>
        </v-card>
      </v-col>
      <!-- ラベル一覧 ここまで -->
      <!-- ページネーションコンポーネント -->
      <div class="pagination">
        <Pagination
          class="mt-4"
          v-model="page"
          :totalPage="totalPage"
          :afterSearchLabel="afterSearchLabel"
        />
      </div>
      <!-- 新規登録モーダルコンポーネント -->
      <CreateModal 
        :colors="colors" 
        @create-label="createLabel" 
        v-model="createModal" 
      />
      <!-- カラー編集モーダルコンポーネント -->
      <ColorModal 
        :colors="colors" 
        :beforeChangeColor="beforeChangeColor" 
        @edit-label-color="editLabelColor" 
        v-model="colorModal" 
      />
      <!-- URL追加及び編集モーダルコンポーネント -->
      <UrlModal 
        :editUrl="editUrl" 
        @edit-label-url="editLabelUrl"
        v-model="urlModal" 
      />
      <!-- 削除確認モーダルコンポーネント -->
      <ConfirmModal 
        @do-delete="deleteLabel" 
        v-model="confirmModal" 
      />
      <!-- Snippetモーダルコンポーネント -->
      <SnippetModal 
        :snippetValue="snippetValue" 
        :addSnippet="addSnippet" 
        @edit-snippet="editSnippet" 
        v-model="snippetModal" 
      />
    </v-row>
  </v-container>
</template>

<script>
import Pagination from './Pagination.vue'
import CreateModal from './CreateModal.vue'
import ColorModal from './ColorModal.vue'
import UrlModal from './UrlModal.vue'
import ConfirmModal from './ConfirmModal.vue'
import SnippetModal from './SnippetModal.vue'
import { OK, CREATED, VALIDATION_ERROR } from '../error_code'
export default {
  components: {
    Pagination,
    CreateModal,
    ColorModal,
    UrlModal,
    ConfirmModal,
    SnippetModal
  },
  data() {
    return {
      // ラベルデータ格納
      labels: '',
      // ホバーでボタン出現
      isBtn: false,
      // ボタンindex番号
      btnIndex: null,
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
      // 削除確認用モーダル
      confirmModal: false,
      // 削除するラベルのid
      deleteId: '',
      // 削除するラベルのインデックス
      deleteIndex: '',
      // snippetモーダル
      snippetModal: false,
      // snippetを追加するラベルのid
      snippetId: '',
      // snippetの値
      snippetValue: '',
      // snippetモーダル切り替え
      addSnippet: false,
      // 検索ワード
      keyword: '',
      // カラー検索用
      selectedColor: '',
      // 現在のページ番号
      page: 1,
      // 1ページあたりのラベル数
      perPage: 12,
      // ページ総数
      totalPage: 1,
      // 検索で絞ったあとのラベル数
      afterSearchLabel: 1,
      // colors新規作成、編集用
      colors: ['indigo', 'blue', 'cyan', 'green', 'teal', 'yellow', 'orange', 'pink', 'red', 'purple', 'grey', 'white'],
      // background-image用
      images: [
        { name: 'White', url: '/img/the-phope-9X1rJClbnmg-unsplash.jpg' },
        { name: 'Sunset', url: '/img/frank-mckenna-4V8JxijgZ_c-unsplash.jpg' },
        { name: 'Sunrise', url: '/img/frank-mckenna-OD9EOzfSOh0-unsplash.jpg' },
        { name: 'Dark', url: '/img/jez-timms-r4lM2v9M84Q-unsplash.jpg' },
        { name: 'Snow', url: '/img/chandler-cruttenden-w8hWTFpGtpY-unsplash.jpg' },
        { name: 'Galaxy', url: '/img/neven-krcmarek-3ym-ev0Pe58-unsplash.jpg' },
        { name: 'Blossom', url: '/img/masaaki-komori-1hUsp3zi0rA-unsplash.jpg' },
        { name: 'Sky', url: '/img/jason-charters-9YTghY140zA-unsplash.jpg' },
        { name: 'Night', url: '/img/luca-bravo-a_hPPrncGlQ-unsplash.jpg' },
      ],
      // 選択されたbackground-image defaultはsunset
      selectedImage: {
        name: 'Sunset',
        url: '/img/frank-mckenna-4V8JxijgZ_c-unsplash.jpg'
      }
    }
  },
  // stateのcurrentFolderIdを監視
  watch: {
    immediate: true,
    getCurrentFolderId: async function(folder_id) {
      // folder_idがnullでなければapiを叩いてデータをリクエスト
      if (folder_id !== null) {
        const response = await axios.get('api/label/' + folder_id)
        if (response.status === OK) {
          this.labels = response.data
          // ページ総数は、ラベルの配列個数をperPage(12)で割った数を切り上げ
          this.totalPage = Math.ceil(this.labels.length / this.perPage)
        }
        this.$store.commit('error/SET_CODE', response.status)
      } else {
        // folder_idがnullならばlabelsをリセット
        this.labels = ''
        this.totalPage = 1
      }
    },
    // background-imgの変更を監視する

    selectedImage: {
      immediate: true,
      handler() {
        this.$store.commit('label/SET_BACKGROUND_IMG', this.selectedImage)
      }
    }
  },

  methods: {
    // ホバーでボタン出現
    showBtn(index) {
      this.isBtn = true
      this.btnIndex = index
    },

    // ホバーアウトでボタン隠す
    hideBtn(index) {
      this.isBtn = false
    },

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

    // 削除確認用モーダルを開く
    deleteConfirm(id, index) {
      this.confirmModal = true
      this.deleteId = id
      this.deleteIndex = index
    },

    // snippetモーダル開く(add)
    addSnippetModal(id) {
      this.snippetModal = true
      this.snippetId = id
      this.snippetValue = ''
      this.addSnippet = true
    },

    // snippetモーダル開く(edit)
    editSnippetModal(id, snippet) {
      this.snippetModal = true
      this.snippetId = id
      this.snippetValue = snippet
      this.addSnippet = false
    },

    // クリックしたテキストをクリップボードにコピー
    async copyToClipboard(index) {
      this.$store.commit('message/SET_SUCCESS_MSG', null)
      const copyText = await this.$refs.labelText[index].value
      navigator.clipboard.writeText(copyText)
      this.$store.commit(
        'message/SET_SUCCESS_MSG',
        'The text is successfully copied to the clipboard !!'
      )
    },

    // ラベル drag
    pickupLabel(e, index) {
      e.dataTransfer.effectAllowed = 'move'
      e.dataTransfer.dropEffect = 'move'
      // もしページが1より大きいならindex番号にページ数*12 で合わせる
      if (this.page > 1) {
        e.dataTransfer.setData('from-label-index', index + (this.page - 1) * 12)
      } else {
        e.dataTransfer.setData('from-label-index', index)
      }
    },

    // ラベル drop
    async moveLabel(e, toLabelIndex) {
      // drag開始のindex番号をget
      const fromLabelIndex = e.dataTransfer.getData('from-label-index')
      // もし出発点と終着点が同じならば強制終了
      if (fromLabelIndex == toLabelIndex) {
        return false
      } else {
        // 出発点のラベルをspliceで切り取る
        const labelToMove = this.labels.splice(fromLabelIndex, 1)[0]
        // もしページが1より大きいならindex番号にページ数*12 で合わせる
        // 終着点のindex番号にspliceで追加する
        if (this.page > 1) {
          this.labels.splice(toLabelIndex + (this.page - 1) * 12, 0, labelToMove)
        } else {
          this.labels.splice(toLabelIndex, 0, labelToMove)
        }
        this.$store.commit('message/SET_SUCCESS_MSG', null)
        const response = await axios.put('api/Ldragdrop', this.labels)
        if (response.status === OK) {
          // 更新が終わったら新しい配列を再びfetch
          const response = await axios.get('api/label/' + this.getCurrentFolderId)
          if (response.status === OK) {
            // 新しい配列をget
            this.labels = response.data
            this.totalPage = Math.ceil(this.labels.length / this.perPage)
            this.$store.commit(
            'message/SET_SUCCESS_MSG',
            'Success drag and drop !!'
            )
          } else {
            this.$store.commit('error/SET_CODE', response.status)
          }
        }
        this.$store.commit('error/SET_CODE', response.status)
      }
    },

    // ラベル新規作成 post
    async createLabel(newLabel) {
      this.$store.commit('message/SET_SUCCESS_MSG', null)
      // 現在開いているフォルダidを代入してコントローラーに渡す
      newLabel.label_folder_id = this.getCurrentFolderId
      const response = await axios.post('api/label', newLabel)
      if (response.status === CREATED) {
        this.labels.push(response.data)
        // モーダルを閉じる
        this.createModal = false
        // もし新ページにはみ出る場合は
        if (this.labels.length % 12 === 1 && this.labels.length !== 1) {
          // 新データをfetch
          const response = await axios.get('api/label/' + this.getCurrentFolderId)
          if(response.status === OK) {
            this.labels = response.data
            // ページを追加
            this.page++
            // トータルページを更新
            this.totalPage = Math.ceil(this.labels.length / this.perPage)
            this.$store.commit('label/SET_CURRENT_PAGE', this.page)
          }
          this.$store.commit('error/SET_CODE', response.status)
        }
        this.$store.commit(
          'message/SET_SUCCESS_MSG',
          'The new label was created successfully !!'
        )
      }
      this.$store.commit('error/SET_CODE', response.status)
    },

    // ラベルタイトル更新 patch
    async editLabelTitle(e, index, id) {
      // 変更があったinputを取得し変数に代入
      const changedTitle = e.target.value
      // タイトルの変更があれば、apiで更新を行う
      if (
        changedTitle !== this.labels[index].title &&
        changedTitle !== '' &&
        changedTitle.length < 30
      ) {
        this.$store.commit('message/SET_SUCCESS_MSG', null)
        const response = await axios.patch('api/label/' + id, {
          title: changedTitle
        })
        if (response.status === OK) {
          let labelsIndex = ''
          this.labels.map((label, index) => {
            // 変更があったラベルのidと一致するラベルを探す
            if (label.id === id) {
              labelsIndex = index
            }
          })
          // 一致したラベルのタイトルに変更されたタイトルを代入
          this.labels[labelsIndex].title = changedTitle
          this.$store.commit(
            'message/SET_SUCCESS_MSG',
            'The label was updated successfully !!'
          )
        }
        this.$store.commit('error/SET_CODE', response.status)
      }
      // nullの場合はバリデーションエラー表示
      if (changedTitle === '') {
        await this.$store.commit('message/SET_ERROR_MSG', null)
        this.$store.commit('message/SET_ERROR_MSG', 'The title is required !!')
      }
      // 31字以上の場合はバリデーションエラー表示
      if (changedTitle.length > 30) {
        await this.$store.commit('message/SET_ERROR_MSG', null)
        this.$store.commit(
          'message/SET_ERROR_MSG',
          'The title must be less than 30 characters !!'
        )
      }
      // タイトルに変更がなければfalseを返して終了
      return false
    },

    // ラベルテキスト更新 patch
    async editLabelText(e, index, id) {
      // 変更があったinputを取得し変数に代入
      const changedText = e.target.value
      // テキストの変更があれば、apiで更新を行う
      if (
        changedText !== this.labels[index].text &&
        changedText !== '' &&
        changedText.length < 50
      ) {
        this.$store.commit('message/SET_SUCCESS_MSG', null)
        const response = await axios.patch('api/label/' + id, {
          text: changedText
        })
        if (response.status === OK) {
          let labelsIndex = ''
          this.labels.map((label, index) => {
            // 変更があったラベルのidと一致するラベルを探す
            if (label.id === id) {
              labelsIndex = index
            }
          })
          // 一致したラベルのテキストに変更されたテキストを代入
          this.labels[labelsIndex].text = changedText
          this.$store.commit(
            'message/SET_SUCCESS_MSG',
            'The label was updated successfully !!'
          )
        }
        this.$store.commit('error/SET_CODE', response.status)
      }
      // nullの場合はバリデーションエラー表示
      if (changedText === '') {
        await this.$store.commit('message/SET_ERROR_MSG', null)
        this.$store.commit('message/SET_ERROR_MSG', 'The text is required !!')
      }
      // 51字以上の場合はバリデーションエラー表示
      if (changedText.length > 50) {
        await this.$store.commit('message/SET_ERROR_MSG', null)
        this.$store.commit(
          'message/SET_ERROR_MSG',
          'The text must be less than 50 characters !!'
        )
      }
      // テキストに変更がなければfalseを返して終了
      return false
    },

    // ラベルカラー更新 patch
    async editLabelColor(newColor) {
      // もしカラーに変更があれば
      if (newColor !== this.beforeChangeLabelColor) {
        this.$store.commit('message/SET_SUCCESS_MSG', null)
        const response = await axios.patch(
          'api/label/' + this.beforeChangeLabelId,
          { color: newColor }
        )
        if (response.status === OK) {
          let labelsIndex = ''
          this.labels.map((label, index) => {
            if (label.id === this.beforeChangeLabelId) {
              labelsIndex = index
            }
          })
          // idが一致するものを見つけて更新
          this.labels[labelsIndex].color = newColor
          // 変更する前のカラーデータをリセット
          this.beforeChangeLabelColor = ''
          this.beforeChangeLabelId = ''
          this.$store.commit(
            'message/SET_SUCCESS_MSG',
            'The label was updated successfully !!'
          )
        }
        this.$store.commit('error/SET_CODE', response.status)
      }
      // 変更がなければfalse
      this.colorModal = false
    },

    // ラベルURL追加及び更新 patch
    async editLabelUrl(newUrl) {
      this.$store.commit('message/SET_SUCCESS_MSG', null)
      const response = await axios.patch('api/label/' + this.urlId, {
        url: newUrl
      })
      if (response.status === OK) {
        let labelsIndex = ''
        this.labels.map((label, index) => {
          if (label.id === this.urlId) {
            labelsIndex = index
          }
        })
        // idが一致するものを見つけて更新
        this.labels[labelsIndex].url = newUrl
        this.$store.commit(
          'message/SET_SUCCESS_MSG',
          'The label was updated successfully !!'
        )
      }
      this.$store.commit('error/SET_CODE', response.status)
    },
     
     //  snippet追加及び編集
     async editSnippet(newSnippet) {
      this.$store.commit('message/SET_SUCCESS_MSG', null)
      const response = await axios.patch('api/label/' + this.snippetId, {
        snippet: newSnippet })
      if (response.status === OK) {
        let labelsIndex = ''
        this.labels.map((label, index) => {
          if (label.id === this.snippetId) {
            labelsIndex = index
          }
        })
        // idが一致するものを見つけて更新
        this.labels[labelsIndex].snippet = newSnippet
        this.$store.commit(
          'message/SET_SUCCESS_MSG',
          'The Snippet was updated successfully !!'
        )
      }
      this.$store.commit('error/SET_CODE', response.status)
    },

    // ラベル削除 delete
    async deleteLabel() {
      this.$store.commit('message/SET_SUCCESS_MSG', null)
      const response = await axios.delete('api/label/' + this.deleteId)
      if (response.status === OK) {
        // もしページが1より大きいならindex番号にページ数-1 * 12 で合わせる
        if (this.page > 1) {
          this.labels.splice(this.deleteIndex + (this.page - 1) * 12, 1)
          const response = await axios.get('api/label/' + this.getCurrentFolderId)
          if(response.status === OK) {
            this.labels = response.data
          }
        } else {
          // ラベルからspliceで削除
          this.labels.splice(this.deleteIndex, 1)
        }
        // もし新ページの最後の一つだった場合
        if (this.labels.length % 12 === 0 && this.labels.length !== 0) {
          // 新データfetch
          const response = await axios.get('api/label/' + this.getCurrentFolderId)
          if(response.status === OK) {
            this.labels = response.data
            // ページ数が1より大きかったらpage--
            if (this.page > 1) {
              this.page--
            } else {
              this.page = 1
            }
            // 総ページ数更新
            this.totalPage = Math.ceil(this.labels.length / this.perPage)
            this.$store.commit('label/SET_CURRENT_PAGE', this.page)
          }
          this.$store.commit('error/SET_CODE', response.status)
        }
        this.$store.commit(
          'message/SET_SUCCESS_MSG',
          'The label was deleted successfully !!'
        )
      }
      this.$store.commit('error/SET_CODE', response.status)
    }
  },
  computed: {
    // stateから現在のフォルダidをget
    getCurrentFolderId() {
      return this.$store.state.label.currentFolderId
    },

    // stateから背景画像get
    getBackgroundImg() {
      return this.$store.state.label.backgroundImg
    },

    // カラー検索用カラー配列作成 先頭に空文字を挿入する
    searchColors() {
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
          // selectedColorがfalseならばfilteredLabelsにpush
          if (!this.selectedColor) {
            filteredLabels.push(label)
            // selectedColorがtrueならば一致した場合のみfilteredLabelsにpush
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
  background-color: rgb(66, 66, 66) !important;
  border-left-width: 40px !important;
  border-left-style: solid !important;
}
.labelbar {
  margin-top: 5px;
  margin-bottom: 25px;
  border-width: 2px !important;
}
.cardBody {
  height: 86px !important;
}
.label {
  transition: all 1.5s;
  margin-top: 10px;
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
.pagination {
  position: fixed;
  bottom: 70px;
  right: 45px;
}
input {
  width: 85%;
  height: 25px;
  color: rgb(252, 252, 252);
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande',
    'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}
a {
  text-decoration: none;
}
</style>