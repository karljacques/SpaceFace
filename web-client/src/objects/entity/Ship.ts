import {Location} from '@/objects/entity/Location';

export class Ship {
    private _maxFuel: number = 0;
    private _fuel: number = 0;

    constructor(protected _location: Location) {
    }

    get location(): Location {
        return this._location;
    }

    set location(value: Location) {
        this._location = value;
    }

    get fuel(): number {
        return this._fuel;
    }

    set fuel(value: number) {
        this._fuel = value;
    }

    get maxFuel(): number {
        return this._maxFuel;
    }

    set maxFuel(value: number) {
        this._maxFuel = value;
    }
}
