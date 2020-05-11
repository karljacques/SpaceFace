import {AbstractAPIController} from '@/services/api/AbstractAPIController';
import {provide} from 'inversify-binding-decorators';
import {CommandResponse} from '@/objects/response/CommandResponse';
import {MovementResponseData} from '@/objects/response/MovementResponseData';
import {Ship} from '@/objects/entity/Ship';
import {Location} from '@/objects/entity/Location';
import {HttpError} from '@/services/connectivity/interface/HttpError';
import {UserActionError} from '@/objects/response/UserActionError';

@provide(MovementAPIController)
export class MovementAPIController extends AbstractAPIController {
    public async moveInDirection(direction: string): Promise<CommandResponse<MovementResponseData>> {
        const request = {
            direction,
        };

        const uri = '/move';

        try {
            const response = await this.http.post(uri, request);

            return new CommandResponse<MovementResponseData>(
                response.data.success,
                [],
                this.createMovementResponse(response.data.data));
        } catch (e) {
            const error: HttpError = e;

            return new CommandResponse<MovementResponseData>(false, UserActionError.fromHttpError(error));
        }
    }

    protected createMovementResponse(data: any): MovementResponseData {
        const shipData = data.player.ship;
        const location = Location.create(shipData.location);

        const ship = new Ship(location);

        return new MovementResponseData(ship);
    }
}
