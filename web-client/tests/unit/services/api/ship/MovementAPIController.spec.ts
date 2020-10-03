import 'reflect-metadata';

import {MovementAPIController} from '@/services/api/ship/MovementAPIController';
import {HttpClient, mockHttpClientFactory} from '@/services/connectivity/HttpClient';
import {Container} from 'inversify';
import {CommandResponse} from '@/objects/response/CommandResponse';
import {StatusResponseFactory} from '@/services/factory/StatusResponseFactory';
import {HttpResponse} from '@/services/connectivity/interface/HttpResponse';
import {Vector2} from '@/objects/entity/Vector2';

describe('MovementAPIController', () => {
    describe('when the api returns a successful response', () => {
        const mockHttpInterface = mockHttpClientFactory();
        const mockStatusResponseFactory: StatusResponseFactory = {
            createStatusResponse: jest.fn(),
        };

        const response: HttpResponse = {
            data: {
                success: true,
            },
            status: 200,
            statusText: 'OK',
            headers: [],
            config: {},
        };

        (mockHttpInterface.post as jest.Mock).mockReturnValue(response);

        const mockResponse: any = {
            mock: 'abc',
        };

        (mockStatusResponseFactory.createStatusResponse as jest.Mock).mockReturnValue(mockResponse);

        const container = new Container();
        container.bind<HttpClient>(HttpClient).toConstantValue(mockHttpInterface);
        container.bind<StatusResponseFactory>(StatusResponseFactory).toConstantValue(mockStatusResponseFactory);

        container.bind<MovementAPIController>(MovementAPIController).to(MovementAPIController);

        const controller = container.get(MovementAPIController);

        const commandResponsePromise = controller.move(Vector2.create({x: 1, y: 1}));

        it('should create a CommandResponse object', () => {
            return commandResponsePromise.then((commandResponse: any) => {
                expect(commandResponse).toBeInstanceOf(CommandResponse);

            });
        });

        it('should contain the mock response passed', () => {
            return commandResponsePromise.then((commandResponse: any) => {
                expect(commandResponse.success).toEqual(true);
                expect(commandResponse.data).toEqual(mockResponse);
            });
        });
    });

    describe('when the api throws an error', () => {
        const mockHttpInterface = mockHttpClientFactory();
        const httpError: any = {
            data: {
                errors: [],
            },
        };

        (mockHttpInterface.post as jest.Mock).mockImplementation(() => {
            throw httpError;
        });

        const container = new Container();
        container.bind<HttpClient>(HttpClient).toConstantValue(mockHttpInterface);
        container.bind<MovementAPIController>(MovementAPIController).to(MovementAPIController);
        container.bind<StatusResponseFactory>(StatusResponseFactory).to(StatusResponseFactory);

        const controller = container.get(MovementAPIController);

        const commandResponsePromise = controller.move(Vector2.create({x: 1, y: 1}));

        it('should return a failing CommandResponse object', () => {
            return commandResponsePromise.then((commandResponse: any) => {
                expect(commandResponse).toBeInstanceOf(CommandResponse);
                expect(commandResponse.success).toEqual(false);

                expect(commandResponse.errors[0].message).toEqual('Server Communication Failure');
            });
        });
    });
});
