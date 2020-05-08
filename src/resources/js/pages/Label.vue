<template>
  <v-content>
    <div class="back">
      <v-layout wrap pt-5>
        <v-flex xs3 class="folder" pt-5>
          <v-card height="550" width="256" class="mx-auto">
            <v-navigation-drawer permanent>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title class="text-center">
                    My folders
                  </v-list-item-title>
                  <v-list-item-subtitle>subtext</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>

              <v-divider></v-divider>

              <v-list dense nav>
                <v-list-item v-for="item in items" :key="item.title" link>
                  <v-list-item-icon>
                    <v-icon>{{ item.icon }}</v-icon>
                  </v-list-item-icon>

                  <v-list-item-content>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-navigation-drawer>
          </v-card>
        </v-flex>
        <v-flex xs9 mt-5 pt-5>
          <v-container>
            <v-row>
              <v-col cols="4">
                <v-card raised color="teal" dark>
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
        </v-flex>
      </v-layout>
    </div>
  </v-content>
</template>

<script>
export default {
  metaInfo: {
    title: 'Label'
  },
  data() {
    return {
      hover: false,
      text: 'abc',
      items: [
        { title: 'Dashboard', icon: 'mdi-view-dashboard' },
        { title: 'Photos', icon: 'mdi-image' },
        { title: 'About', icon: 'mdi-help-box' },
        { title: 'About', icon: 'mdi-help-box' }
      ],
      right: null
    }
  },
  methods: {
    witeToClipboard() {
      const copyText = this.$el.querySelector('#target').textContent
      navigator.clipboard.writeText(copyText)
    }
  }
}
</script>

<style scoped>
.back {
  background-color: rgb(238, 235, 235);
  min-height: 700px;
}
li {
  color: rgb(68, 67, 67);
}
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
