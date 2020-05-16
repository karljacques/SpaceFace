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
            <jump-node-information></jump-node-information>
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

    const ship = namespace('ship');

    @Component({
        components: {
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
    }
</script>

<style scoped>

</style>
