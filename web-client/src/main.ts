import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import './registerServiceWorker';
import vuetify from './plugins/vuetify';
import {container} from '@/container';

Vue.config.productionTip = false;

window.container = container;

new Vue({
    router,
    store,
    vuetify,
    render: (h) => h(App),
}).$mount('#app');
