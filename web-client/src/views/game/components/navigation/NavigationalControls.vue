<template>
    <v-card width="230">
        <v-card-text>
            <div style="text-align: center">
                <v-btn :disabled="movementDisabled" :style="{visibility: getVisibility(0, 1)}"
                       @click="onClickDirection(0, 1)" icon
                       large>
                    <i class="fa fa-3x fa-caret-up"></i></v-btn>
                <br>
                <v-btn :disabled="movementDisabled" :style="{visibility: getVisibility(-1, 0)}"
                       @click="onClickDirection(-1, 0)" icon
                       large>
                    <i class="fa fa-3x fa-caret-left"></i></v-btn>
                <v-btn @click="refresh" icon large><i class="fa fa fa-square"></i></v-btn>

                <v-btn :disabled="movementDisabled" :style="{visibility: getVisibility(1, 0)}"
                       @click="onClickDirection(1, 0)" icon
                       large>
                    <i class="fa fa-3x fa-caret-right"></i></v-btn>
                <br>
                <v-btn :disabled="movementDisabled" :style="{visibility: getVisibility(0, -1)}"
                       @click="onClickDirection(0, -1)" icon
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
    import {Vector2} from '@/objects/entity/Vector2';

    const ship = namespace('ship');

    @Component({})
    export default class NavigationalControls extends Vue {
        @ship.Action
        protected moveInDirection!: (direction: Vector2) => void;

        @ship.Action
        protected refresh!: () => void;

        @ship.Getter
        protected isCooldownActive!: boolean

        @ship.Getter
        protected currentShip!: Ship

        protected async onClickDirection(x: number, y: number) {
            this.moveInDirection(new Vector2(x, y));
        }

        get movementDisabled(): boolean {
            return this.isCooldownActive || this.currentShip.power < 50 || this.currentShip.docked;
        }

        protected getVisibility(x: number, y: number): string {
            if (this.currentShip.docked) {
                return 'hidden';
            }

            return 'visible';
        }
    }
</script>
