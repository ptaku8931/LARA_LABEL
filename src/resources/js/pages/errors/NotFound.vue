<template>
  <v-content>
    <transition name="delay" appear mode="out-in">
      <div class="back">
        <h1>Not Found...</h1>
      </div>
    </transition>
  </v-content>
</template>

<style scoped>
.back {
  background-image: url(/img/404.jpg);
  background-size: cover;
  width: 100%;
  height: 100vh;
  display: flex;
  align-items: center;
  color: white;
}
h1 {
  padding-left: 40px;
  padding-bottom: 130px;
  font-size: 90px;
}
</style>