import 'reflect-metadata';

import {MovementAPIController} from '@/services/api/ship/MovementAPIController';
import {HttpInterface, mockHttpInterfaceFactory} from '@/services/connectivity/HttpInterface';
import {Container} from 'inversify';
import {CommandResponse} from '@/objects/response/CommandResponse';
import {StatusResponseFactory} from '@/services/factory/StatusResponseFactory';
import {HttpResponse} from '@/services/connectivity/interface/HttpResponse';

const responseData = {
    success: true,
    data: {
        player: {
            ship: {
                id: 1,
                fuel: 12,
                maxFuel: 158,
                location: {
                    system: {
                        id: 5,
                        name: 'Schroeder',
                        designation: 'Q5',
                    },
                    position: {
                        x: 2,
                        y: 1,
                    },
                },
            },
        },
    },
};

describe('MovementAPIController', () => {
    describe('when the api returns a successful response', () => {
        const mockHttpInterface = mockHttpInterfaceFactory();

        const mockResponse: HttpResponse = {
            data: responseData,
            status: 200,
            statusText: 'OK',
            headers: [],
            config: {},
        };

        (mockHttpInterface.post as jest.Mock).mockReturnValue(mockResponse);

        const container = new Container();
        container.bind<HttpInterface>(HttpInterface).toConstantValue(mockHttpInterface);

        container.bind<MovementAPIController>(MovementAPIController).to(MovementAPIController);
        container.bind<StatusResponseFactory>(StatusResponseFactory).to(StatusResponseFactory);
        const controller = container.get(MovementAPIController);

        const response = controller.moveInDirection('direction');

        it('should create a CommandResponse object', () => {
            return response.then((data: any) => {
                expect(data).toBeInstanceOf(CommandResponse);
                expect(data.success).toEqual(true);
            });
        });
    });
});
