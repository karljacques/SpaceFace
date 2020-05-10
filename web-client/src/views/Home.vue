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
    import {Component, Vue} from 'vue-property-decorator';

    import {http} from '@/services/connectivity/http';
    import {WebSocketClient} from '@/services/connectivity/websocket';
    import NavigationalControls from '@/views/game/components/navigation/NavigationalControls.vue';

    @Component({
        components: {NavigationalControls}
    })
    export default class Home extends Vue {
        protected x: number = 0;
        protected y: number = 0;
        protected systemDesignation: string = '';

        protected entryNodes: any[] = [];

        protected ws!: WebSocketClient;

        public async created() {
            this.ws = new WebSocketClient();
            //
            // this.ws.connect();
            // this.refreshStatus();
        }



        protected async jump(node: number) {
            const response = await http.post('/jump', {
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
