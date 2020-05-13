<template>
    <v-card width="230">
        <v-card-text>
            <div style="text-align: center">
                <v-btn @click="onClickDirection('up')" icon large><i class="fa fa-3x fa-caret-up"></i></v-btn>
                <br>
                <v-btn @click="onClickDirection('left')" icon large><i class="fa fa-3x fa-caret-left"></i></v-btn>
                <v-btn icon large><i class="fa fa fa-square"></i></v-btn>

                <v-btn @click="onClickDirection('right')" icon large><i class="fa fa-3x fa-caret-right"></i></v-btn>
                <br>
                <v-btn @click="onClickDirection('down')" icon large><i class="fa fa-3x fa-caret-down"></i></v-btn>
            </div>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import {Component} from 'vue-property-decorator';
    import {VueContainer} from '@/VueContainer';
    import {namespace} from 'vuex-class';

    const ship = namespace('ship');

    @Component({})
    export default class NavigationalControls extends VueContainer {
        @ship.Action
        public moveInDirection!: (direction: string) => void;

        protected async onClickDirection(direction: string) {
            this.moveInDirection(direction);
        }

        // protected async refreshStatus() {
        //     const response = await this.http.get('/status');
        //     // this.updateFromServer(response.data.data);
        // }
    }
</script>
