import 'reflect-metadata';

import {Container} from 'inversify';
import {buildProviderModule} from 'inversify-binding-decorators';
import {AxiosHttp} from '@/services/connectivity/AxiosHttp';
import {HttpInterface} from '@/services/connectivity/HttpInterface';

import '@/services/connectivity/HttpInterface';
import '@/services/connectivity/WebSocket';
import '@/services/api/ship/MovementAPIController';

const container = new Container();
container.load(buildProviderModule());

const http = new AxiosHttp({
    baseURL: 'http://localhost:9501',
    headers: {
        'X-AUTH-TOKEN': '73d0e731888687f8dd1413215b5de938',
    },
});

container.bind<HttpInterface>(HttpInterface).toConstantValue(http);

export {container};