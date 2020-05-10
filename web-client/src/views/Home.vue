<template>
    <div>
        <div style="width: 150px; text-align: center">
            <button class="btn" @click="onClickDirection('up')"><i class="fa fa-arrow-up"></i></button>
            <br>
            <button class="btn" @click="onClickDirection('left')"><i class="fa fa-arrow-left"></i></button>
            <button class="btn" @click="refreshStatus"><i class="fa fa-square"></i></button>

            <button class="btn" @click="onClickDirection('right')"><i class="fa fa-arrow-right"></i></button>
            <br>
            <button class="btn" @click="onClickDirection('down')"><i class="fa fa-arrow-down"></i></button>
        </div>
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
    import {Component, Vue} from 'vue-property-decorator';

    import {http} from '@/services/connectivity/http';
    import {WebSocketClient} from '@/services/connectivity/websocket';

    @Component({})
    export default class Home extends Vue {
        protected x: number = 0;
        protected y: number = 0;
        protected systemDesignation: string = '';

        protected entryNodes: any[] = [];

        protected ws!: WebSocketClient;

        public async created() {
            this.ws = new WebSocketClient();
            this.ws.connect();

            await this.refreshStatus();
        }

        protected async onClickDirection(direction: string) {
            const response = await http.post('/move', {
                direction,
            });
            console.log('response');

            this.updateFromServer(response.data.data);
        }

        protected async jump(node: number) {
            const response = await http.post('/jump', {
                node,
            });

            this.updateFromServer(response.data.data);
        }

        protected async refreshStatus() {
            const response = await http.get('/status');
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
