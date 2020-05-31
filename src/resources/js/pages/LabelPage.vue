<template>
  <v-content>
    <div class="back" :style="{ backgroundImage: 'url(' + img + ')' }">
      <!-- ラベルフォルダコンポーネント -->
      <LabelFolder />
      <v-container class="label">
        <!-- ラベルコンポーネント -->
        <Label />
      </v-container>
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
      img: ''
    }
  },
  watch: {
    getBackgroundImg: {
      immediate: true,
      handler() {
        this.img = this.getBackgroundImg.url
      }
    }
  },
  computed: {
    getBackgroundImg() {
      return this.$store.state.label.backgroundImg
    }
  }
}
</script>

<style scoped>
.back {
  background-size: cover;
  width: 100%;
  min-height: 100vh;
}
.label {
  width: 94%;
}
</style>
