import {http} from '@/services/connectivity/http';

class WebSocketClient {
    protected ws: WebSocket | null = null;

    protected static async getTicket(): Promise<string> {
        const response = await http.get('/authentication/ticket');

        return response.data.data.token;
    }

    public connect() {
        const token = WebSocketClient.getTicket();

        try {
            this.ws = new WebSocket('ws://localhost:9502/' + token, []);
            console.log('Connection open');
            this.ws.onmessage = (data) => {
                console.log(data);
            };

            this.ws.onclose = () => {
                console.log('Connection Closed');
                this.connect();
            };

        } catch (e) {
            setTimeout(() => this.connect(), 5000);
        }
    }
}

export {WebSocketClient};
