/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

// window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// import _ from 'lodash'
import * as bootstrap from 'bootstrap'
import Vue from 'vue'
import VueMeta from 'vue-meta'
import VueToast from 'vue-toast-notification'
// import VueProgressBar from 'vue-progressbar'
import VueSweetAlert from 'vue-sweetalert2'
import VueLoading from 'vue-loading-template'
import router from './router'
import store from './store'
import { setHeaderToken } from './utils/auth'
import moment from 'moment'
import 'moment/locale/id'
// import chalk from 'chalk'
import App from './App.vue'

Vue.config.productionTip = false
Vue.prototype.$base_url = process.env.MIX_APP_URL
Vue.prototype.$app_name = process.env.MIX_APP_NAME
Vue.prototype.moment = moment

const token = localStorage.getItem(process.env.MIX_APP_SESSION_LOCAL_STORAGE_NAME)
if (token) {
  setHeaderToken(token)
}

Vue.use(VueMeta)
Vue.use(VueToast, {
  position: 'top-right'
})
Vue.use(VueSweetAlert)
Vue.use(VueLoading)

store
  .dispatch('get_user', token)
  .then(() => {
    new Vue({
      router,
      store,
      render: (h) => h(App),
      mounted() {
        //
      }
    }).$mount('#app')
  })
  .catch((error) => {
    console.log(error)
  })
