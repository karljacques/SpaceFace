<template>
    <div>
        <navigational-controls></navigational-controls>
        <br>
        <navigational-information v-if="shipLoaded"></navigational-information>
        <br>
        <general-status v-if="shipLoaded"></general-status>
    </div>
</template>

<script lang="ts">
    import {Component} from 'vue-property-decorator';

    import NavigationalControls from '@/views/game/components/navigation/NavigationalControls.vue';
    import {VueContainer} from '@/VueContainer';
    import NavigationalInformation from '@/views/game/components/navigation/NavigationalInformation.vue';
    import {namespace} from 'vuex-class';
    import GeneralStatus from '@/views/game/components/status/GeneralStatus.vue';

    const ship = namespace('ship');

    @Component({
        components: {GeneralStatus, NavigationalInformation, NavigationalControls},
    })
    export default class PrimaryLayout extends VueContainer {
        @ship.Getter
        protected shipLoaded!: boolean;
    }
</script>

<style scoped>

</style>
