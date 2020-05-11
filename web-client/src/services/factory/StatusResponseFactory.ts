import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {Location} from '@/objects/entity/Location';
import {Ship} from '@/objects/entity/Ship';
import {provide} from 'inversify-binding-decorators';

@provide(StatusResponseFactory)
export class StatusResponseFactory {
    public createStatusResponse(data: any): StatusResponseData {
        const shipData = data.player.ship;
        const location = Location.create(shipData.location);

        const ship = new Ship(location);

        ship.fuel = shipData.fuel;
        ship.maxFuel = shipData.maxFuel;

        return new StatusResponseData(ship);
    }
}
