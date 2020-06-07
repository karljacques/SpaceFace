<template>
    <v-card width="230">
        <v-card-text>
            Cargo:
            <display-gauge
                    :current="currentShip.cargo.usage"
                    :invert="true"
                    :maximum="currentShip.cargo.capacity"
            />
            <hr>
            <div v-for="storedCommodity in currentShip.cargo.storedCommodities">
                {{ storedCommodity.commodity.name }} x {{ storedCommodity.quantity }} ({{ storedCommodity.commodity.size
                * storedCommodity.quantity }})
            </div>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';
    import {namespace} from 'vuex-class';
    import {Ship} from '@/objects/entity/Ship';
    import DisplayGauge from '@/views/game/components/status/DisplayGauge.vue';

    const ship = namespace('ship');
    @Component({
        components: {DisplayGauge}
    })
    export default class CargoStatus extends Vue {
        @ship.Getter
        protected currentShip!: Ship;
    }
</script>

<style scoped>

</style>
