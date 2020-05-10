<template>
  <v-content>
    <div class="back">
      <v-layout wrap pt-5>
        <v-flex xs3 class="folder" pt-4>
          <LabelFolder v-model="selectedFolder" />
        </v-flex>
        <v-flex xs9>
          <span>　　　　現在のフォルダ 検索 　　　　　　　　　ここにコンポーネント</span>
          <Label v-model="selectedFolder" />
        </v-flex>
      </v-layout>
    </div>
  </v-content>
</template>

<script>
import LabelFolder from '../components/LabelFolder.vue'
import Label from '../components/Label.vue'
export default {
  components: {
    LabelFolder,
    Label
  },
  metaInfo: {
    title: 'Label Page'
  },
  data() {
    return {
      // クリックされたフォルダid　
      selectedFolder: null
    }
  }
}
</script>

<style scoped>
.back {
  background-color: rgb(233, 231, 231);
  min-height: 700px;
}
</style>
