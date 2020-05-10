<template>
    <v-card width="230">
        <v-card-text>
            <div style="text-align: center">
                <v-btn @click="onClickDirection('up')" text><i class="fa fa-2x fa-arrow-up"></i></v-btn>
                <br>
                <v-btn @click="onClickDirection('left')" text><i class="fa fa-2x fa-arrow-left"></i></v-btn>
                <v-btn @click="refreshStatus" text><i class="fa fa-2x fa-square"></i></v-btn>

                <v-btn @click="onClickDirection('right')" text><i class="fa fa-2x fa-arrow-right"></i></v-btn>
                <br>
                <v-btn @click="onClickDirection('down')" text><i class="fa fa-2x fa-arrow-down"></i></v-btn>
            </div>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
    import {Component} from 'vue-property-decorator';
    import {HttpInterface} from '@/services/connectivity/HttpInterface';
    import {VueContainer} from '@/VueContainer';

    @Component({})
    export default class NavigationalControls extends VueContainer {
        protected http: HttpInterface = this.container.get<HttpInterface>(HttpInterface);

        protected async onClickDirection(direction: string) {
            debugger;
            const response = await this.http.post('/move', {
                direction,
            });

            // this.updateFromServer(response.data.data);
        }

        protected async refreshStatus() {
            const response = await this.http.get('/status');
            // this.updateFromServer(response.data.data);
        }
    }
</script>
