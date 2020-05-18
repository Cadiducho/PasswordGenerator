import Vue from 'vue'
import App from './App.vue'
import vueHeadful from 'vue-headful';
import VueClipboard from 'vue-clipboard2'

VueClipboard.config.autoSetContainer = true;
Vue.use(VueClipboard);
Vue.component('vue-headful', vueHeadful);

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
