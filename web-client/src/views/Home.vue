<template>
    <div>
        <navigational-controls></navigational-controls>
        <br>
        <navigational-information v-if="shipLoaded"></navigational-information>

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
    import NavigationalInformation from '@/views/game/components/navigation/NavigationalInformation.vue';
    import {namespace} from 'vuex-class';

    const ship = namespace('ship');

    @Component({
        components: {NavigationalInformation, NavigationalControls},
    })
    export default class Home extends VueContainer {

        @ship.Getter
        protected shipLoaded!: boolean;

        protected entryNodes: any[] = [];

        protected http: HttpInterface = this.get(HttpInterface);
        protected ws: WebSocketClient = this.get(WebSocketClient);

        public async created() {
            //
            // this.ws.connect();
            // this.refreshStatus();
        }


        protected async jump(node: number) {
            const response = await this.http.post('/jump', {
                node,
            });
        }

    }
</script>

<style scoped>

</style>
