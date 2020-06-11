<template>
  <div>
    <!-- 現在のページが1でないならば -->
    <v-btn 
      v-if="!isFirstPage" 
      color="teal"
      small
      rounded
      dark
      @click="onPrev"
      class="btn"
      >&laquo; prev</v-btn>
    <!-- ページ総数が1でないかつ、検索で絞ったあとのラベル数が12より大きいならば -->
    <span
      v-if="totalPage !== 1 && afterSearchLabel > 12"
    >Page {{ currentPage }} / {{ totalPage }}</span>
    <!-- ラストページではないかつ、ページ総数が0ではないかつ、検索で絞ったあとのラベル数が12より大きいならば -->
    <v-btn
      v-if="!isLastPage && totalPage !== 0 && afterSearchLabel > 12"
      color="teal"
      small
      rounded
      dark
      @click="onNext"
      class="btn"
    >next &raquo;</v-btn>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: Number,
      required: true
    },
    totalPage: {
      type: Number,
      required: true
    },
    // 検索がかかったあとのページ数
    afterSearchLabel: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      currentPage: this.value
    }
  },
  watch: {
    getCurrentFolderId: {
      handler(val) {
        // フォルダが変更された場合、pageに1を代入して強制的に最初のページに戻す
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
      // 引数の中で最大の値を返す、最低1が返る
      this.currentPage = Math.max(this.currentPage - 1, 1)
      // 親にpage情報を更新してもらう
      this.$emit('input', this.currentPage)
    },
    onNext() {
      // 引数の中で最小の値を返す、最大でページ総数が返る
      this.currentPage = Math.min(this.currentPage + 1, this.totalPage)
      // 親にpage情報を更新してもらう
      this.$emit('input', this.currentPage)
    }
  },
  computed: {
    isFirstPage() {
      return this.currentPage === 1 || this.currentPage === ''
    },
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
.btn {
  margin: 0px 4px 4px 4px;
}
span {
  font-size: 16px;
  color: rgb(11, 211, 151);
}
</style>