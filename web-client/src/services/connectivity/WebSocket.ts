import {provide} from 'inversify-binding-decorators';
import {inject} from 'inversify';
import {HttpInterface} from '@/services/connectivity/HttpInterface';

@provide(WebSocketClient)
class WebSocketClient {
    protected ws: WebSocket | null = null;
    protected http: HttpInterface;

    public constructor(@inject(HttpInterface) http: HttpInterface) {
        this.http = http;
    }

    public async connect() {
        const token = await this.getTicket();

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

    protected async getTicket(): Promise<string> {

        const response = await this.http.get('/authentication/ticket');

        return response.data.data.token;
    }
}

export {WebSocketClient};
