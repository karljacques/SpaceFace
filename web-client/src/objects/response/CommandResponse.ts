export class CommandResponse<T> {
    public constructor(
        protected  _success: boolean,
        protected  _errors: string[],
        protected _data: T | null = null,
    ) {
    }

    get success(): boolean {
        return this._success;
    }

    set success(value: boolean) {
        this._success = value;
    }

    get errors(): string[] {
        return this._errors;
    }

    set errors(value: string[]) {
        this._errors = value;
    }

    get data(): T | null {
        return this._data;
    }

    set data(value: T | null) {
        this._data = value;
    }
}
