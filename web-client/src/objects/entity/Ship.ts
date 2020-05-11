export class Ship {
    private _systemId: number = 0;

    get systemId(): number {
        return this._systemId;
    }

    set systemId(value: number) {
        this._systemId = value;
    }

    private _x: number = 0;

    get x(): number {
        return this._x;
    }

    set x(value: number) {
        this._x = value;
    }

    private _y: number = 0;

    get y(): number {
        return this._y;
    }

    set y(value: number) {
        this._y = value;
    }
}
