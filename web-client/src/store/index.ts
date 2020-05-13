import Vue from 'vue';
import Vuex from 'vuex';
import {ShipModule} from '@/store/modules/ShipModule';
import {SystemDataModule} from '@/store/modules/SystemDataModule';

Vue.use(Vuex);

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        ship: ShipModule,
        systemData: SystemDataModule,
    },
});
