import { createApp } from 'vue'
import { createI18n } from 'vue-i18n'

import App from './App.vue'
import router from './router'

import './assets/mystyles.css';
import './assets/fontawesome/css/all.css';


const messages = {
    cz: {
      message: {
        hello: 'Ahoj!'
      }
    },
    en: {
      message: {
        hello: 'Hello!'
      }
    }
}

// #TODO: translate
const i18n = createI18n({
    locale: 'cz',
    fallbackLocale: 'cz',
    messages,
  });
const app = createApp(App);

app.config.unwrapInjectedRef = true;

app.use(router);
app.use(i18n);

app.mount('#app');
