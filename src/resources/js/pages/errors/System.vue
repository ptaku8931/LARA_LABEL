<template>
  <v-content>
    <transition name="delay" appear mode="out-in">
      <div class="back">
        <h1>Sorry... System Error</h1>
      </div>
    </transition>
  </v-content>
</template>

<style scoped>
.back {
  background-image: url(/img/500.jpg);
  background-size: cover;
  width: 100%;
  height: 100vh;
  display: flex;
  justify-content: center;
  color: white;
}
h1 {
  font-size: 70px;
  padding-top: 60px;
  padding-right: 50px;
}
</style>

