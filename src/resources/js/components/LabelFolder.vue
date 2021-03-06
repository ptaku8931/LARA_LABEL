<template>
  <transition name="fade" mode="out-in">
    <v-card dark v-if="drawer">
      <v-navigation-drawer 
      permanent 
      app
      floating
      clipped
      mobile-break-point
      width="270"
    >
        <!-- フォルダ追加及び編集フォーム ここから -->
        <v-list-item>
          <v-list-item-content>
            <!-- フォルダ検索 -->
            <v-text-field
              class="search"
              outlined
              label="Search Folder"
              append-icon="mdi-folder-search"
              v-model="keyword"
            ></v-text-field>
            <!-- 新規作成及び編集フォームタイトル -->
            <v-list-item-title class="form-title">{{ formTitle }}</v-list-item-title>
            <v-form v-model="valid" ref="form" @submit.prevent>
              <!-- 入力エリア-->
              <v-text-field
                class="form"
                :label="placeHolder"
                :prepend-icon="edit ? 'mdi-folder-edit' : 'mdi-folder-multiple'"
                clearable
                counter="30"
                v-model="folderForm.title"
                :rules="folderRules"
              />
              <!-- バリデーションエラーバックエンド -->
              <v-alert v-if="error" type="error">{{ errorMsg.title[0] }}</v-alert>
              <div class="text-right mt-4">
                <!-- 編集の場合のみshowする更新ボタン-->
                <v-btn
                  class="btn"
                  v-if="edit"
                  x-small
                  color="success"
                  :disabled="!valid"
                  @click="updateFolder"
                >update</v-btn>
                <!-- 編集モードを終了して新規作成モードに戻るボタン -->
                <v-btn v-if="edit" x-small color="light-blue" @click="cancelEdit">cancel</v-btn>
                <!-- 新規作成の場合のみshowする追加ボタン -->
                <v-btn
                  class="btn"
                  v-if="!edit"
                  x-small
                  color="success"
                  :disabled="!valid"
                  @click="createFolder"
                >add</v-btn>
                <!-- バリデーションクリアボタン -->
                <v-btn class="btn" x-small color="primary" @click="resetValidation">clear</v-btn>
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
            class="folder"
            :class="[ folder.id === getCurrentFolderId ? 'active' : '']"
            :key="folder.id"
            :disabled="edit"
            @click="selectedFolder(folder.id, index)"
          >
            <v-row>
              <v-col cols="2" class="folder-icon">
                <v-list-item-icon>
                  <!-- フォルダアイコン -->
                  <v-icon v-if="folder.id === getCurrentFolderId">mdi-folder-open</v-icon>
                  <v-icon v-else>mdi-folder</v-icon>
                </v-list-item-icon>
              </v-col>
              <v-col cols="6" class="folder-title">
                <v-list-item-content>
                  <!-- フォルダタイトル -->
                  <v-list-item-title class=folder-name>{{ folder.title }}</v-list-item-title>
                </v-list-item-content>
              </v-col>
              <v-col cols="4" class="folder-btn">
                <v-list-item-icon v-show="isBtn && index === btnIndex">
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <!-- フォルダ編集用アイコン -->
                      <v-icon
                        right
                        @click="editFolder(folder.id, folder.title)"
                        :disabled="edit"
                        v-on="on"
                      >mdi-pen</v-icon>
                    </template>
                    <span>Edit Folder</span>
                  </v-tooltip>
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <!-- フォルダ削除用アイコン -->
                      <v-icon
                        right
                        @click="deleteConfirm(folder.id, index)"
                        :disabled="edit"
                        v-on="on"
                      >mdi-delete</v-icon>
                    </template>
                    <span>Delete Folder</span>
                  </v-tooltip>
                </v-list-item-icon>
              </v-col>
            </v-row>
          </v-list-item>
        </v-list>
        <!-- フォルダ一覧表示ここまで -->
      </v-navigation-drawer>
      <!-- 削除確認用モーダルコンポーネント -->
      <ConfirmModal v-model="confirmModal" @do-delete="deleteFolder" />
    </v-card>
  </transition>
</template>

