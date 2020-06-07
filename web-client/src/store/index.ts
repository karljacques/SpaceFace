import Vue from 'vue';
import Vuex from 'vuex';
import ShipModule from '@/store/modules/ShipModule';

Vue.use(Vuex);

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        ship: ShipModule,
    },
});
