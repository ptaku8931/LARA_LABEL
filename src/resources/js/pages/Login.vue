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
        <v-card v-show="tab === 1" class="form" dark>
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
            <v-form @submit.prevent="login" v-model="valid">
              <v-text-field
                label="E-mail"
                prepend-icon="mdi-email"
                clearable
                :rules="emailRules"
                v-model="loginForm.email"
              />
              <v-text-field
                label="Password"
                prepend-icon="mdi-lock"
                clearable
                counter
                :type="showPassword ? 'text' : 'password'"
                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPassword = !showPassword"
                :rules="passRules"
                v-model="loginForm.password"
              />
              <v-divider></v-divider>
              <v-card-actions>
                <a href="/api/login/google"> 
                  <v-btn class="mt-4 mr-3" fab small dark color="red">
                    <v-icon dark>mdi-google</v-icon>
                  </v-btn>
                </a>
                <a href="/api/login/github"> 
                  <v-btn class="mt-4 mr-3" fab small dark color="black">
                    <v-icon dark>mdi-github</v-icon>
                  </v-btn>
                </a>
                <a href="/api/login/facebook"> 
                  <v-btn class="mt-4 mr-3" fab small dark color="indigo">
                    <v-icon dark>mdi-facebook</v-icon>
                  </v-btn>
                </a>
                <v-spacer></v-spacer>
                <v-btn text type="submit" :disabled="!valid">Login</v-btn>
              </v-card-actions>
            </v-form>
          </v-card-text>
        </v-card>
        <!-- login end -->

        <!-- register start -->
        <v-card v-show="tab === 2" class="form" dark>
          <v-card-title>
            <h1 class="display-1">REGISTER</h1>
          </v-card-title>
          <v-card-text>
            <v-form @submit.prevent="register" v-model="valid">
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
                label="Name"
                prepend-icon="mdi-account-circle"
                clearable
                :rules="nameRules"
                v-model="registerForm.name"
              />
              <v-text-field
                label="E-mail"
                prepend-icon="mdi-email"
                clearable
                :rules="emailRules"
                v-model="registerForm.email"
                
              />
              <v-text-field
                label="Password"
                prepend-icon="mdi-lock"
                clearable
                counter
                :type="showPassword ? 'text' : 'password'"
                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPassword = !showPassword"
                :rules="passRules"
                v-model="registerForm.password"
              />
              <v-text-field
                label="Password (confirmation)"
                prepend-icon="mdi-lock"
                clearable
                counter
                :type="showPasswordConfirmation ? 'text' : 'password'"
                :append-icon="showPasswordConfirmation ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPasswordConfirmation = !showPasswordConfirmation"
                v-model="registerForm.password_confirmation"
              />
              <v-divider></v-divider>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn text type="submit" :disabled="!valid">REGISTER</v-btn>
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
      valid: false,
      loginForm: {
        email: '',
        password: ''
      },
      registerForm: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      nameRules: [
        v => !!v || 'Name is required',
      ],
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      passRules: [
        v => !!v || 'Password is required',
        v => v.length >= 8 || 'Password must be more than 8 characters',
      ]
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
ul {
  list-style: none;
}
a {
  text-decoration: none;
}
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
  opacity: 0.7;
}
.back {
  background-image: url(/img/sean-o-KMn4VEeEPR8-unsplash.jpg);
  background-size: cover;
  width: 100%;
  height: 100vh;
}
</style>