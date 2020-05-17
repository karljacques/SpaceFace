import {HttpClient} from '@/services/connectivity/HttpClient';
import {inject, injectable} from 'inversify';
import {HttpError} from '@/services/connectivity/interface/HttpError';
import {CommandResponse} from '@/objects/response/CommandResponse';
import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {UserActionError} from '@/objects/response/UserActionError';

@injectable()
export abstract class AbstractAPIController {
    @inject(HttpClient) protected http!: HttpClient;

    protected static createErrorResponse(error: HttpError<any>) {
        return new CommandResponse<StatusResponseData>(false, UserActionError.fromHttpError(error));
    }
}
