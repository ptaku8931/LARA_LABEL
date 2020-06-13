<template>
  <v-footer app dark padless color="indigo">
    <v-col
      class="footer"
      cols="12"
    >
      {{ new Date().getFullYear() }} — <strong>Copyright</strong>  — <strong>ptaku</strong>
    </v-col>
  </v-footer>
</template>

<style scoped>
.footer {
  font-size: 18px;
  text-align: center;
  padding-left: 0;
  padding-right: 0;
}
</style>