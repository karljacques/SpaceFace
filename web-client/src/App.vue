<template>
    <v-app id="inspire">
        <v-content>
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-content>
    </v-app>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';
    import {container} from '@/container';
    import {namespace} from 'vuex-class';
    import {WebSocketClient} from '@/services/connectivity/WebSocket';

    const ship = namespace('ship');

    @Component({
        provide: {
            container,
        }
    })
    export default class App extends Vue {

        protected websocketClient: WebSocketClient = container.get<WebSocketClient>(WebSocketClient);

        @ship.Action
        protected refresh!: () => void;

        public created() {
            this.refresh();

            this.$vuetify.theme.dark = true;

            this.websocketClient.connect();
        }
    }
</script>
