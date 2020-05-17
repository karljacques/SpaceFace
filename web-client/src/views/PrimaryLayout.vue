<template>
    <v-row>
        <v-col align="right">

            <navigational-controls></navigational-controls>
            <br>
            <navigational-information v-if="shipLoaded"></navigational-information>
            <br>
            <general-status v-if="shipLoaded"></general-status>
            <br>
        </v-col>
        <v-col cols="6">
            <template v-if="shipLoaded">
                <template v-if="!currentShip.docked">
                    <jump-node-information></jump-node-information>
                    <station-information-container/>
                </template>
                <template v-else>
                    <h1>Docked</h1>
                    <v-btn @click="undock" color="error">Undock</v-btn>
                </template>

            </template>

        </v-col>
        <v-col>
            <mini-map-container v-if="shipLoaded"></mini-map-container>

        </v-col>
    </v-row>
</template>

<script lang="ts">
    import {Component} from 'vue-property-decorator';

    import NavigationalControls from '@/views/game/components/navigation/NavigationalControls.vue';
    import {VueContainer} from '@/VueContainer';
    import NavigationalInformation from '@/views/game/components/navigation/NavigationalInformation.vue';
    import {namespace} from 'vuex-class';
    import GeneralStatus from '@/views/game/components/status/GeneralStatus.vue';
    import MiniMapContainer from '@/views/game/components/navigation/MiniMapContainer.vue';
    import JumpNodeInformation from '@/views/game/components/navigation/JumpNodeInformation.vue';
    import StationInformationContainer from '@/views/game/components/navigation/StationInformationContainer.vue';
    import {Ship} from '@/objects/entity/Ship';

    const ship = namespace('ship');

    @Component({
        components: {
            StationInformationContainer,
            JumpNodeInformation,
            MiniMapContainer,
            GeneralStatus,
            NavigationalInformation,
            NavigationalControls
        },
    })
    export default class PrimaryLayout extends VueContainer {
        @ship.Getter
        protected shipLoaded!: boolean;

        @ship.Getter
        protected currentShip!: Ship;

        @ship.Action
        protected undock!: () => void;
    }
</script>

<style scoped>

</style>
