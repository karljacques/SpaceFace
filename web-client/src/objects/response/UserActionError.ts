import {HttpError} from '@/services/connectivity/interface/HttpError';

export class UserActionError {
    constructor(protected message: string, protected details: object) {
    }

    public static fromHttpError(error: HttpError) {
        if (error.response?.data?.errors == null) {
            return ['Server Communication Failure'];
        }

        return error.response.data.errors.map((x: any) => new UserActionError(x.message, x.details));
    }
}
