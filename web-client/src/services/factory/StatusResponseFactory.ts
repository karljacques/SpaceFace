import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {Location} from '@/objects/entity/Location';
import {Ship} from '@/objects/entity/Ship';
import {provide} from 'inversify-binding-decorators';
import {Sector} from '@/objects/entity/Sector';

@provide(StatusResponseFactory)
export class StatusResponseFactory {
    public createStatusResponse(data: any): StatusResponseData {
        const shipData = data.player.ship;
        const location = Location.create(shipData.location);

        const ship = new Ship(location);

        ship.fuel = shipData.fuel;
        ship.maxFuel = shipData.maxFuel;

        const sectors: Sector[] = data.system.sectors.map((x: any): Sector => {
            return new Sector(x.type, Location.create(x.location));
        });

        return new StatusResponseData(ship, sectors);
    }
}
