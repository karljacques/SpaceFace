<template>
    <v-card>
        <v-card-title>Docked</v-card-title>
        <v-card-text>
            <v-btn :disabled="isCooldownActive" @click="undock" color="error">Undock</v-btn>
        </v-card-text>
        <v-tabs>
            <v-tab>Hanger Bay</v-tab>
            <v-tab>Marketplace</v-tab>
            <v-tab-item>No Ships</v-tab-item>
            <v-tab-item>
                <marketplace-component></marketplace-component>
            </v-tab-item>
        </v-tabs>
    </v-card>
</template>

<script lang="ts">

    import {namespace} from 'vuex-class';
    import {Component, Vue} from 'vue-property-decorator';
    import MarketplaceComponent from '@/views/game/components/dockable/MarketplaceComponent.vue';

    const ship = namespace('ship');

    @Component({
        components: {MarketplaceComponent}
    })
    export default class DockedOverview extends Vue {

        @ship.Getter
        protected isCooldownActive!: boolean;

        @ship.Action
        protected undock!: () => void;
    }
</script>

<style scoped>

</style>
