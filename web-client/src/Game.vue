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
    import {namespace} from 'vuex-class';
    import {WebSocketClient} from '@/services/connectivity/WebSocket';
    import {container} from '@/container';

    const ship = namespace('ship');

    @Component({})
    export default class Game extends Vue {
        @ship.Action
        protected refresh!: () => void;


        public async created() {
            this.refresh();
            await container.get(WebSocketClient).connect();

        }
    }
</script>
