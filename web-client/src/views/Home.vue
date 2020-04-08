<template>
    <div>
        <button @click="onClickDirection('up')">up</button>
        <br>
        <button @click="onClickDirection('left')">left</button>
        <button @click="onClickDirection('right')">right</button>
        <br>
        <button @click="onClickDirection('down')">down</button>
        <br>
        x: {{ x }}
        y: {{ y }}
    </div>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator';
    import axios from 'axios';

    @Component({})
    export default class Home extends Vue {
        protected x: number = 0;
        protected y: number = 0;

        protected ws!: WebSocket;

        public async mounted() {

            const token = await Home.getTicket();

            this.ws = new WebSocket("ws://localhost:9502/" + token, []);

            this.ws.onmessage = function (data) {
                console.log(data);
            };
        }

        protected static async getTicket(): Promise<string> {
            const response = await axios.get('http://localhost:9501/authentication/ticket', {
                headers: {
                    "X-AUTH-TOKEN": "73d0e731888687f8dd1413215b5de938"
                }
            });

            return response.data.data.token;
        }

        protected async onClickDirection(direction: string) {
            const response = await axios.post('http://localhost:9501/move', {
                direction
            }, {
                headers: {
                    "X-AUTH-TOKEN": "73d0e731888687f8dd1413215b5de938"
                }
            });
            console.log('response');
            this.x = response.data.data.ship.location.position.x;
            this.y = response.data.data.ship.location.position.y;
        }
    }
</script>

<style scoped>

</style>
