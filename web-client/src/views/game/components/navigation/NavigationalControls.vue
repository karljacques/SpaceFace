<template>
    <v-card width="230">
        <v-card-text>
            <div style="text-align: center">
                <v-btn :disabled="movementDisabled" :style="{visibility: getVisibility('up')}"
                       @click="onClickDirection('up')" icon
                       large>
                    <i class="fa fa-3x fa-caret-up"></i></v-btn>
                <br>
                <v-btn :disabled="movementDisabled" :style="{visibility: getVisibility('left')}"
                       @click="onClickDirection('left')" icon
                       large>
                    <i class="fa fa-3x fa-caret-left"></i></v-btn>
                <v-btn @click="refresh" icon large><i class="fa fa fa-square"></i></v-btn>

                <v-btn :disabled="movementDisabled" :style="{visibility: getVisibility('right')}"
                       @click="onClickDirection('right')" icon
                       large>
                    <i class="fa fa-3x fa-caret-right"></i></v-btn>
                <br>
                <v-btn :disabled="movementDisabled" :style="{visibility: getVisibility('down')}"
                       @click="onClickDirection('down')" icon
                       large>
                    <i class="fa fa-3x fa-caret-down"></i></v-btn>
            </div>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';
    import {namespace} from 'vuex-class';
    import {Ship} from '@/objects/entity/Ship';

    const ship = namespace('ship');

    @Component({})
    export default class NavigationalControls extends Vue {
        @ship.Action
        protected moveInDirection!: (direction: string) => void;

        @ship.Action
        protected refresh!: () => void;

        @ship.Getter
        protected isCooldownActive!: boolean

        @ship.Getter
        protected currentShip!: Ship

        protected async onClickDirection(direction: string) {
            this.moveInDirection(direction);
        }

        get movementDisabled(): boolean {
            return this.isCooldownActive || this.currentShip.power < 50 || this.currentShip.docked;
        }

        protected getVisibility(direction: string): string {
            if (this.currentShip.docked) {
                return 'hidden';
            }

            return 'visible';
        }
    }
</script>
