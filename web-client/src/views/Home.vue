<template>
    <div>
        <navigational-controls></navigational-controls>
        <br>
        system: {{ systemDesignation }}
        x: {{ x }}
        y: {{ y }}

        <div v-if="entryNodes">
            <div v-for="node in entryNodes">
                target: ({{ node.exitLocation.system.designation }}) {{node.exitLocation.system.name}}

                <button class="btn btn-primary" @click="jump(node.id)">Jump</button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import {Component} from 'vue-property-decorator';

    import {WebSocketClient} from '@/services/connectivity/WebSocket';
    import NavigationalControls from '@/views/game/components/navigation/NavigationalControls.vue';
    import {HttpInterface} from '@/services/connectivity/HttpInterface';
    import {VueContainer} from '@/VueContainer';

    @Component({
        components: {NavigationalControls},
    })
    export default class Home extends VueContainer {
        protected x: number = 0;
        protected y: number = 0;
        protected systemDesignation: string = '';

        protected entryNodes: any[] = [];

        protected http: HttpInterface = this.container.get<HttpInterface>(HttpInterface);
        protected ws: WebSocketClient = this.container.get<WebSocketClient>(WebSocketClient);

        public async created() {
            //
            // this.ws.connect();
            // this.refreshStatus();
        }


        protected async jump(node: number) {
            const response = await this.http.post('/jump', {
                node,
            });

            this.updateFromServer(response.data.data);
        }


        protected updateFromServer(data: any) {
            this.x = data.player.ship.location.position.x;
            this.y = data.player.ship.location.position.y;
            this.systemDesignation = data.player.ship.location.system.designation;

            this.entryNodes = data.sector.entryNodes;

        }
    }
</script>

<style scoped>

</style>
