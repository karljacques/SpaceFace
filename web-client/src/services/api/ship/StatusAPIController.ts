import {AbstractAPIController} from '@/services/api/AbstractAPIController';
import {CommandResponse} from '@/objects/response/CommandResponse';
import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {inject} from 'inversify';
import {StatusResponseFactory} from '@/services/factory/StatusResponseFactory';
import {HttpError} from '@/services/connectivity/interface/HttpError';
import {UserActionError} from '@/objects/response/UserActionError';
import {provide} from 'inversify-binding-decorators';

@provide(StatusAPIController)
export class StatusAPIController extends AbstractAPIController {
    @inject(StatusResponseFactory) protected statusResponseFactory!: StatusResponseFactory;

    public async refresh(): Promise<CommandResponse<StatusResponseData>> {
        const uri = '/status';

        try {
            const response = await this.http.get(uri);

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
