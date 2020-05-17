import 'reflect-metadata';

import {Container} from 'inversify';
import {buildProviderModule} from 'inversify-binding-decorators';
import {AxiosHttp} from '@/services/connectivity/AxiosHttp';
import {HttpClient} from '@/services/connectivity/HttpClient';

import '@/services/connectivity/HttpClient';
import '@/services/connectivity/WebSocket';
import '@/services/api/ship/MovementAPIController';
import '@/services/api/ship/StatusAPIController';

const container = new Container();
container.load(buildProviderModule());

const http = new AxiosHttp({
    baseURL: 'http://localhost:9501',
    headers: {
        'X-AUTH-TOKEN': '73d0e731888687f8dd1413215b5de938',
    },
});

container.bind<HttpClient>(HttpClient).toConstantValue(http);

export {container};
