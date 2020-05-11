<template>
    <v-card width="230">
        <v-card-text>
            System: {{ currentLocation.system.designation }} ({{ currentLocation.system.name }})<br>
            X: {{ currentLocation.position.x }}<br>
            Y: {{ currentLocation.position.y }}<br>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import {VueContainer} from '@/VueContainer';
    import Component from 'vue-class-component';
    import {namespace} from 'vuex-class';
    import {Location} from '@/objects/entity/Location';

    const ship = namespace('ship');

    @Component({})
    export default class NavigationalInformation extends VueContainer {
        @ship.Getter
        protected currentLocation!: Location;

    }
</script>

<style scoped>

</style>
