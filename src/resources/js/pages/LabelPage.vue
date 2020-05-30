<template>
  <v-content>
    <div class="back" :style="{ backgroundImage: 'url(' + img + ')' }">
      <LabelFolder />
      <v-container class="label">
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
      // 背景画像
      img: ''
    }
  },
  watch: {
    getBackgroundImg: {
      handler() {
        this.img = this.getBackgroundImg.url
      }
    }
  },
  created() {
    this.img = this.getBackgroundImg.url
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
  height: 100vh;
}
.label {
  width: 95%;
}
</style>
