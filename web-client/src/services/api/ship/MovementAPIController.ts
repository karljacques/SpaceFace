import {AbstractAPIController} from '@/services/api/AbstractAPIController';
import {provide} from 'inversify-binding-decorators';
import {CommandResponse} from '@/objects/response/CommandResponse';
import {HttpError} from '@/services/connectivity/interface/HttpError';
import {UserActionError} from '@/objects/response/UserActionError';
import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {inject} from 'inversify';
import {StatusResponseFactory} from '@/services/factory/StatusResponseFactory';

@provide(MovementAPIController)
export class MovementAPIController extends AbstractAPIController {
    @inject(StatusResponseFactory) protected statusResponseFactory!: StatusResponseFactory;

    public async moveInDirection(direction: string): Promise<CommandResponse<StatusResponseData>> {
        const request = {
            direction,
        };

        const uri = '/move';

        try {
            const response = await this.http.post(uri, request);

            return new CommandResponse<StatusResponseData>(
                response.data.success,
                [],
                this.statusResponseFactory.createStatusResponse(response.data.data));
        } catch (e) {
            const error: HttpError = e;

            return new CommandResponse<StatusResponseData>(false, UserActionError.fromHttpError(error));
        }
    }
}
