<template>
    <v-card v-if="jumpNodesInSector.length > 0">
        <v-card-title>Jump Nodes</v-card-title>
        <v-card-text>
            <div v-for="node in jumpNodesInSector">
                {{ node.id }}
            </div>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';
    import {namespace} from 'vuex-class';
    import {JumpNode} from '@/objects/entity/JumpNode';
    import {Location} from '@/objects/entity/Location';
    import {Ship} from '@/objects/entity/Ship';

    const ship = namespace('ship');

    @Component
    export default class JumpNodeInformation extends Vue {
        @ship.Getter
        protected nearbyJumpNodes!: JumpNode[];

        @ship.Getter
        protected currentShip!: Ship;

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
