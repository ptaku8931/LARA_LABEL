<template>
  <v-card height="550" width="256" class="mx-auto">
    <v-navigation-drawer permanent>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-center">{{ formTitle }}</v-list-item-title>
          <v-form v-model="valid" ref="form" @submit.prevent="createFolder()">
            <v-text-field
              :label="placeHolder"
              prepend-icon="mdi-folder"
              clearable
              v-model="folderForm.title"
              :rules="folderRules"
            />
            <div class="text-right">
              <v-btn
                v-if="edit"
                x-small
                color="success"
                :disabled="!valid"
                @click="updateFolder()"
              >update</v-btn>
              <v-btn v-if="edit" x-small color="light-blue" @click="cancelEdit()">cancel</v-btn>
              <v-btn v-if="!edit" x-small color="success" type="submit" :disabled="!valid">add</v-btn>
              <v-btn x-small color="primary" @click="resetValidation">clear</v-btn>
            </div>
          </v-form>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list dense nav>
        <v-list-item v-for="(folder, index) in labelFolders" :key="folder.id" link class="folder">
          <v-list-item-icon>
            <v-icon>mdi-folder</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="folder-name">{{ folder.title }}</v-list-item-title>
          </v-list-item-content>
          <v-list-item-icon>
            <v-icon
              right
              @click="editFolder(folder.id, folder.title)"
              :disabled="edit"
            >mdi-message-text</v-icon>
            <v-icon right @click="deleteFolder(folder.id, index)" :disabled="edit">mdi-delete</v-icon>
          </v-list-item-icon>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      formTitle: 'Create Folder',
      placeHolder: 'New Folder',
      edit: false,
      editID: '',
      labelFolders: '',
      valid: true,
      folderForm: {
        title: ''
      },
      folderRules: [
        v => !!v || 'Folder name is required',
        v =>
          (v && v.length <= 20) || 'Folder name must be less than 20 characters'
      ]
    }
  },
  async created() {
    const response = await axios.get('api/label_folder')
    this.labelFolders = response.data
  },
  methods: {
    resetValidation() {
      this.$refs.form.resetValidation()
      this.folderForm.title = ''
    },
    async createFolder() {
      const response = await axios.post('api/label_folder', this.folderForm)
      this.labelFolders.push(response.data)
      this.resetValidation()
    },

    async updateFolder() {
      const response = await axios.put(
        'api/label_folder/' + this.editID,
        this.folderForm
      )
      let foldersIndex = ''
      this.labelFolders.map((folder, index) => {
        if (folder.id === this.editID) {
          foldersIndex = index
        }
      })
      this.labelFolders[foldersIndex].title = this.folderForm.title
      this.cancelEdit()
      this.resetValidation()
    },

    async deleteFolder(id, index) {
      if (confirm('Are you sure?')) {
        const response = await axios.delete('api/label_folder/' + id)
        this.labelFolders.splice(index, 1)
      }
      return false
    },
    editFolder(id, title) {
      this.edit = true
      this.editID = id
      this.placeHolder = title
      this.formTitle = 'Edit Folder'
    },
    cancelEdit() {
      this.edit = false
      this.editID = ''
      this.placeHolder = 'New Folder'
      this.formTitle = 'Create Folder'
    }
  }
}
</script>

<style lang="scss" scoped>
.folder {
  margin-left: 0px;
}
.folder:hover {
  margin-left: 10px;
  transition: all 0.9s;
  background-color: rgb(212, 212, 216);
}
</style>