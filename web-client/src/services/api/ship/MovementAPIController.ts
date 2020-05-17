import {AbstractAPIController} from '@/services/api/AbstractAPIController';
import {provide} from 'inversify-binding-decorators';
import {CommandResponse} from '@/objects/response/CommandResponse';
import {HttpError} from '@/services/connectivity/interface/HttpError';
import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {inject} from 'inversify';
import {StatusResponseFactory} from '@/services/factory/StatusResponseFactory';
import {JumpNode} from '@/objects/entity/JumpNode';
import {HttpResponse} from '@/services/connectivity/interface/HttpResponse';
import {Dockable} from '@/objects/entity/Dockable';

@provide(MovementAPIController)
export class MovementAPIController extends AbstractAPIController {
    @inject(StatusResponseFactory) protected statusResponseFactory!: StatusResponseFactory;

    public async move(direction: string): Promise<CommandResponse<StatusResponseData>> {
        const uri = '/move';

        const data = {
            direction,
        };

        return await this.makeMovementRequest(uri, data);
    }

    public async jump(jumpNode: JumpNode): Promise<CommandResponse<StatusResponseData>> {
        const uri = '/jump';

        const data = {
            node: jumpNode.id,
        };

        return await this.makeMovementRequest(uri, data);
    }

    public async dock(dockable: Dockable): Promise<CommandResponse<StatusResponseData>> {
        const uri = '/dock';

        const data = {
            dockable: dockable.id,
        };

        return await this.makeMovementRequest(uri, data);
    }

    public async undock(): Promise<CommandResponse<StatusResponseData>> {
        const uri = '/undock';

        const data = {};

        return await this.makeMovementRequest(uri, data);
    }

    private async makeMovementRequest(uri: string, data: any) {
        try {
            const response = await this.http.post(uri, data);
            return this.createResponse(response);
        } catch (e) {
            const error: HttpError = e;
            return MovementAPIController.createErrorResponse(error);
        }
    }

    private createResponse(response: HttpResponse<any>) {
        return new CommandResponse<StatusResponseData>(
            response.data.success,
            [],
            this.statusResponseFactory.createStatusResponse(response.data.data));
    }
}
