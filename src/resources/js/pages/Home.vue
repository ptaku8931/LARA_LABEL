<template>
  <v-content>
    <div class="back">
      <h1>LARA_LABEL</h1>
      <p>Memo + Bookmark + Color + Snippet</p>
    </div>
  </v-content>
</template>

<script>
export default {
  metaInfo: {
    title: 'LARA_LABEL',
  }
}
</script>
<style scoped>
h1 {
  color: white;
  padding-left: 60px;
  padding-top: 120px;
  font-size: 70px;
}
p {
  color: white;
  padding-left: 60px;
  padding-top: 60px;
  font-size: 45px;
  font-family:monospace
}
.back {
  background-image: url('/img/markus-spiske-zJDqiEGUCHY-unsplash.jpg');
  background-size: cover;
  width: 100%;
  min-height: 100vh;
}

</style>