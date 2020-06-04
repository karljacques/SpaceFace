<template>
    <v-card>
        <v-card-title>Docked</v-card-title>
        <v-card-text>
            <v-btn :disabled="isCooldownActive" @click="undock" color="error">Undock</v-btn>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">

    import {namespace} from 'vuex-class';
    import {Component, Vue} from 'vue-property-decorator';

    const ship = namespace('ship');

    @Component({})
    export default class DockedOverview extends Vue {

        @ship.Getter
        protected isCooldownActive!: boolean;

        @ship.Action
        protected undock!: () => void;
    }
</script>

<style scoped>

</style>
