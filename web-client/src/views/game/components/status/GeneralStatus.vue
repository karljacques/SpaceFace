<template>
    <v-card width="230">
        <v-card-text>
            Fuel:
            <display-gauge :current="currentShip.fuel" :maximum="currentShip.maxFuel"/>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import {VueContainer} from '@/VueContainer';
    import Component from 'vue-class-component';
    import DisplayGauge from '@/views/game/components/status/DisplayGauge.vue';
    import {namespace} from 'vuex-class';
    import {Ship} from '@/objects/entity/Ship';

    const ship = namespace('ship');

    @Component({
        components: {DisplayGauge}
    })
    export default class GeneralStatus extends VueContainer {
        @ship.Getter
        protected currentShip!: Ship;
    }
</script>

<style scoped>

</style>
