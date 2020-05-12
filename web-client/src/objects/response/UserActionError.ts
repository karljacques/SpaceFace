import {HttpError} from '@/services/connectivity/interface/HttpError';

export class UserActionError {
    constructor(protected _message: string, protected details: object) {
    }

    get message(): string {
        return this._message;
    }

    public static fromHttpError(error: HttpError): UserActionError[] {
        if (error.response?.data?.errors == null) {
            return [new UserActionError('Server Communication Failure', [])];
        }

        return error.response.data.errors.map((x: any) => new UserActionError(x.message, x.details));
    }
}
