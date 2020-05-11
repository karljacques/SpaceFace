import {AbstractAPIController} from '@/services/api/AbstractAPIController';
import {provide} from 'inversify-binding-decorators';
import {CommandResponse} from '@/objects/response/CommandResponse';
import {MovementResponseData} from '@/objects/response/MovementResponseData';
import {Ship} from '@/objects/entity/Ship';

@provide(MovementAPIController)
export class MovementAPIController extends AbstractAPIController {
    public async moveInDirection(direction: string): Promise<CommandResponse<MovementResponseData>> {
        const request = {
            direction,
        };

        const uri = '/move';

        const response = await this.http.post(uri, request);


        return new CommandResponse<MovementResponseData>(
            response.data.success,
            response.data?.errors ?? [],
            response.data.success ? this.createMovementResponse(response.data.data) : null,
        );
    }

    protected createMovementResponse(data: any): MovementResponseData {
        const ship = new Ship();

        ship.systemId = data.player.ship.location.system.id;
        ship.x = data.player.ship.location.position.x;
        ship.y = data.player.ship.location.position.y;

        return new MovementResponseData(ship);
    }
}
