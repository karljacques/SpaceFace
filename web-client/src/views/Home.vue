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
                target: ({{ node.exitSystem.designation }}) {{node.exitSystem.name}}

                <button class="btn btn-primary" @click="jump(node.id)">Jump</button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';

    import {network} from "@/Network";

    @Component({})
    export default class Home extends Vue {
        protected x: number = 0;
        protected y: number = 0;
        protected systemDesignation: string = '';

        protected entryNodes: Array<any> = [];

        protected ws!: WebSocket;

        public async created() {
            this.refreshStatus();

            const token = await Home.getTicket();

            this.connect(token);


        }

        protected connect(token: string) {
            try {
                this.ws = new WebSocket("ws://localhost:9502/" + token, []);
                console.log('Connection open');
                this.ws.onmessage = function (data) {
                    console.log(data);
                };

                this.ws.onclose = () => {
                    console.log('Connection Closed');
                    this.connect(token);
                }
            } catch (e) {
                setTimeout(() => this.connect(token), 5000);
            }


        }

        protected static async getTicket(): Promise<string> {
            const response = await network.get('/authentication/ticket');

            return response.data.data.token;
        }

        protected async onClickDirection(direction: string) {
            const response = await network.post('/move', {
                direction
            });
            console.log('response');

            this.updateFromServer(response.data.data);
        }

        protected async jump(node: number) {
            const response = await network.post('/jump', {
               node
            });

            this.updateFromServer(response.data.data);
        }

        protected async refreshStatus() {
            const response = await network.get('/status');
            this.updateFromServer(response.data.data);
        }

        protected updateFromServer(data: any) {
            this.x = data.ship.location.position.x;
            this.y = data.ship.location.position.y;
            this.systemDesignation = data.ship.location.system.designation;

            this.entryNodes = data.sector.entryNodes;

        }
    }
</script>

<style scoped>

</style>
