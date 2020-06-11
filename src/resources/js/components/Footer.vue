<template>
  <v-footer app padless dark color="indigo">
    <v-col
      class="footer"
      cols="12"
    >
      {{ new Date().getFullYear() }} — <strong>Copyright</strong>  — <strong>LARA_LABEL</strong>
    </v-col>
  </v-footer>
</template>

<style scoped>
.footer {
  font-size: 18px;
  text-align: center;
}
</style>