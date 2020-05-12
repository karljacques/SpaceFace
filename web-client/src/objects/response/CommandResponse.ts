import {UserActionError} from '@/objects/response/UserActionError';

export interface CommandResponseInterface<T> {
    readonly success: boolean;
    readonly errors: UserActionError[];
    readonly data: T;
}

export class CommandResponse<T> implements CommandResponseInterface<T> {
    public constructor(
        protected  _success: boolean,
        protected  _errors: UserActionError[],
        protected _data: T | null = null,
    ) {
    }

    get success(): boolean {
        return this._success;
    }

    get errors(): UserActionError[] {
        return this._errors;
    }

    get data(): T {
        if (!this._data) {
            throw new Error('LogicException - Data not defined');
        }

        return this._data;
    }
}
