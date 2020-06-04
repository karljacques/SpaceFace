<template>
    <v-card width="230">
        <v-card-text>
            Fuel:
            <display-gauge :current="currentShip.fuel" :maximum="currentShip.maxFuel"/>
            <br>
            Power:
            <display-gauge :current="currentShip.power" :maximum="currentShip.maxPower"/>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import Component from 'vue-class-component';
    import DisplayGauge from '@/views/game/components/status/DisplayGauge.vue';
    import {namespace} from 'vuex-class';
    import {Ship} from '@/objects/entity/Ship';
    import {Vue} from 'vue-property-decorator';

    const ship = namespace('ship');

    @Component({
        components: {DisplayGauge}
    })
    export default class GeneralStatus extends Vue {
        @ship.Getter
        protected currentShip!: Ship;
    }
</script>

<style scoped>

</style>
