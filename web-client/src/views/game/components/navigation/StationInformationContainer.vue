<template>
    <v-card v-if="dockablesInSector.length > 0">
        <v-card-title></v-card-title>
        <v-card-text>
            <v-card v-for="dockable in dockablesInSector">
                <v-card-title></v-card-title>
                <v-card-text>
                    <v-btn @click="dock(dockable)" color="warning">Dock</v-btn>
                </v-card-text>
            </v-card>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';
    import {Dockable} from '@/objects/entity/Dockable';
    import {namespace} from 'vuex-class';
    import {Location} from '@/objects/entity/Location';
    import {Ship} from '@/objects/entity/Ship';

    const ship = namespace('ship');

    @Component
    export default class StationInformationContainer extends Vue {
        @ship.Getter
        protected nearbyDockables!: Dockable[];

        @ship.Getter
        protected currentShip!: Ship;

        @ship.Action
        protected dock!: (dockable: Dockable) => void;

        get currentLocation(): Location {
            return this.currentShip.location;
        }

        get dockablesInSector(): Dockable[] {
            return this.nearbyDockables.filter((x: Dockable) => x.location.equals(this.currentLocation));
        }
    }
</script>

<style scoped>

</style>
