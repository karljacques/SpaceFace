import {AbstractAPIController} from '@/services/api/AbstractAPIController';
import {inject} from 'inversify';
import {StatusResponseFactory} from '@/services/factory/StatusResponseFactory';
import {CommandResponse} from '@/objects/response/CommandResponse';
import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {JumpNode} from '@/objects/entity/JumpNode';
import {HttpError} from '@/services/connectivity/interface/HttpError';
import {UserActionError} from '@/objects/response/UserActionError';
import {provide} from 'inversify-binding-decorators';

@provide(JumpAPIController)
export class JumpAPIController extends AbstractAPIController {
    @inject(StatusResponseFactory) protected statusResponseFactory!: StatusResponseFactory;

    public async jump(jumpNode: JumpNode): Promise<CommandResponse<StatusResponseData>> {
        const uri = '/jump';

        const data = {
            node: jumpNode.id,
        };

        try {
            const response = await this.http.post(uri, data);

            return new CommandResponse<StatusResponseData>(
                response.data.success,
                [],
                this.statusResponseFactory.createStatusResponse(response.data.data),
            );
        } catch (e) {
            const error: HttpError = e;

            return new CommandResponse<StatusResponseData>(false, UserActionError.fromHttpError(error));
        }
    }
}
