<template>
  <v-card height="580" width="256" class="mx-auto" :dark="theme">
    <v-navigation-drawer permanent>
      <!-- フォルダ追加及び編集フォーム ここから -->
      <v-list-item>
        <v-list-item-content>
          <!-- 新規作成及び編集フォームタイトル -->
          <v-list-item-title class="text-center">{{ formTitle }}</v-list-item-title>
          <v-form v-model="valid" ref="form" @submit.prevent>
            <!-- 入力エリア-->
            <v-text-field
              :label="placeHolder"
              prepend-icon="mdi-folder"
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
          v-for="(folder, index) in labelFolders"
          :key="folder.id"
          link
          class="folder"
          @mouseover="selectedFolder(folder.id)"
          :disabled="edit"
        >
          <v-list-item-icon>
            <!-- フォルダアイコン -->
            <v-icon>mdi-folder</v-icon>
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
    <v-switch v-model="theme" label="Folder Theme" light></v-switch>
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
      // darkテーマ切り替え
      theme: false,
      // 新規作成及び編集フォーム用
      formTitle: 'Create Folder',
      placeHolder: 'New Folder',
      // editがtrueなら編集フォームに変更
      edit: false,
      editID: '',
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
      this.editID = id
      this.placeHolder = title
      this.formTitle = 'Edit Folder'
    },
    // 編集フォームから新規作成フォームに戻す
    cancelEdit() {
      this.edit = false
      this.editID = ''
      this.placeHolder = 'New Folder'
      this.formTitle = 'Create Folder'
    },
    // 選択されたフォルダのidを親コンポーネントに渡す
    selectedFolder(id) {
      this.$emit('input', id)
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
        'api/label_folder/' + this.editID,
        this.folderForm
      )
      // editIDと一致するフォルダのindexをfoldersIndexに代入
      let foldersIndex = ''
      this.labelFolders.map((folder, index) => {
        if (folder.id === this.editID) {
          foldersIndex = index
        }
      })
      // editIDと一致したフォルダのタイトルに変更したタイトルを代入
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
  }
}
</script>

<style scoped>
.folder {
  margin-left: 0px;
}
.folder:hover {
  margin-left: 15px;
  transition: all 0.9s;
  background-color: rgb(212, 212, 216);
}
</style>