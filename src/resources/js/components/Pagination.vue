<template>
  <div>
    <!-- 現在のページが1でないならば -->
    <v-btn 
      v-if="!isFirstPage" 
      color="blue"
      text
      @click="onPrev()"
      >&laquo; prev</v-btn>
    <!-- ページ総数が0及び1でないかつ、検索で絞ったあとのラベル数が12より大きいならば -->
    <span
      v-if="totalPage !== 1 && afterSearchLabel > 12"
    >Page {{ currentPage }} / {{ totalPage }}</span>
    <!-- ラストページではないかつ、ページ総数が0ではないかつ、検索で絞ったあとのラベル数が12より大きいならば -->
    <v-btn
      v-if="!isLastPage && totalPage !== 0 && afterSearchLabel > 12"
      color="blue"
      text
      @click="onNext()"
    >next &raquo;</v-btn>
  </div>
</template>

<script>
import CreateModalVue from './CreateModal.vue'
export default {
  props: {
    // v-modelの親コンポーネントのpage
    value: {
      type: Number,
      required: true
    },
    // propのtotalPage
    totalPage: {
      type: Number,
      required: true
    },
    // propのafterSearchLabel
    afterSearchLabel: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      // プロップのvalueをcurrentPageに代入
      currentPage: this.value
    }
  },
  watch: {
    getCurrentFolderId: {
      handler(val) {
        if ( val !== null) {
          this.$emit('input', 1)
          this.currentPage = 1
          this.$store.commit('label/SET_CURRENT_PAGE', '')
        }
      }
    },
    getCurrentPage: {
      handler(val) {
        this.currentPage = val
      }
    }
  },
  methods: {
    onPrev() {
      // 引数の中で最大の値を返す、つまり、最低1が返る
      this.currentPage = Math.max(this.currentPage - 1, 1)
      // v-modelで親にpage情報を更新してもらう
      this.$emit('input', this.currentPage)
    },
    onNext() {
      // 引数の中で最小の値を返す、つまり、最大でページ総数が返る
      this.currentPage = Math.min(this.currentPage + 1, this.totalPage)
      // v-modelで親にpage情報を更新してもらう
      this.$emit('input', this.currentPage)
    }
  },
  computed: {
    // 現在のページが1に等しい
    isFirstPage() {
      return this.currentPage === 1 || this.currentPage === ''
    },
    // 現在のページがページ総数に等しい
    isLastPage() {
      return this.currentPage === this.totalPage
    },
    getCurrentFolderId() {
      return this.$store.state.label.currentFolderId
    },
    getCurrentPage() {
      return this.$store.state.label.currentPage
    }
  }
}
</script>

<style scoped>
span {
  font-size: 14px;
  color: rgb(0, 132, 255);
}
</style>