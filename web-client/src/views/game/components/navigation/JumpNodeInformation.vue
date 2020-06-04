<template>
    <v-card v-if="jumpNodesInSector.length > 0">
        <v-card-title>Jump Nodes</v-card-title>
        <v-card-text>
            <v-card v-for="node in jumpNodesInSector">
                <v-card-title></v-card-title>
                <v-card-text>
                    <h3>Destination</h3>
                    <location-component :location="node.exitLocation"></location-component>
                    <v-btn :disabled="isCooldownActive" @click="jump(node)" color="warning">Jump</v-btn>
                </v-card-text>
            </v-card>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';
    import {namespace} from 'vuex-class';
    import {JumpNode} from '@/objects/entity/JumpNode';
    import {Location} from '@/objects/entity/Location';
    import {Ship} from '@/objects/entity/Ship';
    import LocationComponent from '@/views/game/components/navigation/LocationComponent.vue';

    const ship = namespace('ship');
    @Component({
        components: {LocationComponent}
    })
    export default class JumpNodeInformation extends Vue {
        @ship.Getter
        protected isCooldownActive!: boolean;

        @ship.Getter
        protected nearbyJumpNodes!: JumpNode[];

        @ship.Getter
        protected currentShip!: Ship;

        @ship.Action
        protected jump!: (node: JumpNode) => void;

        get currentLocation(): Location {
            return this.currentShip.location;
        }

        get jumpNodesInSector(): JumpNode[] {
            return this.nearbyJumpNodes.filter((node: JumpNode) => node.location.equals(this.currentLocation));
        }
    }
</script>

<style scoped>

</style>
