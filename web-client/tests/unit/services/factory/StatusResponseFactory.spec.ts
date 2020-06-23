import 'reflect-metadata';
import {StatusResponseFactory} from '@/services/factory/StatusResponseFactory';
import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {Ship} from '@/objects/entity/Ship';
import {Location} from '@/objects/entity/Location';
import {System} from '@/objects/entity/System';
import {Vector2} from '@/objects/entity/Vector2';
import Storage from '@/objects/entity/Storage';

describe('StatusResponseFactory', () => {
    describe('when passed a valid response object', () => {
        const factory = new StatusResponseFactory();
        const data = {
            player: {
                ship: {
                    location: {
                        position: {
                            x: 5,
                            y: 2,
                        },
                        system: {
                            id: 1,
                            designation: 'D3',
                            name: 'A System',
                        },
                    },
                    fuel: 100,
                    maxFuel: 250,
                    cargo: {
                        id: 3,
                        capacity: 100,
                        capacityUsage: 25,
                        storedCommodities: [] // TODO: Add stored commodity testing
                    },
                },
            },
            system: {
                sectors: [],
                dockables: [],
                entryNodes: [],
            },
        };

        const response = factory.createStatusResponse(data);

        it('creates a StatusResponseData object', () => {
            expect(response).toBeInstanceOf(StatusResponseData);
            expect(response.ship).toBeInstanceOf(Ship);
        });

        it('correctly populates fuel information', () => {
            expect(response.ship.fuel).toEqual(100);
            expect(response.ship.maxFuel).toEqual(250);
        });

        it('correctly populates location information', () => {
            expect(response.ship.location).toBeInstanceOf(Location);

            expect(response.ship.location.system).toBeInstanceOf(System);
            expect(response.ship.location.system.id).toEqual(1);
            expect(response.ship.location.system.designation).toEqual('D3');
            expect(response.ship.location.system.name).toEqual('A System');

            expect(response.ship.location.position).toBeInstanceOf(Vector2);
            expect(response.ship.location.position.x).toEqual(5);
            expect(response.ship.location.position.y).toEqual(2);
        });

        it('correctly populates storage information', () => {
            expect(response.ship.cargo).toBeInstanceOf(Storage);

            expect(response.ship.cargo.id).toEqual(3);
            expect(response.ship.cargo.capacity).toEqual(100);
            expect(response.ship.cargo.usage).toEqual(25);


        });
    });
});
