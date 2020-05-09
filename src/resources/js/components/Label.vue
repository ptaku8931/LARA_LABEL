<template>
  <v-container>
    <v-row>
      <v-col cols="4">
        <v-card raised color="pink" dark>
          <v-card-title>Docker laladock</v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard">mdi-email</v-icon>
            <span id="target">docker-compose up -d</span>
          </v-card-subtitle>
          <div class="text-right">
            <v-icon left>mdi-delete</v-icon>
            <v-icon left>mdi-email</v-icon>
            <v-icon left>mdi-message-text</v-icon>
          </div>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card raised color="teal" dark>
          <v-card-title>Docker コンテナに入る</v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard">mdi-email</v-icon>
            <span id="target">docker-compose exec workspace bash</span>
          </v-card-subtitle>
          <div class="text-right">
            <v-icon left>mdi-delete</v-icon>
            <v-icon left>mdi-email</v-icon>
            <v-icon left>mdi-message-text</v-icon>
          </div>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card raised color="teal" dark>
          <v-card-title>パッケージアップデート</v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard">mdi-email</v-icon>
            <span id="target">yum update</span>
          </v-card-subtitle>
          <div class="text-right">
            <v-icon left>mdi-delete</v-icon>
            <v-icon left>mdi-email</v-icon>
            <v-icon left>mdi-message-text</v-icon>
          </div>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card raised color="indigo" dark>
          <v-card-title>Laravel seed</v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard">mdi-email</v-icon>
            <span id="target">php artisan db:seed</span>
          </v-card-subtitle>
          <div class="text-right">
            <v-icon left>mdi-delete</v-icon>
            <v-icon left>mdi-email</v-icon>
            <v-icon left>mdi-message-text</v-icon>
          </div>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card raised color="indigo" dark>
          <v-card-title>laravel mix</v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard">mdi-email</v-icon>
            <span id="target">webpack</span>
          </v-card-subtitle>
          <div class="text-right">
            <v-icon left>mdi-delete</v-icon>
            <v-icon left>mdi-email</v-icon>
            <v-icon left>mdi-message-text</v-icon>
          </div>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card raised color="indigo" dark>
          <v-card-title>Laravel migration</v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard">mdi-email</v-icon>
            <span id="target">php artisan migrate:fresh</span>
          </v-card-subtitle>
          <div class="text-right">
            <v-icon left>mdi-delete</v-icon>
            <v-icon left>mdi-email</v-icon>
            <v-icon left>mdi-message-text</v-icon>
          </div>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card raised color="teal" dark>
          <v-card-title>laravel controller作る</v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard">mdi-email</v-icon>
            <span id="target">php artisan make:controller</span>
          </v-card-subtitle>
          <div class="text-right">
            <v-icon left>mdi-delete</v-icon>
            <v-icon left>mdi-email</v-icon>
            <v-icon left>mdi-message-text</v-icon>
          </div>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card raised color="teal" dark>
          <v-card-title>laravel controller作る</v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard">mdi-email</v-icon>
            <span id="target">php artisan make:controller</span>
          </v-card-subtitle>
          <div class="text-right">
            <v-icon left>mdi-delete</v-icon>
            <v-icon left>mdi-email</v-icon>
            <v-icon left>mdi-message-text</v-icon>
          </div>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card raised color="teal" dark>
          <v-card-title>laravel controller作る</v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard">mdi-email</v-icon>
            <span id="target">php artisan make:controller</span>
          </v-card-subtitle>
          <div class="text-right">
            <v-icon left>mdi-delete</v-icon>
            <v-icon left>mdi-email</v-icon>
            <v-icon left>mdi-message-text</v-icon>
          </div>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card raised color="indigo" dark>
          <v-card-title>laravel controller作る</v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard">mdi-email</v-icon>
            <span id="target">php artisan make:controller</span>
          </v-card-subtitle>
          <div class="text-right">
            <v-icon left>mdi-delete</v-icon>
            <v-icon left>mdi-email</v-icon>
            <v-icon left>mdi-message-text</v-icon>
          </div>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card raised color="indigo" dark>
          <v-card-title>laravel controller作る</v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard">mdi-email</v-icon>
            <span id="target">php artisan make:controller</span>
          </v-card-subtitle>
          <div class="text-right">
            <v-icon left>mdi-delete</v-icon>
            <v-icon left>mdi-email</v-icon>
            <v-icon left>mdi-message-text</v-icon>
          </div>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card raised color="indigo" dark>
          <v-card-title>laravel controller作る</v-card-title>
          <v-card-subtitle class="subtitle">
            <v-icon left small class="copy-btn" @click="witeToClipboard">mdi-email</v-icon>
            <span id="target">php artisan make:controller</span>
          </v-card-subtitle>
          <div class="text-right">
            <v-icon left>mdi-delete</v-icon>
            <v-icon left>mdi-email</v-icon>
            <v-icon left>mdi-message-text</v-icon>
          </div>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  methods: {
    witeToClipboard() {
      const copyText = this.$el.querySelector('#target').textContent
      navigator.clipboard.writeText(copyText)
    }
  }
}
</script>

<style scoped>
span {
  color: white;
}
.subtitle {
  font-size: 14px;
  padding-bottom: 0;
}
.copy-btn {
  margin-right: 0;
}
</style>