<script>
import ConfirmModal from './ConfirmModal.vue'
import { OK, CREATED, VALIDATION_ERROR } from '../error_code'
export default {
  components: {
    ConfirmModal
  },
  data() {
    return {
      labelFolders: '',
      folderForm: {
        title: ''
      },
      formTitle: 'Create Folder',
      placeHolder: 'New Folder',
      // editがtrueなら編集フォームに変更
      edit: false,
      editId: '',
      // 削除確認用モーダル
      confirmModal: false,
      // 削除するフォルダのid
      deleteId: '',
      // 削除するフォルダのインデックス
      deleteIndex: '',
      // クリックでボタン出現
      isBtn: false,
      // ボタンのindex番号
      btnIndex: null,
      // 検索ワード
      keyword: '',
      // フォルダドロワー開閉
      drawer: true,
      valid: true,
      error: false,
      errorMsg: '',
      folderRules: [
        v => !!v || 'Folder name is required',
        v => (v && v.length <= 30) || 'Too long !!'
      ]
    }
  },
  watch: {
    getDrawer: {
      handler(val) {
        this.drawer = val
      }
    }
  },
  // フォルダ一覧 GET  created ライフサイクル
  async created() {
    const response = await axios.get('api/label_folder')
    // responseのstatusが200ならば
    if (response.status === OK) {
      this.labelFolders = response.data
    }
    // responseのstatusがその他ならば
    this.$store.commit('error/SET_CODE', response.status)
  },
  methods: {
    resetValidation() {
      this.$refs.form.resetValidation()
      this.folderForm.title = ''
      this.error = false
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

    // 選択されたフォルダのidをstateに渡す
    selectedFolder(id, index) {
      this.$store.commit('label/SET_CURRENT_FOLDER_ID', id)
      // クリックされたフォルダにボタン表示
      this.showBtn(index)
    },

    showBtn(index) {
      this.isBtn = true
      this.btnIndex = index
    },

    deleteConfirm(id, index) {
      this.confirmModal = true
      this.deleteId = id
      this.deleteIndex = index
    },

    // フォルダ新規作成 POST
    async createFolder() {
      this.$store.commit('message/SET_SUCCESS_MSG', null)
      const response = await axios.post('api/label_folder', this.folderForm)
      // responseのstatusが201ならば
      if (response.status === CREATED) {
        this.labelFolders.push(response.data)
        this.resetValidation()
        this.$store.commit(
          'message/SET_SUCCESS_MSG',
          'The new folder was created successfully !!'
        )
        return false
      }

      // responseのstatusが422ならば真 その他ならば偽
      if (response.status === VALIDATION_ERROR) {
        this.errorMsg = response.data.errors
        this.error = true
      } else {
        this.$store.commit('error/SET_CODE', response.status)
      }
    },

    // フォルダ更新 PUT
    async updateFolder() {
      this.$store.commit('message/SET_SUCCESS_MSG', null)
      const response = await axios.put(
        'api/label_folder/' + this.editId,
        this.folderForm
      )

      // responseのstatusが200ならば
      if (response.status === OK) {
        // editIdと一致するフォルダのindexをfoldersIndexに代入
        let foldersIndex = ''
        this.labelFolders.map((folder, index) => {
          if (folder.id === this.editId) {
            foldersIndex = index
          }
        })
        // editIdと一致したフォルダのタイトルに変更したタイトルを代入
        this.labelFolders[foldersIndex].title = this.folderForm.title
        // 編集モードをリセット
        this.cancelEdit()
        // バリデーションをクリア
        this.resetValidation()
        this.$store.commit(
          'message/SET_SUCCESS_MSG',
          'The folder was updated successfully !!'
        )
        return false
      }

      // responseのstatusが422ならば真 その他ならば偽
      if (response.status === VALIDATION_ERROR) {
        this.errorMsg = response.data.errors
        this.error = true
      } else {
        this.$store.commit('error/SET_CODE', response.status)
      }
    },

    // フォルダ削除 DELETE
    async deleteFolder() {
      this.$store.commit('message/SET_SUCCESS_MSG', null)
      const response = await axios.delete('api/label_folder/' + this.deleteId)
      // responseのstatusが200ならば
      if (response.status === OK) {
        // フォルダのindexを受け取ってlabelFoldersから削除
        this.labelFolders.splice(this.deleteIndex, 1)
        // 選択されたフォルダidをリセットする
        this.selectedFolder(null)
        this.$store.commit(
          'message/SET_SUCCESS_MSG',
          'The folder was deleted successfully !!'
        )
      }
      // responseのstatusがその他ならば
      this.$store.commit('error/SET_CODE', response.status)
    }
  },
  computed: {
    getCurrentFolderId() {
      return this.$store.state.label.currentFolderId
    },

    getDrawer() {
      return this.$store.state.label.drawerStatus
    },

    // フォルダー検索
    filteredLabelFolders() {
      // 空配列をもつ変数をセット
      var filteredLabelFolders = []
      // 変数にキーワードとキーワードを小文字に変換したものを代入
      var searchWord = this.keyword && this.keyword.toLowerCase()
      for (var i in this.labelFolders) {
        // apiでgetしたlabelFoldersをfor文で一つずつ変数に代入していく
        var labelFolder = this.labelFolders[i]
        // titleの中でkeywordの文字列(大文字小文字の区別はなし)が存在すれば、filteredFoldersにpush
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
.folder {
  margin-left: 0px;
}
.search {
  font-style: normal;
}
.btn {
  font-size: 12px !important;
}
.form-title {
  text-align: center;
  font-size: 22px !important;
}
.form {
  font-style: normal;
}
.folder:hover {
  margin-left: 15px;
  background-color: rgb(99, 145, 245);
  transition: all 1.2s;
}
.active {
  margin-left: 15px;
  background-color: rgb(99, 145, 245);
}
.folder-icon {
  padding: 0 10px !important;
}
.folder-title {
  margin-top: 5px;
  padding: 0 1px !important;
  width: 30px;
}
.folder-name {
  font-size: 17px !important;
  font-style: normal;
}
.folder-btn {
  padding: 0 12px !important;
}
span {
  font-size: 15px;
}
.fade-enter {
  opacity: 0;
}
.fade-enter-active,
.fade-leave-active {
  transition: all .8s ease;
}
.fade-leave-to {
  opacity: 0;
}
</style>