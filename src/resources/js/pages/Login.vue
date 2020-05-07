<template>
  <v-content>
    <div class="back">
      <v-container>
         <!-- タブ -->
        <v-tabs NOT dark background-color="transparent" class="tabs">
          <v-tab @click="tab = 1">LOGIN</v-tab>
          <v-tab @click="tab = 2">REGISTER</v-tab>
        </v-tabs>

        <!-- ログインフォーム -->
        <v-card v-show="tab === 1" dark color="teal" class="form">
          <v-card-title>
            <h1 class="display-1">LOGIN</h1>
          </v-card-title>
          <v-card-text>
            <v-form>
              <v-text-field label="Username" prepend-icon="mdi-account-circle" clearable />
              <v-text-field
                :type="showPassword ? 'text' : 'password'"
                label="Password"
                clearable
                prepend-icon="mdi-lock"
                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPassword = !showPassword"
              />
            </v-form>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="teal darken-4">Login</v-btn>
          </v-card-actions>
        </v-card>

        <!-- レジスターフォーム -->
        <v-card v-show="tab === 2" dark color="light-blue accent-4" class="form">
          <v-card-title class="text-center">
            <h1 class="display-1">REGISTER</h1>
          </v-card-title>
          <v-card-text>
            <v-form>
              <v-text-field label="Username" prepend-icon="mdi-account-circle" clearable />
              <v-text-field
                :type="showPassword ? 'text' : 'password'"
                label="Password"
                clearable
                prepend-icon="mdi-lock"
                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPassword = !showPassword"
              />
            </v-form>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="indigo darken-4">REGISTER</v-btn>
          </v-card-actions>
        </v-card>
      </v-container>
    </div>
  </v-content>
</template>

<script>
export default {
  name: 'LoginPage',
  data() {
    return {
      showPassword: false,
      tab: 1
    }
  }
}
</script>

<style scoped>
.container {
  padding-top: 60px;
}
.tabs {
  width: 500px;
  margin: 20px auto;
}
.form {
  width: 500px;
  margin: 0 auto;
}
.back {
  background-color: rgb(3, 3, 3);
  height: 700px;
}
</style>