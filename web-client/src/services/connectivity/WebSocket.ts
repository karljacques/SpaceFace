import {inject} from 'inversify';
import {HttpClient} from '@/services/connectivity/HttpClient';
import {sharedProvide} from '@/sharedProvide';

@sharedProvide(WebSocketClient)
class WebSocketClient {
    protected ws: WebSocket | null = null;
    protected http: HttpClient;

    protected eventMap: Record<string, Array<(data: any) => void>> = {};

    public constructor(@inject(HttpClient) http: HttpClient) {
        this.http = http;
    }

    public async connect() {
        const token = await this.getTicket();

        try {
            this.ws = new WebSocket('ws://localhost:9502/' + token, []);
            console.log('Connection open');
            this.ws.onmessage = (data) => {
                const response = JSON.parse(data.data);
                const listeners = this.eventMap[response.event] ?? [];

                for (const listener of listeners) {
                    listener(response);
                }

            };

            this.ws.onclose = () => {
                console.log('Connection Closed');
                this.connect();
            };

        } catch (e) {
            setTimeout(() => this.connect(), 5000);
        }
    }

    public on(event: string, callback: (data: any) => void): void {
        if (!this.eventMap[event]) {
            this.eventMap[event] = [];
        }
        this.eventMap[event].push(callback);
    }

    protected async getTicket(): Promise<string> {

        const response = await this.http.get('/authentication/ticket');

        return response.data.data.token;
    }
}

export {WebSocketClient};
