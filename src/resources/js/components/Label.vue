<template>
  <v-container>
    <v-row>
      <!-- ラベル一覧 ここから-->
      <v-col cols="4" v-for="label in labels" :key="label.id">
        <v-card raised :color="label.color" dark>
          <v-card-title>
            <span v-if="!input" @dblclick="input = true">{{ label.title }}</span>
            <input v-if="input" type="text" :value="label.title" />
          </v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard(label.id)">mdi-file</v-icon>
            <input type="text" :value="label.text" />
          </v-card-subtitle>
          <div class="d-flex">
            <div class="text-left ml-3">
              <v-btn v-if="input" x-small right light>save</v-btn>
              <v-btn v-if="input" x-small right light>back</v-btn>
            </div>
            <v-spacer></v-spacer>
            <div class="text-right">
              <v-icon left>mdi-delete</v-icon>
              <v-icon left>mdi-email</v-icon>
              <v-icon left>mdi-message-text</v-icon>
            </div>
          </div>
        </v-card>
      </v-col>
      <!-- ラベル一覧 ここまで -->
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
      input: false
    }
  },
  // propsのvalue つまり selectedFolderを監視
  watch: {
    value: async function(folder_id) {
      const selected_id = folder_id
      // folder_idがnullでなければapiを叩いてデータをリクエスト
      if(selected_id !== null) {
        const response = await axios.get('api/label/' + folder_id)
        this.labels = response.data
        // folder_idがnullならばlabelsをリセット
      } else {
        this.labels = ''
      }
    }
  },
  methods: {
    // クリックしたテキストをクリップボードにコピー
    // witeToClipboard(id) {
    //   const copyText = this.$el.getElementById('#target').value
    //   navigator.clipboard.writeText(copyText)
    // },
  }
}
</script>

<style scoped>
span {
  width: 90%;
  color: white;
}
.subtitle {
  font-size: 14px;
  padding-bottom: 0;
}
.copy-btn {
  margin-right: 0;
}
input {
  width: 90%;
}
</style>