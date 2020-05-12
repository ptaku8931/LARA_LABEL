<template>
  <v-container>
    <!-- ラベルナビバーここから -->
    <v-bottom-navigation class="labelbar" height="70px" color="primary" :dark="theme">
      <!-- 新規作成ボタン -->
      <v-btn>
        Create Label
        <v-icon class="pt-3">mdi-image-filter-none</v-icon>
      </v-btn>
      <!-- 検索エリア -->
      <v-text-field class="mt-2" outlined label="Search Label" append-icon="mdi-magnify" v-model="keyword"></v-text-field>
      <!-- color検索エリア -->
      <v-select
        class="mt-2"
        label="Search of color"
        outlined
        prepend-inner-icon="mdi-file-search"
        :items="color"
        v-model="selectedColor"
      ></v-select>
      <v-select class="mt-2" label="sort" outlined></v-select> 
    </v-bottom-navigation>
    <!-- ラベルナビバーここまで -->
    <!-- ラベルバーテーマ -->
    <v-switch class="switch" label="Bar Theme" light v-model="theme"></v-switch>
    <!-- ラベル一覧 ここから-->
    <v-row>
      <v-col cols="4" class="label" v-for="(label, index) in filteredLabels" :key="label.id">
        <v-card raised dark :color="label.color">
          <v-card-title class="title">
            <input type="text" :placeholder="label.title" />
          </v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left class="copy-btn" @click="copyToClipboard(index)">mdi-content-copy</v-icon>
            <input type="text" ref="copyMe" :placeholder="label.text" />
          </v-card-subtitle>
          <div class="d-flex">
            <!-- <div class="text-left ml-3">
              <v-btn x-small right light>save</v-btn>
              <v-btn x-small right light>back</v-btn>
            </div>-->
            <v-spacer></v-spacer>
            <div class="text-right">
              <v-icon left>mdi-gesture-swipe</v-icon>
              <!-- URLボタン -->
              <a v-if="label.url" :href="label.url" target="_blank">
                <v-icon left>mdi-microsoft-internet-explorer</v-icon>
              </a>
              <!-- URL nullのボタン -->
              <v-icon left v-else>mdi-cloud-off-outline</v-icon>
              <!-- ラベル削除ボタン -->
              <v-icon @click="deleteLabel(label.id, index)" left>mdi-delete</v-icon>
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
      // 検索ワード
      keyword: '',
      // darkテーマ切り替え
      theme: false,
      // colorドロップダウン
      color: ['','red', 'indigo', 'black', 'grey', 'cyan', 'pink', 'teal'],
      // カラー検索用
      selectedColor: ''
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
    // クリックしたテキストをクリップボードにコピー
    copyToClipboard(index) {
      const copyText = this.$refs.copyMe[index].placeholder
      navigator.clipboard.writeText(copyText)
    },

    // ラベル削除 api
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
          if(!this.selectedColor) {
            filteredLabels.push(label)
            // selectedColorがtrueならば一致した場合のみpush
          } else {
            if(label.color === this.selectedColor) {
              filteredLabels.push(label)
            }
          }
        }
      }
      // keyowordの文字列が存在したものだけ格納された配列を返す
      return filteredLabels
    }
  }
}
</script>

<style scoped>
.labelbar {
  margin-top: 5px;
}
.switch {
  width: 150px;
  height: 10px;
  margin-bottom: 20px;
  margin-left: auto;
}
.label {
  transition: all 0.9s;
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
input {
  width: 90%;
  color: white;
}
input::placeholder {
  color: white;
}
:focus::placeholder {
  opacity: 0.3;
}
a {
  text-decoration: none;
}
</style>