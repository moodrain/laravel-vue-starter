import Vue from 'vue'
import App from './App.vue'
import router from './router'
import './plugins/element'
import axios from 'axios'
import http from './utils/http'
import './plugins/element.js'

import MenuComponent from './components/Menu.vue'
import HeaderComponent from './components/Header.vue'

Vue.prototype.appName = process.env.VUE_APP_NAME
Vue.prototype.defaultPage = process.env.VUE_APP_DEFAULT_PAGE
Vue.prototype.defaultPageName = process.env.VUE_APP_DEFAULT_PAGE_NAME

Vue.component('m-menu', MenuComponent)
Vue.component('m-header', HeaderComponent)

Vue.config.productionTip = false
Vue.prototype.$axios = axios

Vue.prototype.$req = http.req
Vue.prototype.$get = http.get
Vue.prototype.$post = http.post
Vue.prototype.$put = http.put
Vue.prototype.$patch = http.patch
Vue.prototype.$delete = http.del

Vue.prototype.$noty = (msg) => {
    Vue.prototype.$notify({
        message: msg,
        type: 'warning',
        duration: 0,
    })
}
http.setDefaultErrHandler((msg, data) => {
    Vue.prototype.$noty(msg)
})
Vue.prototype.$http = http

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')

