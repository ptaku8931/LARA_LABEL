<template>
  <v-content class="lato">
    <transition name="delay" appear mode="out-in">
      <div class="back">
        <h1>LARA_LABEL</h1>
        <p>Memo + Bookmark + Color + Snippet</p>
        <router-link to="/login">
          <img src="/img/label.png" width="360px" />
        </router-link>
      </div>
    </transition>
  </v-content>
</template>

<script>
export default {
  metaInfo: {
    title: 'LARA_LABEL'
  }
}
</script>

<style scoped>
h1 {
  color: white;
  padding-left: 60px;
  padding-top: 70px;
  font-size: 80px;
}
p {
  color: white;
  margin-left: 60px;
  margin-top: 60px;
  font-size: 45px;
  text-shadow: 0 0 20px white;
}
img {
  margin-left: 60px;
  margin-top: 60px;
  box-shadow: 6px 12px 10px rgba(1, 1, 1, 1);
}
img:hover {
  cursor: pointer;
  opacity: 0.7;
}
img:active {
  box-shadow: none;
  position: relative;
  top: 12px;
}
.back {
  background-image: url('/img/home.jpg');
  background-size: cover;
  max-width: 100%;
  min-height: 100vh;
  position: relative;
  z-index: 0;
}
.back::before {
  content: '';
  position: absolute;
  top: -5px;
  bottom: -5px;
  left: -5px;
  right: -5px;
  background: inherit;
  filter: blur(5px);
  z-index: -1;
}
</style>