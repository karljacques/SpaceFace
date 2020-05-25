import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import './registerServiceWorker';
import vuetify from './plugins/vuetify';
import {container} from '@/container';
import {WebSocketClient} from '@/services/connectivity/WebSocket';

Vue.config.productionTip = false;

new Vue({
    router,
    store,
    vuetify,
    render: (h) => h(App),
}).$mount('#app');

const webSocketClient = container.get(WebSocketClient);

webSocketClient.on('update', (data: any) => {
    const power = data.power;

    store.commit('ship/setPower', power);
});

webSocketClient.on('cooldownExpired', (data: any) => {
    store.commit('ship/setCooldown', false);
});
