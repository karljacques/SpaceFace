<template>
    <v-card width="230">
        <v-card-text>
            <div style="text-align: center">
                <v-btn @click="onClickDirection('up')" text><i class="fa fa-2x fa-arrow-up"></i></v-btn>
                <br>
                <v-btn @click="onClickDirection('left')" text><i class="fa fa-2x fa-arrow-left"></i></v-btn>
                <v-btn text><i class="fa fa-2x fa-square"></i></v-btn>

                <v-btn @click="onClickDirection('right')" text><i class="fa fa-2x fa-arrow-right"></i></v-btn>
                <br>
                <v-btn @click="onClickDirection('down')" text><i class="fa fa-2x fa-arrow-down"></i></v-btn>
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
