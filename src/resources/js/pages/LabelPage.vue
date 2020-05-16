<template>
  <v-content>
    <div class="back">
      <v-layout wrap pt-5>
        <v-flex xs3 pt-4 class="folder" >
          <LabelFolder v-model="selectedFolder" />
        </v-flex>
        <v-flex xs9 pr-5>
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
    Label,
  },
  metaInfo: {
    title: 'Label Page'
  },
  data() {
    return {
      // クリックされたフォルダid　
      selectedFolder: null,
    }
  }
}
</script>

<style scoped>
.back {
  background-color: rgb(240, 240, 240);
  min-height: 700px;
}
</style>
