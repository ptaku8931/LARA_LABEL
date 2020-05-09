<template>
  <v-content>
    <div class="back">
      <v-layout wrap pt-5>
        <v-flex xs3 class="folder" pt-5>
          <LabelFolder />
        </v-flex>
        <v-flex xs9 mt-5 pt-5>
          <Label />
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
  }
}
</script>

<style scoped>
.back {
  background-color: rgb(238, 235, 235);
  min-height: 700px;
}
</style>
