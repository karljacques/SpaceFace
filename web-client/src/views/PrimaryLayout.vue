<template>
    <v-row v-if="shipLoaded">
        <v-col align="right">

            <navigational-controls></navigational-controls>
            <br>
            <navigational-information></navigational-information>
            <br>
            <general-status></general-status>
            <br>
            <cargo-status></cargo-status>
            <br>
            <v-btn @click="logout" color="error">Logout</v-btn>
        </v-col>
        <v-col cols="6">
            <template>
                <player-information/>
                <br>
                <template v-if="!currentShip.docked">
                    <jump-node-information></jump-node-information>
                    <station-information-container/>
                </template>
                <template v-else>
                    <docked-overview/>
                </template>

            </template>

        </v-col>
        <v-col>
            <mini-map-hex-container></mini-map-hex-container>
            <mini-map-container></mini-map-container>

        </v-col>
    </v-row>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';

    import NavigationalControls from '@/views/game/components/navigation/NavigationalControls.vue';
    import NavigationalInformation from '@/views/game/components/navigation/NavigationalInformation.vue';
    import {namespace} from 'vuex-class';
    import GeneralStatus from '@/views/game/components/status/GeneralStatus.vue';
    import MiniMapContainer from '@/views/game/components/navigation/MiniMapContainer.vue';
    import JumpNodeInformation from '@/views/game/components/navigation/JumpNodeInformation.vue';
    import StationInformationContainer from '@/views/game/components/navigation/StationInformationContainer.vue';
    import {Ship} from '@/objects/entity/Ship';
    import DockedOverview from '@/views/game/components/dockable/DockedOverview.vue';
    import CargoStatus from '@/views/game/components/status/CargoStatus.vue';
    import PlayerInformation from '@/views/game/components/status/PlayerInformation.vue';
    import MiniMapHexContainer from '@/views/game/components/navigation/MiniMapHexContainer.vue';

    const ship = namespace('ship');
    const authentication = namespace('authentication');

    @Component({
        components: {
            MiniMapHexContainer,
            PlayerInformation,
            CargoStatus,
            DockedOverview,
            StationInformationContainer,
            JumpNodeInformation,
            MiniMapContainer,
            GeneralStatus,
            NavigationalInformation,
            NavigationalControls
        },
    })
    export default class PrimaryLayout extends Vue {
        @authentication.Action
        protected logout!: () => void;

        @ship.Getter
        protected shipLoaded!: boolean;

        @ship.Getter
        protected currentShip!: Ship;
    }
</script>

<style scoped>

</style>
