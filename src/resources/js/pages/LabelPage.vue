<template>
  <v-content>
    <transition name="page" appear mode="out-in">
      <div v-if="page" class="top">
        <p>Now Loading ...</p>
      </div>
    </transition>
    <transition name="delay" appear mode="out-in">
      <div class="back" :style="{ backgroundImage: 'url(' + img + ')' }">
        <!-- ラベルフォルダコンポーネント -->
        <LabelFolder />
        <v-container class="label">
          <!-- ラベルコンポーネント -->
          <Label />
        </v-container>
      </div>
    </transition>
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
      page: false,
      img: ''
    }
  },
  watch: {
    getBackgroundImg: {
      immediate: true,
      handler(val) {
        this.img = val.url
        if (this.img !== '/img/white.jpg') this.page = true
        setTimeout(() => {
          this.page = false
        }, 1800)
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
.page {
  background-color: white;
  position: fixed;
  top: 0;
  left: 0;
  width: 600px;
  height: 100vh;
}
.back {
  background-size: cover;
  width: 100%;
  min-height: 100vh;
}
.label {
  width: 94%;
}
.page-leave-active {
  transition: all 1.8s ease;
}
.page-leave-to {
  opacity: 0;
}
</style>
