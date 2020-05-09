<template>
  <v-content>
    <div class="back">
      <v-container>
        <!-- tab start -->
        <v-tabs NOT dark background-color="transparent" class="tabs">
          <v-tab @click="tab = 1">LOGIN</v-tab>
          <v-tab @click="tab = 2">REGISTER</v-tab>
        </v-tabs>
        <!-- tab end -->

        <!-- login start -->
        <v-card v-show="tab === 1" class="form" shaped>
          <v-card-title>
            <h1 class="display-1">LOGIN</h1>
          </v-card-title>
          <v-card-text>
            <div v-if="loginErrors">
              <v-alert dense type="error">
                <ul v-if="loginErrors.email">
                  <li v-for="error in loginErrors.email" :key="error">{{ error }}</li>
                </ul>
                <ul v-if="loginErrors.password">
                  <li v-for="error in loginErrors.password" :key="error">{{ error }}</li>
                </ul>
              </v-alert>
            </div>
            <v-form @submit.prevent="login">
              <v-text-field
                label="E-mail"
                prepend-icon="mdi-email"
                clearable
                v-model="loginForm.email"
              />
              <v-text-field
                label="Password"
                prepend-icon="mdi-lock"
                clearable
                :type="showPassword ? 'text' : 'password'"
                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPassword = !showPassword"
                v-model="loginForm.password"
              />
              <v-divider></v-divider>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn type="submit" color="primary">Login</v-btn>
              </v-card-actions>
            </v-form>
          </v-card-text>
        </v-card>
        <!-- login end -->

        <!-- register start -->
        <v-card v-show="tab === 2" class="form" shaped>
          <v-card-title>
            <h1 class="display-1">REGISTER</h1>
          </v-card-title>
          <v-card-text>
            <v-form @submit.prevent="register">
              <div v-if="registerErrors">
                <v-alert dense type="error">
                  <ul v-if="registerErrors.name">
                    <li v-for="error in registerErrors.name" :key="error">{{ error }}</li>
                  </ul>
                  <ul v-if="registerErrors.email">
                    <li v-for="error in registerErrors.email" :key="error">{{ error }}</li>
                  </ul>
                  <ul v-if="registerErrors.password">
                    <li v-for="error in registerErrors.password" :key="error">{{ error }}</li>
                  </ul>
                </v-alert>
              </div>
              <v-text-field
                label="Username"
                prepend-icon="mdi-account-circle"
                clearable
                v-model="registerForm.name"
              />
              <v-text-field
                label="E-mail"
                prepend-icon="mdi-email"
                clearable
                v-model="registerForm.email"
              />
              <v-text-field
                label="Password"
                prepend-icon="mdi-lock"
                clearable
                :type="showPassword ? 'text' : 'password'"
                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPassword = !showPassword"
                v-model="registerForm.password"
              />
              <v-text-field
                label="Password (confirmation)"
                prepend-icon="mdi-lock"
                clearable
                :type="showPasswordConfirmation ? 'text' : 'password'"
                :append-icon="showPasswordConfirmation ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPasswordConfirmation = !showPasswordConfirmation"
                v-model="registerForm.password_confirmation"
              />
              <v-divider></v-divider>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn type="submit" color="primary">REGISTER</v-btn>
              </v-card-actions>
            </v-form>
          </v-card-text>
        </v-card>
        <!-- register end -->
      </v-container>
    </div>
  </v-content>
</template>

<script>
export default {
  metaInfo: {
    title: 'LOGIN / REGISTER'
  },
  data() {
    return {
      showPassword: false,
      showPasswordConfirmation: false,
      tab: 1,
      loginForm: {
        email: '',
        password: ''
      },
      registerForm: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  methods: {
    async login() {
      await this.$store.dispatch('auth/login', this.loginForm)

      if (this.apiStatus) {
        this.$router.push('/label')
      }
    },
    async register() {
      await this.$store.dispatch('auth/register', this.registerForm)

      if (this.apiStatus) {
        this.$router.push('/label')
      }
    },
    clearError() {
      this.$store.commit('auth/SET_LOGIN_ERROR_MESSAGES', null)
      this.$store.commit('auth/SET_REGISTER_ERROR_MESSAGES', null)
    }
  },
  created() {
    this.clearError()
  },
  computed: {
    apiStatus() {
      return this.$store.state.auth.apiStatus
    },
    loginErrors() {
      return this.$store.state.auth.loginErrorMessages
    },
    registerErrors() {
      return this.$store.state.auth.registerErrorMessages
    }
  }
}
</script>

<style scoped>
.container {
  padding-top: 25px;
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