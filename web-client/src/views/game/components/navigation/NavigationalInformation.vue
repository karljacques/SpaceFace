<template>
    <v-card width="230">
        <v-card-text>
            <location-component :location="currentLocation"/>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import Component from 'vue-class-component';
    import {namespace} from 'vuex-class';
    import {Ship} from '@/objects/entity/Ship';
    import LocationComponent from '@/views/game/components/navigation/LocationComponent.vue';
    import {Vue} from 'vue-property-decorator';

    const ship = namespace('ship');

    @Component({
        components: {LocationComponent}
    })
    export default class NavigationalInformation extends Vue {
        @ship.Getter
        protected currentShip!: Ship;

        get currentLocation() {
            return this.currentShip.location;
        }

    }
</script>

<style scoped>

</style>
