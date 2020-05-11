import 'reflect-metadata';

import {MovementAPIController} from '@/services/api/ship/MovementAPIController';
import {HttpInterface} from '@/services/connectivity/HttpInterface';
import {Container} from 'inversify';
import {CommandResponse} from '@/objects/response/CommandResponse';

const responseData = {
    success: true,
    data: {
        sector: {
            entryNodes: [],
            sector: [
                {
                    type: 3,
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
            ],
            dockables: [],
        },
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
        system: {
            sectors: [
                {
                    type: 3,
                    location: {
                        system: {
                            id: 5,
                            name: 'Schroeder',
                            designation: 'Q5',
                        },
                        position: {
                            x: 1,
                            y: 1,
                        },
                    },
                },
                {
                    type: 3,
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
                {
                    type: 1,
                    location: {
                        system: {
                            id: 5,
                            name: 'Schroeder',
                            designation: 'Q5',
                        },
                        position: {
                            x: 2,
                            y: 3,
                        },
                    },
                },
                {
                    type: 2,
                    location: {
                        system: {
                            id: 5,
                            name: 'Schroeder',
                            designation: 'Q5',
                        },
                        position: {
                            x: 3,
                            y: 1,
                        },
                    },
                },
                {
                    type: 3,
                    location: {
                        system: {
                            id: 5,
                            name: 'Schroeder',
                            designation: 'Q5',
                        },
                        position: {
                            x: 3,
                            y: 3,
                        },
                    },
                },
                {
                    type: 2,
                    location: {
                        system: {
                            id: 5,
                            name: 'Schroeder',
                            designation: 'Q5',
                        },
                        position: {
                            x: 4,
                            y: 1,
                        },
                    },
                },
                {
                    type: 1,
                    location: {
                        system: {
                            id: 5,
                            name: 'Schroeder',
                            designation: 'Q5',
                        },
                        position: {
                            x: 4,
                            y: 2,
                        },
                    },
                },
                {
                    type: 1,
                    location: {
                        system: {
                            id: 5,
                            name: 'Schroeder',
                            designation: 'Q5',
                        },
                        position: {
                            x: 4,
                            y: 3,
                        },
                    },
                },
            ],
            dockables: [],
            entryNodes: [],
        },
    },
};

describe('MovementAPIController', () => {
    describe('when the api returns a successful response', () => {

        const httpMock = jest.fn();
        httpMock.mockImplementation(() => {
            return {
                post: () => {
                    return responseData;
                },
            };
        });

        const httpMockImpl = new httpMock();
        const container = new Container();
        container.bind<HttpInterface>(HttpInterface).toConstantValue(httpMockImpl);

        container.bind<MovementAPIController>(MovementAPIController).toConstantValue(new MovementAPIController());

        const controller = container.get(MovementAPIController);

        const response = controller.moveInDirection('direction');

        it('should create a CommandResponse object', () => {
            response.then((data: any) => {
                expect(data).toBeInstanceOf(CommandResponse);
            });
        });
    });
});
