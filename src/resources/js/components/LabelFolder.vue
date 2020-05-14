<template>
  <v-card class="foldercard" :dark="theme">
    <v-navigation-drawer permanent>
      <!-- フォルダ追加及び編集フォーム ここから -->
      <v-list-item>
        <v-list-item-content>
          <!-- フォルダ検索 -->
          <v-text-field
            outlined
            label="Search Folder"
            append-icon="mdi-folder-search"
            v-model="keyword"
          ></v-text-field>
          <!-- 新規作成及び編集フォームタイトル -->
          <v-list-item-title class="text-center">{{ formTitle }}</v-list-item-title>
          <v-form v-model="valid" ref="form" @submit.prevent>
            <!-- 入力エリア-->
            <v-text-field
              :label="placeHolder"
              :prepend-icon="edit ? 'mdi-folder-edit' : 'mdi-folder-multiple'"
              clearable
              v-model="folderForm.title"
              :rules="folderRules"
            />
            <div class="text-right">
              <!-- 編集の場合のみshowする更新ボタン-->
              <v-btn
                v-if="edit"
                x-small
                color="success"
                :disabled="!valid"
                @click="updateFolder()"
              >update</v-btn>
              <!-- 編集モードを終了して新規作成モードに戻るボタン -->
              <v-btn v-if="edit" x-small color="light-blue" @click="cancelEdit()">cancel</v-btn>
              <!-- 新規作成の場合のみshowする追加ボタン -->
              <v-btn
                v-if="!edit"
                x-small
                color="success"
                :disabled="!valid"
                @click="createFolder()"
              >add</v-btn>
              <!-- バリデーションクリアボタン -->
              <v-btn x-small color="primary" @click="resetValidation">clear</v-btn>
            </div>
          </v-form>
        </v-list-item-content>
      </v-list-item>
      <v-divider></v-divider>
      <!-- フォルダ追加及び編集フォーム ここまで -->
      <!-- フォルダ一覧表示 ここから -->
      <v-list dense nav>
        <v-list-item
          v-for="(folder, index) in filteredLabelFolders"
          :key="folder.id"
          link
          class="folder"
          @mouseover="selectedFolder(folder.id)"
          :disabled="edit"
        >
          <v-list-item-icon>
            <!-- フォルダアイコン -->
            <v-icon v-if="folder.id === currentFolderId">mdi-folder-open</v-icon>
            <v-icon v-else>mdi-folder</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <!-- フォルダタイトル -->
            <v-list-item-title class="folder-name">{{ folder.title }}</v-list-item-title>
          </v-list-item-content>
          <v-list-item-icon>
            <!-- フォルダ編集用アイコン -->
            <v-icon right @click="editFolder(folder.id, folder.title)" :disabled="edit">mdi-pen</v-icon>
            <!-- フォルダ削除用アイコン -->
            <v-icon right @click="deleteFolder(folder.id, index)" :disabled="edit">mdi-delete</v-icon>
          </v-list-item-icon>
        </v-list-item>
      </v-list>
      <!-- フォルダ一覧表示ここまで -->
    </v-navigation-drawer>
    <v-switch dark v-model="theme"></v-switch>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      // データ格納用
      labelFolders: '',
      folderForm: {
        title: ''
      },
      currentFolderId: '',
      // 検索ワード
      keyword: '',
      // darkテーマ切り替え
      theme: false,
      // 新規作成及び編集フォーム用
      formTitle: 'Create Folder',
      placeHolder: 'New Folder',
      // editがtrueなら編集フォームに変更
      edit: false,
      editId: '',
      // バリデーション
      valid: true,
      folderRules: [
        v => !!v || 'Folder name is required',
        v =>
          (v && v.length <= 20) || 'Folder name must be less than 20 characters'
      ]
    }
  },
  // フォルダ一覧 GET  created ライフサイクル
  async created() {
    const response = await axios.get('api/label_folder')
    this.labelFolders = response.data
  },

  methods: {
    // バリデーションクリア
    resetValidation() {
      this.$refs.form.resetValidation()
      this.folderForm.title = ''
    },
    // 新規作成フォームから編集フォームに切り替える
    editFolder(id, title) {
      this.edit = true
      this.editId = id
      this.placeHolder = title
      this.formTitle = 'Edit Folder'
    },
    // 編集フォームから新規作成フォームに戻す
    cancelEdit() {
      this.edit = false
      this.editId = ''
      this.placeHolder = 'New Folder'
      this.formTitle = 'Create Folder'
    },
    // 選択されたフォルダのidを親コンポーネントに渡す
    selectedFolder(id) {
      this.$emit('input', id)
      // 現在選択されたフォルダidをデータに格納
      this.currentFolderId = id
    },
    // フォルダ新規作成 POST
    async createFolder() {
      const response = await axios.post('api/label_folder', this.folderForm)
      this.labelFolders.push(response.data)
      this.resetValidation()
    },
    // フォルダ更新 PUT
    async updateFolder() {
      const response = await axios.put(
        'api/label_folder/' + this.editId,
        this.folderForm
      )
      // editIdと一致するフォルダのindexをfoldersIndexに代入
      let foldersIndex = ''
      this.labelFolders.map((folder, index) => {
        if (folder.id === this.editId) {
          foldersIndex = index
        }
      })
      // editIdと一致したフォルダのタイトルに変更したタイトルを代入
      this.labelFolders[foldersIndex].title = this.folderForm.title
      // 編集モードをリセットする
      this.cancelEdit()
      // バリデーションをクリアする
      this.resetValidation()
    },
    // フォルダ削除 DELETE
    async deleteFolder(id, index) {
      if (confirm('Are you sure?')) {
        const response = await axios.delete('api/label_folder/' + id)
        // フォルダのindexを受け取ってlabelFoldersから削除
        this.labelFolders.splice(index, 1)
        // 選択されたフォルダidをリセットする
        this.selectedFolder(null)
      }
      return false
    }
  },
  computed: {
    // フォルダー検索
    filteredLabelFolders() {
      // 空配列をもつ変数をセット
      var filteredLabelFolders = []
      var searchWord = this.keyword && this.keyword.toLowerCase()
      for (var i in this.labelFolders) {
        // apiでgetしたlabelFoldersをfor文で一つずつ変数に代入していく
        var labelFolder = this.labelFolders[i]
        // titleの中でkeywordの文字列(大文字小文字の区別はなし)が存在すれば、filterdFoldersにpush
        if (labelFolder.title.toLowerCase().indexOf(searchWord) !== -1) {
          filteredLabelFolders.push(labelFolder)
        }
      }
      // keyowordの文字列が存在したものだけ格納された配列を返す
      return filteredLabelFolders
    }
  }
}
</script>

<style scoped>
.foldercard {
  height: 580px;
  width: 256px;
  margin-left: 60px;
}
.folder {
  margin-left: 0px;
}
.folder:hover {
  margin-left: 10px;
  transition: all .9s;
  background-color: rgb(212, 212, 216);
}
</style>