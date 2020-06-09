import 'reflect-metadata';

import {Container} from 'inversify';
import {buildProviderModule} from 'inversify-binding-decorators';
import {AxiosHttp} from '@/services/connectivity/AxiosHttp';
import {HttpClient} from '@/services/connectivity/HttpClient';

import '@/services/api/ship/MovementAPIController';
import '@/services/api/ship/StatusAPIController';
import '@/services/api/economy/MarketplaceAPIController';
import {WebSocketClient} from '@/services/connectivity/WebSocket';

const container = new Container();
container.load(buildProviderModule());

const http = new AxiosHttp({
    baseURL: 'http://localhost:9501',
});


container.bind<HttpClient>(HttpClient).toConstantValue(http);
container.get(WebSocketClient).connect();

export {container};
