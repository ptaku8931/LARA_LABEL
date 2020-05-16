<template>
  <div>
    <v-btn 
      v-if="!isFirstPage" 
      text 
      rounded 
      color="success" 
      @click="onPrev()"
      >&laquo; prev</v-btn>
    <span
      v-if="this.totalPage !== 0 && this.totalPage !== 1 && this.afterSearchLabel > 12"
    >Page {{ currentPage }} / {{ totalPage }}</span>
    <v-btn
      v-if="!isLastPage && this.totalPage !== 0 && this.afterSearchLabel > 12"
      text
      rounded
      color="success"
      @click="onNext()"
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
  methods: {
    onPrev() {
      this.currentPage = Math.max(this.currentPage - 1, 1)
      this.$emit('input', this.currentPage)
    },
    onNext() {
      this.currentPage = Math.min(this.currentPage + 1, this.totalPage)
      this.$emit('input', this.currentPage)
    }
  },
  computed: {
    isFirstPage() {
      return this.currentPage === 1
    },
    isLastPage() {
      return this.currentPage === this.totalPage
    }
  }
}
</script>

<style lang="scss" scoped>
</style>